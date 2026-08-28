<?php

namespace Cdburgess\AddressingStandards;

use Cdburgess\AddressingStandards\Contracts\AddressNormalizer as AddressNormalizerContract;
use Cdburgess\AddressingStandards\Services\AddressNormalizer;
use Illuminate\Support\ServiceProvider;

class AddressingStandardsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/addressing-standards.php',
            'addressing-standards'
        );

        $this->app->singleton(AddressNormalizerContract::class, AddressNormalizer::class);
        $this->app->alias(AddressNormalizerContract::class, 'address.normalizer');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/addressing-standards.php' => config_path('addressing-standards.php'),
            ], 'addressing-standards-config');
        }
    }
}
