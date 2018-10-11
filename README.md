# Banner SDK

This is a Laravel Package providing access to Banner Manager API.

## Installation

1. Add the project repository to your `composer.json` file:
    
        {
            "repositories": [
                {
                    "type": "vcs",
                    "url": "https://github.com/Aboalarm/banner-manager-php-sdk"
                }
            ]
        }
    
2. Then add the requirement:
    
        $ composer require aboalarm/banner-manager-sdk @dev


### Laravel
1. Add the service provider to `/config/app.php`:

    'providers' => [
        
        ...
        
        aboalarm\BannerManagerSdk\Laravel\ServiceProvider::class,
        
    ];

2. Add the alias

    'aliases' => [
        ...
        
        'BannerSDK' => aboalarm\BannerManagerSdk\Laravel\Facade::class,
    ]

To set the params used by the SDK, you have to publish the config files:

    $ php artisan vendor:publish --provider="aboalarm\BannerManagerSdk\Laravel\ServiceProvider::class"

Then go to `/config/banner.php` to see the config values.

You now are able to use BannerSDK sample method:

    <?php
    ...
        BannerSDK::getBanners()
