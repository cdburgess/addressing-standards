<?php

namespace Cdburgess\AddressingStandards\Contracts;

use Cdburgess\AddressingStandards\Address;

interface AddressNormalizer
{
    /**
     * Accept almost any human-entered address form and return a
     * standardized Address value object following Pub 28 rules.
     *
     * @param  string|array  $input  Single-line string, multi-line string,
     *                               or associative array of components.
     */
    public function normalize(string|array $input): Address;
}
