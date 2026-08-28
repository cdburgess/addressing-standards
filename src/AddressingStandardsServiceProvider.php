<?php

namespace Cdburgess\AddressingStandards;

use Illuminate\Support\ServiceProvider;
use Cdburgess\AddressingStandards\Contracts\AddressNormalizer;
use Cdburgess\AddressingStandards\Services\AddressNormalizer;

class AddressingStandardsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/addressing-standards.php',
            'addressing-standards'
        );

        $this->app->singleton(AddressNormalizer::class, AddressNormalizer::class);
        $this->app->alias(AddressNormalizer::class, 'address.normalizer');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/addressing-standards.php' => config_path('addressing-standards.php'),
            ], 'addressing-standards-config');
        }
    }
}