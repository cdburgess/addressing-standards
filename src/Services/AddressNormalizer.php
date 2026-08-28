<?php

namespace Cdburgess\AddressingStandards\Services;

use Cdburgess\AddressingStandards\Address;
use Cdburgess\AddressingStandards\Contracts\AddressNormalizer as AddressNormalizerContract;
use Cdburgess\AddressingStandards\Handlers\SecondaryUnitHandler;
use Cdburgess\AddressingStandards\Parsers\LastLineParser;
use Cdburgess\AddressingStandards\Parsers\StreetAddressParser;
use Cdburgess\AddressingStandards\Support\AddressCleaner;
use Cdburgess\AddressingStandards\Tables\Directionals;
use Cdburgess\AddressingStandards\Tables\States;
use Cdburgess\AddressingStandards\Tables\StreetSuffixes;

class AddressNormalizer implements AddressNormalizerContract
{
    public function __construct(
        protected StreetAddressParser $streetParser = new StreetAddressParser(),
        protected LastLineParser $lastLineParser = new LastLineParser(),
        protected SecondaryUnitHandler $secondaryHandler = new SecondaryUnitHandler(),
    ) {}

    public function normalize(string|array $input): Address
    {
        $components = is_string($input)
            ? $this->parseStringInput($input)
            : $this->parseArrayInput($input);

        $standardized = $this->applyStandards($components);

        $address = new Address(
            recipient: $standardized['recipient'] ?? null,
            firm: $standardized['firm'] ?? null,
            primaryNumber: $standardized['primaryNumber'] ?? null,
            preDirectional: $standardized['preDirectional'] ?? null,
            streetName: $standardized['streetName'] ?? null,
            suffix: $standardized['suffix'] ?? null,
            postDirectional: $standardized['postDirectional'] ?? null,
            secondaryDesignator: $standardized['secondaryDesignator'] ?? null,
            secondaryNumber: $standardized['secondaryNumber'] ?? null,
            urbanization: $standardized['urbanization'] ?? null,
            city: $standardized['city'] ?? null,
            state: $standardized['state'] ?? null,
            zip5: $standardized['zip5'] ?? null,
            zip4: $standardized['zip4'] ?? null,
            rawInput: is_string($input) ? $input : json_encode($input),
            corrections: $standardized['corrections'] ?? [],
        );

        return $this->appendOutputCorrection($address, $input);
    }

    protected function appendOutputCorrection(Address $address, string|array $input): Address
    {
        $raw = is_string($input)
            ? strtoupper(trim(preg_replace('/\s+/', ' ', $input) ?? ''))
            : strtoupper(trim(preg_replace('/\s+/', ' ', implode(' ', array_filter($input))) ?? ''));

        $standardized = strtoupper(trim($address->toString()));

        if ($raw === '' || $raw === $standardized) {
            return $address;
        }

        $corrections = $address->corrections;
        $corrections[] = [
            'field' => 'address',
            'from' => is_string($input) ? $input : json_encode($input),
            'to' => $address->toBlock(),
        ];

        return $address->with(['corrections' => $corrections]);
    }

    protected function parseStringInput(string $input): array
    {
        $lines = AddressCleaner::lines($input);

        $result = [
            'recipient' => null,
            'firm' => null,
            'city' => null,
            'state' => null,
            'zip5' => null,
            'zip4' => null,
            'urbanization' => null,
        ];

        if ($lines === []) {
            return $result;
        }

        $lastLine = array_pop($lines);
        $result = array_merge($result, $this->lastLineParser->parse($lastLine));

        if ($lines !== []) {
            $deliveryLine = array_pop($lines);
            $result = array_merge($result, $this->streetParser->parse($deliveryLine));
        }

        if ($lines !== []) {
            $maybeUrb = end($lines);

            if (preg_match('/^URB(?:ANIZATION)?\s+/i', (string) $maybeUrb)) {
                $urbLine = array_pop($lines);
                $urbParts = $this->streetParser->parse($urbLine);
                $result['urbanization'] = $urbParts['urbanization'] ?? strtoupper($urbLine);
            }
        }

        if ($lines !== []) {
            $result['recipient'] = $lines[0] ?? null;
            $result['firm'] = $lines[1] ?? null;
        }

        return $result;
    }

