<?php

namespace Cdburgess\AddressingStandards\Tables;

trait Standardizes
{
    /**
     * Convert a value to its official USPS standard abbreviation.
     * Returns null if the value is empty or not found in the table.
     */
    public static function standardize(?string $value): ?string
    {
        if ($value === null || trim($value) === '') {
            return null;
        }

        $key = strtoupper(trim($value));

        return static::all()[$key] ?? null;
    }

    /**
     * Every table must implement this.
     */
    abstract public static function all(): array;
}
