<?php

namespace Cdburgess\AddressingStandards\Tables;

class SpanishTerms
{
    use Standardizes;

    /**
     * Common Spanish address terms used in Puerto Rico (Pub 28 Appendix H / §294).
     * These are often kept as-is or lightly abbreviated on the mailpiece.
     * @link https://pe.usps.com/text/pub28/28aph.htm
     */
    public static function all(): array
    {
        return [
            // Common terms
            'CALLE' => 'CALLE',          // keep on mailpiece
            'AVENIDA' => 'AVE',          // or keep AVENIDA
            'PASEO' => 'PASEO',
            'CARRETERA' => 'CARR',
            'CARR' => 'CARR',
            'URBANIZACION' => 'URB',
            'URB' => 'URB',
            'CONDOMINIO' => 'COND',
            'COND' => 'COND',
            'APARTAMENTO' => 'APT',
            'EDIFICIO' => 'BLDG',
            'REPARTO' => 'REPTO',
            'RESIDENCIAL' => 'RES',
            'BARRIO' => 'BO',
            'SECTOR' => 'SEC',

            // Directionals (Spanish → English preferred in ZIP+4)
            'NORTE' => 'N',
            'SUR' => 'S',
            'ESTE' => 'E',
            'OESTE' => 'W',
            'NORESTE' => 'NE',
            'NOROESTE' => 'NW',
            'SURESTE' => 'SE',
            'SUROESTE' => 'SW',
        ];
    }
}