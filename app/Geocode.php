<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Geocoder\Query\GeocodeQuery;

class Geocode {


    public function find($provider) {
        echo "Using " . $provider . " provider \n";

        $httpClient = new \Http\Adapter\Guzzle6\Client();
        $provider = new \Geocoder\Provider\GoogleMaps\GoogleMaps($httpClient);
        $geocoder = new \Geocoder\StatefulGeocoder($provider, 'pt-br');

        $result = $geocoder->geocodeQuery(GeocodeQuery::create('Rua Parazinho, Rio de Janeiro, RJ'));


        dd($result);

    }
}
