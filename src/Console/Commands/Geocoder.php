<?php

namespace Ry\Geo\Console\Commands;

use Illuminate\Console\Command;
use Ry\Geo\Models\Adresse;
use GuzzleHttp\Client;

class Geocoder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rygeo:code {key?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update lat lng of all rows in adresse table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $default_key = env('GOOGLE_KEY');
        $key = $this->argument('key');
        if(!$default_key && !$key) {
            return $this->error('Veuillez indiquer une clé nommé GOOGLE_KEY dans .env');
        }
        
        if($key) {
            $default_key = $key;
        }
        
        $adresses = Adresse::with('ville.country')->get();
        $client = new Client();
        foreach($adresses as $adresse) {
            $response = $client->get('https://maps.googleapis.com/maps/api/geocode/json', [
                'query' => [
                    'address' => $adresse->geocodable,
                    'key' => $default_key
                ]
            ]);
            $result = json_decode($response->getBody(), true);
            if(isset($result['status']) && $result['status']=='OK') {
                foreach($result['results'] as $r) {
                    if(isset($r['geometry']['location'])) {
                        $adresse->lat = $r['geometry']['location']['lat'];
                        $adresse->lng = $r['geometry']['location']['lng'];
                        $adresse->save();
                        break;
                    }
                }
            }
        }
    }
}
