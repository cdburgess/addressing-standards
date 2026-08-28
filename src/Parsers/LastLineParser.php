<?php

namespace Cdburgess\AddressingStandards\Parsers;

use Cdburgess\AddressingStandards\Tables\States;

class LastLineParser
{
    /**
     * Parse a last-line string into city, state, zip5, zip4.
     *
     * Handles common real-world variations:
     * - SPRINGFIELD VA 22162
     * - SPRINGFIELD VA 22162-1010
     * - SPRINGFIELD VA 221621010
     * - Springfield, VA 22162
     * - VA 22162 (city missing)
     */
    public function parse(string $line): array
    {
        $line = trim($line);

        $result = [
            'city'  => null,
            'state' => null,
            'zip5'  => null,
            'zip4'  => null,
        ];

        if ($line === '') {
            return $result;
        }

        $line = preg_replace('/\s+/', ' ', str_replace(',', ' ', $line));

        // City + state (2-letter or full name) + ZIP
        if (preg_match('/^(.*?)\s+([A-Za-z]{2}|[A-Za-z][A-Za-z .]+?)\s+(\d{5})(?:[-\s]?(\d{4}))?$/', $line, $m)) {
            $state = States::standardize($m[2]);

            if ($state) {
                $result['city']  = strtoupper(trim($m[1]));
                $result['state'] = $state;
                $result['zip5']  = $m[3];
                $result['zip4']  = $m[4] ?? null;

                return $result;
            }
        }

        // State + ZIP only
        if (preg_match('/^([A-Za-z]{2}|[A-Za-z][A-Za-z .]+)\s+(\d{5})(?:[-\s]?(\d{4}))?$/', $line, $m)) {
            $state = States::standardize($m[1]);

            if ($state) {
                $result['state'] = $state;
                $result['zip5']  = $m[2];
                $result['zip4']  = $m[3] ?? null;

                return $result;
            }
        }

        // ZIP only
        if (preg_match('/^(\d{5})(?:[-\s]?(\d{4}))?$/', $line, $m)) {
            $result['zip5'] = $m[1];
            $result['zip4'] = $m[2] ?? null;

            return $result;
        }

        $result['city'] = strtoupper($line);

        return $result;
    }

    /**
     * Normalize a raw ZIP string into zip5 + zip4.
     */
    public function normalizeZip(?string $zip): array
    {
        if (! $zip) {
            return ['zip5' => null, 'zip4' => null];
        }

        $digits = preg_replace('/\D/', '', $zip);

        return [
            'zip5' => substr($digits, 0, 5) ?: null,
            'zip4' => strlen($digits) >= 9 ? substr($digits, 5, 4) : null,
        ];
    }
}