<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function index()
    {
      $allCountries = json_decode(
    file_get_contents(
        storage_path('app/countries.json')
    ),
    true
);

      $selectedCountry = request('country');
$weather = null;

$weatherStatus = '-';
$impact = '-';

$weatherRisk = '-';
$recommendation = '-';

$lastUpdate = now()->format('d M Y H:i');

        if ($selectedCountry) {

        $countryData = collect($allCountries)->first(
    fn ($item) =>
        strtolower($item['name']['common']) === strtolower($selectedCountry)
);


$lat = $countryData['latlng'][0] ?? 0;
$lng = $countryData['latlng'][1] ?? 0;




            $weather = Http::get(
                'https://api.open-meteo.com/v1/forecast',
                [
                    'latitude' => $lat,
                    'longitude' => $lng,
                    'current' => 'temperature_2m,wind_speed_10m'
                ]
            )->json();

            
      $temperature =
    $weather['current']['temperature_2m'] ?? 0;

$windSpeed =
    $weather['current']['wind_speed_10m'] ?? 0;

if ($temperature >= 35) {
    $weatherStatus = 'Extreme Hot';
}
elseif ($temperature >= 25) {
    $weatherStatus = 'Warm';
}
else {
    $weatherStatus = 'Cool';
}

if ($windSpeed >= 30) {
    $impact = 'Potential Shipping Disruption';
}
else {
    $impact = 'Normal Logistics Condition';
}

if ($temperature >= 35 || $windSpeed >= 30) {
    $weatherRisk = 'High';
}
elseif ($temperature >= 25 || $windSpeed >= 20) {
    $weatherRisk = 'Medium';
}
else {
    $weatherRisk = 'Low';
}

if ($impact == 'Potential Shipping Disruption') {
    $recommendation =
    'Delay shipment and monitor weather conditions.';
}
else {
    $recommendation =
    'Shipping activities can proceed normally.';
}
        }

     return view('weather.index', [
    'countries' => $allCountries,
    'weather' => $weather,
    'selectedCountry' => $selectedCountry,
    'weatherStatus' => $weatherStatus,
    'impact' => $impact,
    'weatherRisk' => $weatherRisk,
    'recommendation' => $recommendation,
    'lastUpdate' => $lastUpdate
]);
    }
}