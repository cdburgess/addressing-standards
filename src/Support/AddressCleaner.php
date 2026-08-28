<?php

namespace Cdburgess\AddressingStandards\Support;

class AddressCleaner
{
    /**
     * Basic cleaning applied to almost every input string.
     */
    public static function clean(string $value): string
    {
        // Normalize whitespace
        $value = preg_replace('/\s+/', ' ', trim($value));

        // Remove most punctuation (keep hyphens and # for now)
        $value = preg_replace('/[^\w\s\-#\/]/', ' ', $value);

        // Collapse multiple spaces again
        $value = preg_replace('/\s+/', ' ', trim($value));

        return strtoupper($value);
    }

    /**
     * Clean a multi-line block into an array of non-empty lines.
     */
    public static function lines(string $block): array
    {
        $lines = preg_split('/\r\n|\r|\n/', $block);

        return array_values(array_filter(
            array_map(fn ($line) => self::clean($line), $lines)
        ));
    }
}
