<?php

namespace Cdburgess\AddressingStandards\Handlers;

use Cdburgess\AddressingStandards\Tables\SecondaryUnits;

class SecondaryUnitHandler
{
    /**
     * Build the secondary portion of the Delivery Address Line.
     *
     * Rules applied:
     * - Prefer real designators (APT, STE, etc.) over bare "#".
     * - Some designators do NOT require a number (BSMT, FRNT, PH, …).
     * - When forced to use "#", there must be a space: "# 12".
     * - Returns null if nothing usable is present.
     */
    public function format(?string $designator, ?string $number): ?string
    {
        $designator = $designator ? trim($designator) : null;
        $number = $number ? trim($number) : null;

        // Nothing to work with
        if (! $designator && ! $number) {
            return null;
        }

        // Standardize the designator if present
        $stdDesignator = $designator
            ? SecondaryUnits::standardize($designator)
            : null;

        // Case 1: We have a recognized designator
        if ($stdDesignator) {
            // Designators that do not require a secondary range
            if (in_array($stdDesignator, SecondaryUnits::noNumberRequired(), true)) {
                return $number
                    ? $stdDesignator.' '.$number
                    : $stdDesignator;
            }

            // Most designators expect a number
            return $number
                ? $stdDesignator.' '.$number
                : $stdDesignator; // still emit the designator; caller can flag incompleteness
        }

        // Case 2: No recognized designator, but we have a number → fall back to "#"
        // Pub 28 requires a space between # and the number.
        if ($number) {
            // Clean any existing leading # the user may have typed
            $number = ltrim($number, '#');

            return '# '.$number;
        }

        return null;
    }

    /**
     * Determine whether a secondary number is required for the given designator.
     */
    public function requiresNumber(?string $designator): bool
    {
        if (! $designator) {
            return false;
        }

        $std = SecondaryUnits::standardize($designator);

        if (! $std) {
            return false;
        }

        return ! in_array($std, SecondaryUnits::noNumberRequired(), true);
    }

    /**
     * Returns true when the secondary information is incomplete
     * (designator that requires a number is present but the number is missing).
     * This is the classic DPV “D” situation.
     */
    public function isIncomplete(?string $designator, ?string $number): bool
    {
        return $this->requiresNumber($designator) && empty(trim((string) $number));
    }
}
