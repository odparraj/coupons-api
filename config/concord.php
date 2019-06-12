<?php

return [
    'modules' => [
        /**
         * Example:
         * VendorA\ModuleX\Providers\ModuleServiceProvider::class,
         * VendorB\ModuleY\Providers\ModuleServiceProvider::class
         *
         */
        \Vanilo\Product\Providers\ModuleServiceProvider::class,
        \Vanilo\Cart\Providers\ModuleServiceProvider::class,
        \Vanilo\Category\Providers\ModuleServiceProvider::class,
        \Vanilo\Checkout\Providers\ModuleServiceProvider::class,
        \Vanilo\Order\Providers\ModuleServiceProvider::class,
        \Konekt\Address\Providers\ModuleServiceProvider::class,
    ]
];
