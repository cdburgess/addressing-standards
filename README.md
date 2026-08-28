# Addressing Standards

USPS Publication 28 compliant address normalization for Laravel and plain PHP.

Takes messy, human-entered US addresses and returns a clean, standardized `Address` value object ready for mailing, storage, or further validation.

## Installation

```bash
composer require cdburgess/addressing-standards
```

The service provider and facade are auto-discovered by Laravel.

Publish the config (optional):

```bash
php artisan vendor:publish --tag=addressing-standards-config
```

## Quick Start

### Using the Facade

```php
use Cdburgess\AddressingStandards\Address;

$address = Address::normalize(
    "123 south main street apt 4b\nspringfield va 22162"
);

echo $address->deliveryAddressLine(); // 123 S MAIN ST APT 4B
echo $address->lastLine();            // SPRINGFIELD VA 22162
echo $address->toBlock();
```

### Using the Container

```php
use Cdburgess\AddressingStandards\Contracts\AddressNormalizer;

$normalizer = app(AddressNormalizer::class);
$address = $normalizer->normalize([...]);
```

### Array input

```php
use Cdburgess\AddressingStandards\Address;

$address = Address::normalize([
    'street_line' => '456 North Oak Avenue Suite 200',
    'city'        => 'Richmond',
    'state'       => 'Virginia',
    'zip'         => '23219-1234',
]);
```

## Address Object

The returned `Address` is immutable and provides:

| Method / Property | Description |
| --- | --- |
| `deliveryAddressLine()` | Standardized street line |
| `lastLine()` | City + State + ZIP(+4) |
| `toBlock()` | Multi-line mailpiece block |
| `toString()` / `__toString()` | Single-line representation |
| `toArray()` | All components, corrections, and completeness |
| `isComplete()` | Has delivery line + city + state + ZIP5 |
| `hasIncompleteSecondary()` | Designator present but required number missing |
| `isFullyQualified()` | Complete and no secondary problems |
| `wasCorrected()` | One or more standardization changes were applied |
| `completenessReport()` | Missing fields and correction list |
| `corrections` | Array of `{field, from, to}` changes |

### Completeness report

```php
$report = $address->completenessReport();

// [
//     'is_complete' => true,
//     'is_fully_qualified' => true,
//     'has_incomplete_secondary' => false,
//     'missing' => [],
//     'corrections' => [
//         ['field' => 'state', 'from' => 'Virginia', 'to' => 'VA'],
//     ],
// ]
```

## What gets standardized

- Street suffixes to official USPS abbreviations (`STREET` to `ST`, `AVENUE` to `AVE`, and so on)
- Directionals to `N`, `S`, `E`, `W`, `NE`, `NW`, `SE`, `SW`
- Secondary units to `APT`, `STE`, `BLDG`, `FL`, and related designators
- Secondary units that do not require a number (`BSMT`, `PH`, `FRNT`, and similar)
- Fallback `# 12` when a number is present but no recognized designator is
- State names to two-letter codes, including full names such as `Virginia`
- Uppercase formatting (Publication 28 preference)
- ZIP and ZIP+4 normalization
- PO Box
- Dual addresses on one line (street + PO Box → PO Box is used)
- Rural Route and Highway Contract, including obsolete `RFD` and `STAR ROUTE`
- General Delivery
- Puerto Rico urbanization (`URB LAS GLADIOLAS`)
- Alphanumeric and fractional primary numbers (`123A`, `123 1/2`)
- Two-suffix streets (`MAIN AVENUE DRIVE` → street `MAIN AVENUE`, suffix `DR`)

## Testing

```bash
composer test
```

Or:

```bash
./vendor/bin/pest
```

## Roadmap / Limitations

- This package performs **rule-based** standardization per Publication 28.
- It does **not** perform CASS certification or live USPS delivery-point validation.
- Optional USPS Addresses API integration can be added later for ZIP+4 confirmation and DPV.

## License

MIT
