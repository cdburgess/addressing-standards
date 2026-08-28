<?php

namespace Cdburgess\AddressingStandards\Facades;

use Cdburgess\AddressingStandards\Contracts\AddressNormalizer;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Cdburgess\AddressingStandards\Address normalize(string|array $input)
 *
 * @see \Cdburgess\AddressingStandards\Services\AddressNormalizer
 */
class AddressingStandards extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return AddressNormalizer::class;
    }
}
