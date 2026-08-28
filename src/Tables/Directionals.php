<?php

namespace Cdburgess\AddressingStandards\Tables;

class Directionals
{
    use Standardizes;

    /**
     * Standard geographic directionals (Pub 28 §233 / Appendix B).
     *
     * @link https://pe.usps.com/text/pub28/28apb.htm
     */
    public static function all(): array
    {
        return [
            'NORTH' => 'N',
            'N' => 'N',
            'SOUTH' => 'S',
            'S' => 'S',
            'EAST' => 'E',
            'E' => 'E',
            'WEST' => 'W',
            'W' => 'W',
            'NORTHEAST' => 'NE',
            'NE' => 'NE',
            'NORTHWEST' => 'NW',
            'NW' => 'NW',
            'SOUTHEAST' => 'SE',
            'SE' => 'SE',
            'SOUTHWEST' => 'SW',
            'SW' => 'SW',

            // Common variants
            'NORTHEASTERN' => 'NE',
            'NORTHWESTERN' => 'NW',
            'SOUTHEASTERN' => 'SE',
            'SOUTHWESTERN' => 'SW',
        ];
    }

    /** The eight canonical directional codes. */
    public static function codes(): array
    {
        return ['N', 'S', 'E', 'W', 'NE', 'NW', 'SE', 'SW'];
    }
}
