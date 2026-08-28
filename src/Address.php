<?php

namespace Cdburgess\AddressingStandards;

use Cdburgess\AddressingStandards\Contracts\AddressNormalizer as AddressNormalizerContract;
use Cdburgess\AddressingStandards\Handlers\SecondaryUnitHandler;
use Cdburgess\AddressingStandards\Services\AddressNormalizer;

readonly class Address
{
    public function __construct(
        public ?string $recipient = null,
        public ?string $firm = null,
        public ?string $primaryNumber = null,
        public ?string $preDirectional = null,
        public ?string $streetName = null,
        public ?string $suffix = null,
        public ?string $postDirectional = null,
        public ?string $secondaryDesignator = null,
        public ?string $secondaryNumber = null,
        public ?string $urbanization = null,
        public ?string $city = null,
        public ?string $state = null,
        public ?string $zip5 = null,
        public ?string $zip4 = null,
        public ?string $rawInput = null,
        public array $corrections = [],
    ) {}

    public static function normalize(string|array $input): self
    {
        if (function_exists('app')) {
            try {
                return app(AddressNormalizerContract::class)->normalize($input);
            } catch (\Throwable) {
                // Fall through to a direct instantiation outside the container.
            }
        }

        return (new AddressNormalizer())->normalize($input);
    }

    public function with(array $attributes): self
    {
        return new self(
            recipient: $attributes['recipient'] ?? $this->recipient,
            firm: $attributes['firm'] ?? $this->firm,
            primaryNumber: $attributes['primaryNumber'] ?? $this->primaryNumber,
            preDirectional: $attributes['preDirectional'] ?? $this->preDirectional,
            streetName: $attributes['streetName'] ?? $this->streetName,
            suffix: $attributes['suffix'] ?? $this->suffix,
            postDirectional: $attributes['postDirectional'] ?? $this->postDirectional,
            secondaryDesignator: $attributes['secondaryDesignator'] ?? $this->secondaryDesignator,
            secondaryNumber: $attributes['secondaryNumber'] ?? $this->secondaryNumber,
            urbanization: $attributes['urbanization'] ?? $this->urbanization,
            city: $attributes['city'] ?? $this->city,
            state: $attributes['state'] ?? $this->state,
            zip5: $attributes['zip5'] ?? $this->zip5,
            zip4: $attributes['zip4'] ?? $this->zip4,
            rawInput: $attributes['rawInput'] ?? $this->rawInput,
            corrections: $attributes['corrections'] ?? $this->corrections,
        );
    }

    public function deliveryAddressLine(): string
    {
        $parts = array_filter([
            $this->primaryNumber,
            $this->preDirectional,
            $this->streetName,
            $this->suffix,
            $this->postDirectional,
            $this->secondaryDesignator,
            $this->secondaryNumber,
        ], fn ($value) => $value !== null && $value !== '');

        return implode(' ', $parts);
    }

    public function lastLine(): string
    {
        $zip = $this->zip5;

        if ($this->zip4) {
            $zip .= '-' . $this->zip4;
        }

        $parts = array_filter([
            $this->city,
            $this->state,
            $zip,
        ], fn ($value) => $value !== null && $value !== '');

        return implode(' ', $parts);
    }

    public function toBlock(): string
    {
        $lines = array_filter([
            $this->recipient,
            $this->firm,
            $this->urbanization,
            $this->deliveryAddressLine(),
            $this->lastLine(),
        ], fn ($value) => $value !== null && $value !== '');

        return implode("\n", $lines);
    }

    public function toString(): string
    {
        return preg_replace('/\s+/', ' ', $this->toBlock()) ?? '';
    }

    public function toArray(): array
    {
        return [
            'recipient' => $this->recipient,
            'firm' => $this->firm,
            'primary_number' => $this->primaryNumber,
            'pre_directional' => $this->preDirectional,
            'street_name' => $this->streetName,
            'suffix' => $this->suffix,
            'post_directional' => $this->postDirectional,
            'secondary_designator' => $this->secondaryDesignator,
            'secondary_number' => $this->secondaryNumber,
            'urbanization' => $this->urbanization,
            'city' => $this->city,
            'state' => $this->state,
            'zip5' => $this->zip5,
            'zip4' => $this->zip4,
            'delivery_address_line' => $this->deliveryAddressLine(),
            'last_line' => $this->lastLine(),
            'raw_input' => $this->rawInput,
            'corrections' => $this->corrections,
            'completeness' => $this->completenessReport(),
        ];
    }

    public function isComplete(): bool
    {
        $hasDelivery = filled($this->streetName) || filled($this->primaryNumber);

        return $hasDelivery
            && filled($this->city)
            && filled($this->state)
            && filled($this->zip5);
    }

    public function hasIncompleteSecondary(): bool
    {
        if (! $this->secondaryDesignator) {
            return false;
        }

        return (new SecondaryUnitHandler())->isIncomplete(
            $this->secondaryDesignator,
            $this->secondaryNumber
        );
    }

    public function isFullyQualified(): bool
    {
        return $this->isComplete() && ! $this->hasIncompleteSecondary();
    }

    public function completenessReport(): array
    {
        $missing = [];

        if (! filled($this->streetName) && ! filled($this->primaryNumber)) {
            $missing[] = 'delivery_address';
        }

        if (! filled($this->city)) {
            $missing[] = 'city';
        }

        if (! filled($this->state)) {
            $missing[] = 'state';
        }

        if (! filled($this->zip5)) {
            $missing[] = 'zip5';
        }

        if ($this->hasIncompleteSecondary()) {
            $missing[] = 'secondary_number';
        }

        return [
            'is_complete' => $this->isComplete(),
            'is_fully_qualified' => $this->isFullyQualified(),
            'has_incomplete_secondary' => $this->hasIncompleteSecondary(),
            'missing' => $missing,
            'corrections' => $this->corrections,
        ];
    }

    public function wasCorrected(): bool
    {
        return $this->corrections !== [];
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}