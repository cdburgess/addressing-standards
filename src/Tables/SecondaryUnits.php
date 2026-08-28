<?php

namespace Cdburgess\AddressingStandards\Tables;

class SecondaryUnits
{
    use Standardizes;

    /**
     * Secondary unit designators (Pub 28 §213 + Appendix C2).
     * Maps common forms → official abbreviation.
     *
     * Note: Some designators (marked in USPS docs) do not require a following number
     * (BSMT, FRNT, LBBY, LOWR, OFC, PH, REAR, SIDE, UPPR).
     * @link https://pe.usps.com/text/pub28/28apc_003.htm
     */
    public static function all(): array
    {
        return [
            // Most common
            'APARTMENT' => 'APT',
            'APT' => 'APT',
            'SUITE' => 'STE',
            'STE' => 'STE',
            'UNIT' => 'UNIT',
            'ROOM' => 'RM',
            'RM' => 'RM',
            'FLOOR' => 'FL',
            'FL' => 'FL',
            'BUILDING' => 'BLDG',
            'BLDG' => 'BLDG',
            'DEPARTMENT' => 'DEPT',
            'DEPT' => 'DEPT',

            // Full official set
            'BASEMENT' => 'BSMT',
            'BSMT' => 'BSMT',
            'FRONT' => 'FRNT',
            'FRNT' => 'FRNT',
            'HANGAR' => 'HNGR',
            'HANGER' => 'HNGR',
            'HNGR' => 'HNGR',
            'KEY' => 'KEY',
            'LOBBY' => 'LBBY',
            'LBBY' => 'LBBY',
            'LOT' => 'LOT',
            'LOWER' => 'LOWR',
            'LOWR' => 'LOWR',
            'OFFICE' => 'OFC',
            'OFC' => 'OFC',
            'PENTHOUSE' => 'PH',
            'PH' => 'PH',
            'PIER' => 'PIER',
            'REAR' => 'REAR',
            'SIDE' => 'SIDE',
            'SLIP' => 'SLIP',
            'SPACE' => 'SPC',
            'SPC' => 'SPC',
            'STOP' => 'STOP',
            'TRAILER' => 'TRLR',
            'TRLR' => 'TRLR',
            'UPPER' => 'UPPR',
            'UPPR' => 'UPPR',

            // Occasional variants
            'APTS' => 'APT',
            'SUITES' => 'STE',
        ];
    }

    /** Designators that do NOT require a secondary number. */
    public static function noNumberRequired(): array
    {
        return ['BSMT', 'FRNT', 'LBBY', 'LOWR', 'OFC', 'PH', 'REAR', 'SIDE', 'UPPR'];
    }

    public static function requiresNumber(string $designator): bool
    {
        $std = self::standardize($designator);

        return $std !== null && ! in_array($std, self::noNumberRequired(), true);
    }

}