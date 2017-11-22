<?php

/**
 * This file is part of the GeocoderLaravel library.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Geocoder\Provider\Chain\Chain;
use Geocoder\Provider\GeoPlugin\GeoPlugin;
use Geocoder\Provider\GoogleMaps\GoogleMaps;
use Geocoder\Provider\LocationIQ\LocationIQ;
use Http\Client\Curl\Client;

return [
    'cache-duration' => 9999999,
    'providers' => [
        Chain::class => [
            GoogleMaps::class => [
                'pt-br',
                env('GOOGLE_MAPS_API_KEY'),
            ],
            GeoPlugin::class  => [],
        ],
        GoogleMaps::class => [
            'pt-br',
            env('GOOGLE_MAPS_API_KEY'),
        ],
        LocationIQ::class => [
            'pt-br',
            env('LOCATIONIQ_API_KEY'),
        ],
    ],
    'adapter'  => Client::class,
];