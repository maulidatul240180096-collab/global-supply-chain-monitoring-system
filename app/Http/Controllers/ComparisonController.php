<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class ComparisonController extends Controller
{
    public function index(Request $request)
    {
       $allCountries = json_decode(
    file_get_contents(
        storage_path('app/countries.json')
    ),
    true
);

        $countryA = $request->countryA;
        $countryB = $request->countryB;

        $dataA = null;
        $dataB = null;

       $currencyA = '-';
$currencyB = '-';

$exchangeRateA = 0;
$exchangeRateB = 0;

$populationA = 0;
$populationB = 0;

$gdpA = 0;
$gdpB = 0;

$inflationA = 0;
$inflationB = 0;

$tempA = 0;
$tempB = 0;

        $riskA = 0;
$riskB = 0;

$statusA = '-';
$statusB = '-';

        if ($countryA && $countryB) {


          $dataA = collect($allCountries)->first(
    fn ($item) =>
        strtolower($item['name']['common']) === strtolower($countryA)
);


$dataB = collect($allCountries)->first(
    fn ($item) =>
        strtolower($item['name']['common']) === strtolower($countryB)
);

$populationA = $dataA['population'] ?? 0;
$populationB = $dataB['population'] ?? 0;

            // Currency
           $currencyA = array_key_first(
    $dataA['currencies'] ?? []
) ?? '-';

$currencyB = array_key_first(
    $dataB['currencies'] ?? []
) ?? '-';

$exchangeResponse = Http::get(
    "https://open.er-api.com/v6/latest/USD"
);

$rates = $exchangeResponse->json()['rates'] ?? [];

$exchangeRateA = $rates[$currencyA] ?? 0;
$exchangeRateB = $rates[$currencyB] ?? 0;

            // ISO3
         $iso3A = $dataA['cca3'];
$iso3B = $dataB['cca3'];

$latA = $dataA['latlng'][0];
$lngA = $dataA['latlng'][1];

$latB = $dataB['latlng'][0];
$lngB = $dataB['latlng'][1];

            // GDP
            $gdpResponseA = Http::get(
                "https://api.worldbank.org/v2/country/{$iso3A}/indicator/NY.GDP.MKTP.CD?format=json"
            );

            $gdpA = $gdpResponseA->json()[1][0]['value'] ?? 0;

            $gdpResponseB = Http::get(
                "https://api.worldbank.org/v2/country/{$iso3B}/indicator/NY.GDP.MKTP.CD?format=json"
            );

            $gdpB = $gdpResponseB->json()[1][0]['value'] ?? 0;

            // Inflation
            $inflationResponseA = Http::get(
                "https://api.worldbank.org/v2/country/{$iso3A}/indicator/FP.CPI.TOTL.ZG?format=json"
            );

            $inflationA = $inflationResponseA->json()[1][0]['value'] ?? 0;

            $inflationResponseB = Http::get(
                "https://api.worldbank.org/v2/country/{$iso3B}/indicator/FP.CPI.TOTL.ZG?format=json"
            );

            $inflationB = $inflationResponseB->json()[1][0]['value'] ?? 0;

            $populationResponseA = Http::get(
    "https://api.worldbank.org/v2/country/{$iso3A}/indicator/SP.POP.TOTL?format=json"
);

$populationA =
    $populationResponseA->json()[1][0]['value']
    ?? 0;

$populationResponseB = Http::get(
    "https://api.worldbank.org/v2/country/{$iso3B}/indicator/SP.POP.TOTL?format=json"
);

$populationB =
    $populationResponseB->json()[1][0]['value']
    ?? 0;

            $weatherA = Http::get(
    'https://api.open-meteo.com/v1/forecast',
    [
        'latitude' => $latA,
        'longitude' => $lngA,
        'current' => 'temperature_2m'
    ]
);

$tempA =
    $weatherA->json()['current']['temperature_2m']
    ?? 0;

$weatherB = Http::get(
    'https://api.open-meteo.com/v1/forecast',
    [
        'latitude' => $latB,
        'longitude' => $lngB,
        'current' => 'temperature_2m'
    ]
);

$tempB =
    $weatherB->json()['current']['temperature_2m']
    ?? 0;

            $riskA = 0;

if ($inflationA > 10) {
    $riskA += 50;
}

if ($gdpA < 100000000000) {
    $riskA += 50;
}

$statusA = $riskA >= 50 ? 'High Risk' : 'Low Risk';


$riskB = 0;

if ($inflationB > 10) {
    $riskB += 50;
}

if ($gdpB < 100000000000) {
    $riskB += 50;
}

$statusB = $riskB >= 50 ? 'High Risk' : 'Low Risk';

session([
    'highestRiskCountry' =>
        $riskA > $riskB
        ? $dataA['name']['common']
        : $dataB['name']['common'],

    'lowestRiskCountry' =>
        $riskA < $riskB
        ? $dataA['name']['common']
        : $dataB['name']['common'],

    'riskA' => $riskA,
    'riskB' => $riskB
]);

}

      session([
    'dataA' => $dataA,
    'dataB' => $dataB,

    'populationA' => $populationA,
    'populationB' => $populationB,

    'gdpA' => $gdpA,
    'gdpB' => $gdpB,

    'inflationA' => $inflationA,
'inflationB' => $inflationB,

    'riskA' => $riskA,
    'riskB' => $riskB,

    'currencyA' => $currencyA,
    'currencyB' => $currencyB,

    'exchangeRateA' => $exchangeRateA,
    'exchangeRateB' => $exchangeRateB,

    'tempA' => $tempA,
    'tempB' => $tempB,

    'statusA' => $statusA,
    'statusB' => $statusB,
]);


    return view('comparison.index', [
    'countries' => $allCountries,
    'dataA' => $dataA,
    'dataB' => $dataB,
   'currencyA' => $currencyA,
'currencyB' => $currencyB,
'exchangeRateA' => $exchangeRateA,
'exchangeRateB' => $exchangeRateB,
'populationA' => $populationA,
'populationB' => $populationB,
    'gdpA' => $gdpA,
    'gdpB' => $gdpB,
    'inflationA' => $inflationA,
    'inflationB' => $inflationB,
    'tempA' => $tempA,
'tempB' => $tempB,
    'riskA' => $riskA,
    'riskB' => $riskB,
    'statusA' => $statusA,
    'statusB' => $statusB,
]);
    }

public function exportPdf()
{
    $pdf = Pdf::loadView('comparison.pdf', [
    'dataA' => session('dataA'),
    'dataB' => session('dataB'),

    'populationA' => session('populationA'),
    'populationB' => session('populationB'),

    'gdpA' => session('gdpA'),
    'gdpB' => session('gdpB'),

    'inflationA' => session('inflationA'),
'inflationB' => session('inflationB'),

    'riskA' => session('riskA'),
    'riskB' => session('riskB'),

    'currencyA' => session('currencyA'),
    'currencyB' => session('currencyB'),

    'exchangeRateA' => session('exchangeRateA'),
    'exchangeRateB' => session('exchangeRateB'),

    'tempA' => session('tempA'),
    'tempB' => session('tempB'),

    'statusA' => session('statusA'),
    'statusB' => session('statusB'),
]);

    return $pdf->download('comparison-report.pdf');
}


}