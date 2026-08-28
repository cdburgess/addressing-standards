<?php

use Cdburgess\AddressingStandards\Handlers\SecondaryUnitHandler;

it('formats a standard designator with a number', function () {
    $handler = new SecondaryUnitHandler();

    expect($handler->format('Apartment', '4B'))->toBe('APT 4B');
    expect($handler->format('Suite', '200'))->toBe('STE 200');
});

it('handles designators that do not require a number', function () {
    $handler = new SecondaryUnitHandler();

    expect($handler->format('Basement', null))->toBe('BSMT');
    expect($handler->format('Penthouse', null))->toBe('PH');
    expect($handler->format('Penthouse', '1'))->toBe('PH 1');
});

it('falls back to pound sign when no designator is present', function () {
    $handler = new SecondaryUnitHandler();

    expect($handler->format(null, '12'))->toBe('# 12');
    expect($handler->format(null, '#12'))->toBe('# 12');
});

it('correctly determines whether a designator requires a number', function () {
    $handler = new SecondaryUnitHandler();

    expect($handler->requiresNumber('APT'))->toBeTrue();
    expect($handler->requiresNumber('Suite'))->toBeTrue();
    expect($handler->requiresNumber('BSMT'))->toBeFalse();
    expect($handler->requiresNumber('PH'))->toBeFalse();
});

it('detects incomplete secondary information', function () {
    $handler = new SecondaryUnitHandler();

    expect($handler->isIncomplete('APT', null))->toBeTrue();
    expect($handler->isIncomplete('APT', '4B'))->toBeFalse();
    expect($handler->isIncomplete('BSMT', null))->toBeFalse();
});