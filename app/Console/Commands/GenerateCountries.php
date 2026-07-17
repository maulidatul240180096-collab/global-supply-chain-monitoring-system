<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GenerateCountries extends Command
{
    protected $signature = 'countries:generate';

    protected $description = 'Generate countries json';

    public function handle()
    {
        $response = Http::get(
            'https://restcountries.com/v2/all'
        );

        if (!$response->successful()) {

            $this->error('API gagal');

            return;
        }


        $oldCountries = $response->json();


        $countries = [];


        foreach ($oldCountries as $country) {

            $countries[] = [

                "name" => [
                    "common" => $country['name'] ?? '-'
                ],

                "cca2" => $country['alpha2Code'] ?? '',

                "cca3" => $country['alpha3Code'] ?? '',

                "currencies" => $country['currencies'] ?? [],

                "region" => $country['region'] ?? '',

                "population" => $country['population'] ?? 0,

                "latlng" => $country['latlng'] ?? [0,0]

            ];

        }


        file_put_contents(

            storage_path('app/countries.json'),

            json_encode(
                $countries,
                JSON_PRETTY_PRINT
            )

        );


        $this->info(
            count($countries) . ' countries berhasil dibuat'
        );
    }
}