<?php

namespace Cdburgess\AddressingStandards\Facades;

use Illuminate\Support\Facades\Facade;
use Cdburgess\AddressingStandards\Contracts\AddressNormalizerInterface;

/**
 * @method static \Cdburgess\AddressingStandards\Address normalize(string|array $input)
 *
 * @see \Cdburgess\AddressingStandards\Services\AddressNormalizer
 */
class AddressingStandards extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return AddressNormalizerInterface::class;
    }
}