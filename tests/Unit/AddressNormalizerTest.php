<?php

use Cdburgess\AddressingStandards\Address;
use Cdburgess\AddressingStandards\Services\AddressNormalizer;

it('normalizes a simple street address', function () {
    $normalizer = new AddressNormalizer();

    $address = $normalizer->normalize(
        "123 South Main Street Apt 4B\nSpringfield VA 22162"
    );

    expect($address->primaryNumber)->toBe('123');
    expect($address->preDirectional)->toBe('S');
    expect($address->streetName)->toBe('MAIN');
    expect($address->suffix)->toBe('ST');
    expect($address->secondaryDesignator)->toBe('APT');
    expect($address->secondaryNumber)->toBe('4B');
    expect($address->city)->toBe('SPRINGFIELD');
    expect($address->state)->toBe('VA');
    expect($address->zip5)->toBe('22162');

    expect($address->isComplete())->toBeTrue();
    expect($address->hasIncompleteSecondary())->toBeFalse();
});

it('normalizes a po box address', function () {
    $normalizer = new AddressNormalizer();

    $address = $normalizer->normalize("PO Box 1234\nSpringfield VA 22162");

    expect($address->streetName)->toBe('PO BOX');
    expect($address->secondaryNumber)->toBe('1234');
    expect($address->isComplete())->toBeTrue();
});

it('reports completeness and corrections', function () {
    $normalizer = new AddressNormalizer();

    $address = $normalizer->normalize(
        "123 south main street apartment 4b\nspringfield virginia 22162-1010"
    );

    expect($address->isComplete())->toBeTrue();
    expect($address->wasCorrected())->toBeTrue();
    expect($address->completenessReport())
        ->toHaveKeys(['is_complete', 'is_fully_qualified', 'has_incomplete_secondary', 'missing', 'corrections'])
        ->and($address->completenessReport()['missing'])->toBe([]);
});

it('flags an incomplete secondary unit', function () {
    $normalizer = new AddressNormalizer();

    $address = $normalizer->normalize([
        'street_line' => '123 Main Street Apt',
        'city' => 'Springfield',
        'state' => 'VA',
        'zip' => '22162',
    ]);

    expect($address->hasIncompleteSecondary())->toBeTrue();
    expect($address->isFullyQualified())->toBeFalse();
    expect($address->completenessReport()['missing'])->toContain('secondary_number');
});

it('normalizes through the address static factory', function () {
    $address = Address::normalize("123 main st\nspringfield va 22162");

    expect($address->deliveryAddressLine())->toBe('123 MAIN ST');
    expect($address->lastLine())->toBe('SPRINGFIELD VA 22162');
});