    protected function parseArrayInput(array $input): array
    {
        $map = [
            'recipient' => $input['recipient'] ?? $input['name'] ?? null,
            'firm' => $input['firm'] ?? $input['company'] ?? null,
            'primaryNumber' => $input['primary_number'] ?? $input['primaryNumber'] ?? $input['street_number'] ?? null,
            'preDirectional' => $input['pre_directional'] ?? $input['preDirectional'] ?? null,
            'streetName' => $input['street_name'] ?? $input['streetName'] ?? $input['street'] ?? null,
            'suffix' => $input['suffix'] ?? $input['street_suffix'] ?? null,
            'postDirectional' => $input['post_directional'] ?? $input['postDirectional'] ?? null,
            'secondaryDesignator' => $input['secondary_designator'] ?? $input['secondaryDesignator'] ?? $input['unit_type'] ?? null,
            'secondaryNumber' => $input['secondary_number'] ?? $input['secondaryNumber'] ?? $input['unit'] ?? $input['apt'] ?? null,
            'urbanization' => $input['urbanization'] ?? null,
            'city' => $input['city'] ?? null,
            'state' => $input['state'] ?? null,
            'zip5' => $input['zip5'] ?? $input['zip'] ?? $input['postal_code'] ?? null,
            'zip4' => $input['zip4'] ?? null,
        ];

        if (! empty($input['address_line1']) || ! empty($input['street_line'])) {
            $line = $input['address_line1'] ?? $input['street_line'];
            $streetParts = $this->streetParser->parse(AddressCleaner::clean($line));
            $map = array_merge($map, array_filter($streetParts, fn ($value) => $value !== null && $value !== ''));
        }

        if (! empty($map['zip5']) && empty($map['zip4'])) {
            $zipParts = $this->lastLineParser->normalizeZip($map['zip5']);
            $map['zip5'] = $zipParts['zip5'];
            $map['zip4'] = $zipParts['zip4'];
        }

        return $map;
    }

    protected function applyStandards(array $components): array
    {
        $corrections = [];

        if (! empty($components['state'])) {
            $original = $components['state'];
            $standardized = States::standardize($original) ?? strtoupper($original);

            if ($standardized !== $original) {
                $corrections[] = [
                    'field' => 'state',
                    'from' => $original,
                    'to' => $standardized,
                ];
            }

            $components['state'] = $standardized;
        }

        foreach (['preDirectional', 'postDirectional'] as $field) {
            if (! empty($components[$field])) {
                $original = $components[$field];
                $standardized = Directionals::standardize($original);

                if ($standardized && $standardized !== $original) {
                    $corrections[] = [
                        'field' => $field,
                        'from' => $original,
                        'to' => $standardized,
                    ];
                }

                $components[$field] = $standardized ?: $original;
            }
        }

        if (! empty($components['suffix'])) {
            $original = $components['suffix'];
            $standardized = StreetSuffixes::standardize($original);

            if ($standardized && $standardized !== $original) {
                $corrections[] = [
                    'field' => 'suffix',
                    'from' => $original,
                    'to' => $standardized,
                ];
            }

            $components['suffix'] = $standardized ?: $original;
        }

        $originalDesignator = $components['secondaryDesignator'] ?? null;
        $originalNumber = $components['secondaryNumber'] ?? null;
        $secondary = $this->secondaryHandler->format($originalDesignator, $originalNumber);

        if ($secondary) {
            if (str_starts_with($secondary, '# ')) {
                $components['secondaryDesignator'] = null;
                $components['secondaryNumber'] = substr($secondary, 2);

                $corrections[] = [
                    'field' => 'secondary',
                    'from' => trim(($originalDesignator ?? '') . ' ' . ($originalNumber ?? '')),
                    'to' => $secondary,
                ];
            } else {
                $parts = explode(' ', $secondary, 2);
                $components['secondaryDesignator'] = $parts[0];
                $components['secondaryNumber'] = $parts[1] ?? null;

                if ($parts[0] !== $originalDesignator) {
                    $corrections[] = [
                        'field' => 'secondaryDesignator',
                        'from' => $originalDesignator,
                        'to' => $parts[0],
                    ];
                }
            }
        } else {
            $components['secondaryDesignator'] = null;
            $components['secondaryNumber'] = null;
        }

        if (! empty($components['zip5'])) {
            $originalZip = $components['zip5'] . ($components['zip4'] ?? '');
            $zipParts = $this->lastLineParser->normalizeZip($originalZip);

            if (($zipParts['zip4'] ?? null) && empty($components['zip4'])) {
                $corrections[] = [
                    'field' => 'zip',
                    'from' => $components['zip5'],
                    'to' => $zipParts['zip5'] . '-' . $zipParts['zip4'],
                ];
            }

            $components['zip5'] = $zipParts['zip5'];
            $components['zip4'] = $zipParts['zip4'];
        }

        foreach (['city', 'streetName', 'recipient', 'firm', 'urbanization'] as $field) {
            if (! empty($components[$field])) {
                $original = $components[$field];
                $upper = strtoupper($original);

                if ($upper !== $original) {
                    $corrections[] = [
                        'field' => $field,
                        'from' => $original,
                        'to' => $upper,
                    ];
                }

                $components[$field] = $upper;
            }
        }

        $components['corrections'] = $corrections;

        return $components;
    }
}