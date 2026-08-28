<?php

use Cdburgess\AddressingStandards\Parsers\StreetAddressParser;

it('parses a standard street with directional, suffix, and unit', function () {
    $parser = new StreetAddressParser;
    $result = $parser->parse('123 SOUTH MAIN STREET APT 4B');

    expect($result['primaryNumber'])->toBe('123');
    expect($result['preDirectional'])->toBe('S');
    expect($result['streetName'])->toBe('MAIN');
    expect($result['suffix'])->toBe('ST');
    expect($result['secondaryDesignator'])->toBe('APT');
    expect($result['secondaryNumber'])->toBe('4B');
});

it('uses the po box when a dual address is on one line', function () {
    $parser = new StreetAddressParser;
    $result = $parser->parse('1145 RIVER DR PO BOX 195');

    expect($result['streetName'])->toBe('PO BOX');
    expect($result['secondaryNumber'])->toBe('195');
});

it('parses rural routes and drops obsolete rfd labels', function () {
    $parser = new StreetAddressParser;
    $result = $parser->parse('RFD 2 BOX 88');

    expect($result['streetName'])->toBe('RR 2');
    expect($result['secondaryDesignator'])->toBe('BOX');
    expect($result['secondaryNumber'])->toBe('88');
});

it('parses highway contract and star route as hc', function () {
    $parser = new StreetAddressParser;

    expect($parser->parse('HC 1 BOX 12')['streetName'])->toBe('HC 1');
    expect($parser->parse('STAR ROUTE 3 BOX 9')['streetName'])->toBe('HC 3');
});

it('parses puerto rico urbanization and remaining street', function () {
    $parser = new StreetAddressParser;
    $result = $parser->parse('URB LAS GLADIOLAS 150 CALLE A');

    expect($result['urbanization'])->toBe('URB LAS GLADIOLAS');
    expect($result['primaryNumber'])->toBe('150');
    expect($result['streetName'])->toBe('CALLE A');
});

it('parses general delivery', function () {
    $parser = new StreetAddressParser;
    $result = $parser->parse('GENERAL DELIVERY');

    expect($result['streetName'])->toBe('GENERAL DELIVERY');
});

it('parses alphanumeric and fractional primary numbers', function () {
    $parser = new StreetAddressParser;

    expect($parser->parse('123A MAIN ST')['primaryNumber'])->toBe('123A');
    expect($parser->parse('123 1/2 MAIN ST')['primaryNumber'])->toBe('123 1/2');
});

it('treats the second of two suffixes as the suffix field', function () {
    $parser = new StreetAddressParser;
    $result = $parser->parse('789 MAIN AVENUE DRIVE');

    expect($result['streetName'])->toBe('MAIN AVENUE');
    expect($result['suffix'])->toBe('DR');
});

it('parses a utah grid address with two directionals', function () {
    $parser = new StreetAddressParser;
    $result = $parser->parse('80 SOUTH 800 EAST');

    expect($result['primaryNumber'])->toBe('80');
    expect($result['preDirectional'])->toBe('S');
    expect($result['streetName'])->toBe('800');
    expect($result['suffix'])->toBeNull();
    expect($result['postDirectional'])->toBe('E');
});

it('parses a compact utah grid address', function () {
    $parser = new StreetAddressParser;
    $result = $parser->parse('842 E 1700 S');

    expect($result['primaryNumber'])->toBe('842');
    expect($result['preDirectional'])->toBe('E');
    expect($result['streetName'])->toBe('1700');
    expect($result['postDirectional'])->toBe('S');
});
