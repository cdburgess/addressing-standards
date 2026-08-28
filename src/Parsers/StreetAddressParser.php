<?php

namespace Cdburgess\AddressingStandards\Parsers;

use Cdburgess\AddressingStandards\Tables\Directionals;
use Cdburgess\AddressingStandards\Tables\SecondaryUnits;
use Cdburgess\AddressingStandards\Tables\StreetSuffixes;

class StreetAddressParser
{
    public function parse(string $line): array
    {
        $line = trim($line);

        if ($line === '') {
            return $this->emptyResult();
        }

        [$urbanization, $line] = $this->extractUrbanization($line);

        $parsed = $this->emptyResult();

        if ($line !== '') {
            $parsed = match (true) {
                $this->isGeneralDelivery($line) => [
                    'streetName' => 'GENERAL DELIVERY',
                ],
                $this->isDualAddress($line) => $this->parsePoBox(
                    $this->extractPoBoxPortion($line) ?? $line
                ),
                $this->isPoBox($line) => $this->parsePoBox($line),
                $this->isRuralOrHighway($line) => $this->parseRuralOrHighway($line),
                default => $this->parseStandardStreet($line),
            };
        }

        return array_merge($this->emptyResult(), $parsed, [
            'urbanization' => $urbanization,
        ]);
    }

    protected function emptyResult(): array
    {
        return [
            'primaryNumber' => null,
            'preDirectional' => null,
            'streetName' => null,
            'suffix' => null,
            'postDirectional' => null,
            'secondaryDesignator' => null,
            'secondaryNumber' => null,
            'urbanization' => null,
        ];
    }

    protected function extractUrbanization(string $line): array
    {
        if (! preg_match('/^URB(?:ANIZATION)?\s+(.+)$/i', $line, $match)) {
            return [null, $line];
        }

        $rest = trim($match[1]);

        if (preg_match('/^(.+?)\s+(\d+[A-Z]?\b.*)$/i', $rest, $parts)) {
            return [
                'URB ' . strtoupper(trim($parts[1])),
                trim($parts[2]),
            ];
        }

        return ['URB ' . strtoupper($rest), ''];
    }

    protected function isGeneralDelivery(string $line): bool
    {
        return (bool) preg_match('/^GENERAL\s+DELIVERY\b/i', $line);
    }

    protected function isDualAddress(string $line): bool
    {
        $hasPoBox = (bool) preg_match('/\b(P\.?\s*O\.?\s*BOX|POST\s+OFFICE\s+BOX)\b/i', $line);
        $hasStreetNumber = (bool) preg_match('/^\d+/', $line);

        return $hasPoBox && $hasStreetNumber;
    }

    protected function extractPoBoxPortion(string $line): ?string
    {
        if (preg_match('/((?:P\.?\s*O\.?\s*BOX|POST\s+OFFICE\s+BOX)\s*[A-Z0-9\-]+)/i', $line, $match)) {
            return strtoupper($match[1]);
        }

        return null;
    }

    protected function isPoBox(string $line): bool
    {
        return (bool) preg_match('/^(P\.?\s*O\.?\s*BOX|POST\s+OFFICE\s+BOX)\b/i', $line);
    }

    protected function parsePoBox(string $line): array
    {
        $result = ['streetName' => 'PO BOX'];

        if (preg_match('/BOX\s*#?\s*([A-Z0-9\-]+)/i', $line, $match)) {
            $result['secondaryNumber'] = strtoupper($match[1]);
        }

        return $result;
    }

    protected function isRuralOrHighway(string $line): bool
    {
        return (bool) preg_match(
            '/^(RR|RURAL\s+ROUTE|RFD|RD|HC|HIGHWAY\s+CONTRACT|STAR\s+ROUTE)\s*\d+/i',
            $line
        );
    }

    protected function parseRuralOrHighway(string $line): array
    {
        $normalized = preg_replace('/^(RFD|RD|RURAL\s+ROUTE)\b/i', 'RR', $line);
        $normalized = preg_replace('/^(STAR\s+ROUTE|HIGHWAY\s+CONTRACT)\b/i', 'HC', $normalized);

        if (preg_match('/^(RR|HC)\s*0*(\d+)\s*(?:BOX\s*#?\s*([A-Z0-9\-]+))?/i', $normalized, $match)) {
            $result = [
                'streetName' => strtoupper($match[1]) . ' ' . $match[2],
            ];

            if (! empty($match[3])) {
                $result['secondaryDesignator'] = 'BOX';
                $result['secondaryNumber'] = strtoupper($match[3]);
            }

            return $result;
        }

        return ['streetName' => strtoupper($line)];
    }

    protected function parseStandardStreet(string $line): array
    {
        $result = [];
        $tokens = preg_split('/\s+/', trim($line)) ?: [];
        $tokens = array_values(array_filter($tokens, fn ($token) => $token !== ''));

        if ($tokens === []) {
            return $result;
        }

        if ($this->isPrimaryNumber($tokens[0] ?? '')) {
            $result['primaryNumber'] = strtoupper(array_shift($tokens));

            if (isset($tokens[0]) && preg_match('/^\d+\/\d+$/', $tokens[0])) {
                $result['primaryNumber'] .= ' ' . array_shift($tokens);
            }
        }

        $this->extractTrailingSecondary($tokens, $result);

        if ($tokens !== []) {
            $possiblePost = Directionals::standardize(end($tokens));
            if ($possiblePost) {
                $result['postDirectional'] = $possiblePost;
                array_pop($tokens);
            }
        }

        if ($tokens !== []) {
            $possibleSuffix = StreetSuffixes::standardize(end($tokens));
            if ($possibleSuffix) {
                $result['suffix'] = $possibleSuffix;
                array_pop($tokens);
            }
        }

        if ($tokens !== []) {
            $possiblePre = Directionals::standardize($tokens[0]);
            if ($possiblePre) {
                $result['preDirectional'] = $possiblePre;
                array_shift($tokens);
            }
        }

        if ($tokens !== []) {
            $result['streetName'] = strtoupper(implode(' ', $tokens));
        }

        return $result;
    }

    protected function isPrimaryNumber(string $token): bool
    {
        return (bool) preg_match('/^\d+[A-Z]?$/i', $token)
            || (bool) preg_match('/^\d+-\d+[A-Z]?$/i', $token);
    }

    protected function extractTrailingSecondary(array &$tokens, array &$result): void
    {
        if ($tokens === []) {
            return;
        }

        $last = $tokens[array_key_last($tokens)];

        if (str_starts_with($last, '#')) {
            $number = ltrim($last, '#');
            array_pop($tokens);

            if ($number === '' && $tokens !== []) {
                $number = array_pop($tokens);
            }

            if ($number !== '') {
                $result['secondaryNumber'] = strtoupper($number);
            }

            return;
        }

        $count = count($tokens);

        if ($count >= 2) {
            $possibleDesignator = SecondaryUnits::standardize($tokens[$count - 2]);

            if ($possibleDesignator) {
                $result['secondaryDesignator'] = $possibleDesignator;
                $result['secondaryNumber'] = strtoupper($last);
                array_pop($tokens);
                array_pop($tokens);

                return;
            }
        }

        $standalone = SecondaryUnits::standardize($last);

        if ($standalone) {
            $result['secondaryDesignator'] = $standalone;
            array_pop($tokens);
        }
    }
}