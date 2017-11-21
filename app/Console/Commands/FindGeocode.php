<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Geocode;

class FindGeocode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'geocode:find {provider}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find geocoding information based on address information ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Geocode $geocode)
    {
        parent::__construct();

        $this->geocode = $geocode;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->geocode->find($this->argument('provider'));
    }
}
