<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Geocoder\Query\GeocodeQuery;

class Geocode {


    public function find($provider) {
        echo "Using " . $provider . " provider \n";

        $httpClient = new \Http\Adapter\Guzzle6\Client();

        
        dd();

    }
}
