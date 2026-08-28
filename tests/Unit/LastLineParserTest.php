<?php

use Cdburgess\AddressingStandards\Parsers\LastLineParser;

it('parses city, state, and zip', function () {
    $parser = new LastLineParser();
    $result = $parser->parse('SPRINGFIELD VA 22162');

    expect($result['city'])->toBe('SPRINGFIELD');
    expect($result['state'])->toBe('VA');
    expect($result['zip5'])->toBe('22162');
    expect($result['zip4'])->toBeNull();
});

it('parses zip plus 4 with hyphen', function () {
    $parser = new LastLineParser();
    $result = $parser->parse('SPRINGFIELD VA 22162-1010');

    expect($result['zip5'])->toBe('22162');
    expect($result['zip4'])->toBe('1010');
});

it('parses zip plus 4 without hyphen', function () {
    $parser = new LastLineParser();
    $result = $parser->parse('SPRINGFIELD VA 221621010');

    expect($result['zip5'])->toBe('22162');
    expect($result['zip4'])->toBe('1010');
});

it('normalizes a raw zip string', function () {
    $parser = new LastLineParser();

    expect($parser->normalizeZip('22162-1010'))
        ->toBe(['zip5' => '22162', 'zip4' => '1010']);

    expect($parser->normalizeZip('22162'))
        ->toBe(['zip5' => '22162', 'zip4' => null]);
});