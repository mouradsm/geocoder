<?php

namespace App;

use App\Address as Address;
use Geocoder\Provider\GoogleMaps\GoogleMaps;
use Geocoder\Provider\LocationIQ\LocationIQ;
use Geocoder\Provider\OpenCage\OpenCage;
use Geocoder\Provider\PickPoint\PickPoint;
use Geocoder\ProviderAggregator;
use Geocoder\Query\GeocodeQuery;
use Http\Adapter\Guzzle6\Client;
use Illuminate\Support\Facades\Log;

class Geocode {
    function __construct() {
        $this->rateLimit = 10;
        $this->adapter = new Client();
        $this->geocoder = new ProviderAggregator();
        $this->basicInformation = [];

    }

    public function process($provider) {
        if ($provider == 'locationiq')
            $this->rateLimit = 10000;

        $enderecos = Address::whereNotNull('cep')->where('lat', '=', '')
                                   ->where('lng', '=', '')->orderBy('id', 'asc')->limit($this->rateLimit)->get();

        if(empty($enderecos[0])) {
            echo "Nothing to process. Stoping... \n";
            return;
        }


        foreach ($enderecos as $value) {
            array_push($this->basicInformation, ['id' => $value->id, 'rua' => preg_split("/[-(]/",
                                                         $value->rua)[0], 'cep' => $value->cep]);
        }

        foreach ($this->basicInformation as $i) {
            $fullAddress = $i['rua'] . ', ' . $i['cep'] . ', RJ';

            $geocode = $this->find($provider, $fullAddress);

            if($geocode->count() == 0)
                continue;

            $geocode = $geocode->get(0)->getCoordinates();

            Address::where('id', '=', $i['id'])->update(['lat' => $geocode->getLatitude(), 'lng' => $geocode->getLongitude()]);

            sleep(1);
        }

    }

    private function find($provider, $fullAdress) {
        echo "Using " . $provider . " provider \n";

        $this->geocoder->registerProviders([
            new GoogleMaps($this->adapter, env('GOOGLE_MAPS_API_KEY')),
            new LocationIQ($this->adapter, env('LOCATIONIQ_API_KEY')),
            new PickPoint($this->adapter, env('PICKPOINT_API_KEY')),
            new OpenCage($this->adapter,env('OPENCAGE_API_KEY'))
        ]);

        $result =  $this->geocoder
                    ->using($provider)
                    ->geocodeQuery(GeocodeQuery::create($fullAdress));

        if($result->count() == 0)
            Log::error('Error on: ' . $fullAdress);

        return $result;
    }
}
