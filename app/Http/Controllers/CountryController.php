<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;


class CountryController extends Controller
{

public function index()
{
    $response = Http::get('https://restcountries.com/v3.1/all');

    dd(
        $response->status(),
        $response->json()
    );
}

public function show($country)

{
   $countries = json_decode(
    file_get_contents(
        storage_path('app/countries.json')
    ),
    true
);

$countryData = collect($countries)->first(
    fn ($item) =>
        strtolower($item['name']['common']) === strtolower($country)
);

if (!$countryData) {
    abort(404);
}



$currency = array_key_first(
    $countryData['currencies'] ?? []
) ?? '-';

$exchangeResponse = Http::get(
    "https://open.er-api.com/v6/latest/USD"
);

$rates = $exchangeResponse->json()['rates'] ?? [];

$exchangeRate = $rates[$currency] ?? 0;

$newsResponse = Http::get(
    'https://gnews.io/api/v4/search',
    [
        'q' => $country,
        'lang' => 'en',
        'max' => 3,
        'apikey' => env('GNEWS_API_KEY')
    ]
);

$news = $newsResponse->json()['articles'] ?? [];

$positiveWords = [
    'growth',
    'increase',
    'profit',
    'stable',
    'improve',
    'success',
    'strong',
    'recovery',
    'expand',
    'investment',
    'development',
    'economic',
    'opportunity',
    'support'
];

$negativeWords = [
    'war',
    'crisis',
    'inflation',
    'delay',
    'disaster',
    'conflict',
    'decline',
    'loss',
    'risk',
    'attack',
    'sanction',
    'shortage',
    'collapse',
    'recession'
];

$positiveCount = 0;
$negativeCount = 0;

foreach ($news as $article) {

    $text = strtolower(
        ($article['title'] ?? '') . ' ' .
        ($article['description'] ?? '') . ' ' .
        ($article['content'] ?? '')
    );

    foreach ($positiveWords as $word) {
        if (str_contains($text, $word)) {
            $positiveCount++;
        }
    }

    foreach ($negativeWords as $word) {
        if (str_contains($text, $word)) {
            $negativeCount++;
        }
    }
}


$totalSentiment = $positiveCount + $negativeCount;

if ($totalSentiment > 0) {

    $positivePercent =
        round(($positiveCount / $totalSentiment) * 100);

    $negativePercent =
        round(($negativeCount / $totalSentiment) * 100);

} else {

    $positivePercent = 50;
    $negativePercent = 50;
}

$iso3 = $countryData['cca3'];

$gdpTrendResponse = Http::get(
    "https://api.worldbank.org/v2/country/{$iso3}/indicator/NY.GDP.MKTP.CD?format=json&per_page=5"
);

$gdpTrend = [];

if (isset($gdpTrendResponse->json()[1])) {

    foreach ($gdpTrendResponse->json()[1] as $item) {

        $gdpTrend[] = [
            'year' => $item['date'],
            'value' => $item['value'] ?? 0
        ];
    }
}

$inflationTrendResponse = Http::get(
    "https://api.worldbank.org/v2/country/{$iso3}/indicator/FP.CPI.TOTL.ZG?format=json&per_page=5"
);

$inflationTrend = [];

if (isset($inflationTrendResponse->json()[1])) {

    foreach ($inflationTrendResponse->json()[1] as $item) {

        $inflationTrend[] = [
            'year' => $item['date'],
            'value' => $item['value'] ?? 0
        ];
    }
}


$lat = $countryData['latlng'][0] ?? 0;
$lng = $countryData['latlng'][1] ?? 0;

$weatherResponse = Http::get(
    'https://api.open-meteo.com/v1/forecast',
    [
        'latitude' => $lat,
        'longitude' => $lng,
        'current' => 'temperature_2m,wind_speed_10m'
    ]
);

$weather = $weatherResponse->json();

$temperature = $weather['current']['temperature_2m'] ?? 0;

$windSpeed = $weather['current']['wind_speed_10m'] ?? 0;

    $gdpResponse = Http::get(
        "https://api.worldbank.org/v2/country/{$iso3}/indicator/NY.GDP.MKTP.CD?format=json"
    );


    $gdp = $gdpResponse->json()[1][0]['value'] ?? 0;

    $inflationResponse = Http::get(
    "https://api.worldbank.org/v2/country/{$iso3}/indicator/FP.CPI.TOTL.ZG?format=json"
);

$inflation = $inflationResponse->json()[1][0]['value'] ?? 0;

$populationResponse = Http::get(
    "https://api.worldbank.org/v2/country/{$iso3}/indicator/SP.POP.TOTL?format=json"
);

$population =
    $populationResponse->json()[1][0]['value']
    ?? 0;

// Inflation Risk
if ($inflation < 3) {
    $inflationRisk = 10;
} elseif ($inflation < 6) {
    $inflationRisk = 20;
} else {
    $inflationRisk = 30;
}

// Weather Risk (berdasarkan wind speed)
if ($windSpeed < 10) {
    $weatherRisk = 10;
} elseif ($windSpeed < 20) {
    $weatherRisk = 20;
} else {
    $weatherRisk = 30;
}

// Currency Risk (sementara statis)
if ($exchangeRate == 0) {
    $currencyRisk = 30;
} elseif ($exchangeRate < 1) {
    $currencyRisk = 20;
} else {
    $currencyRisk = 10;
}

// News Risk (sementara statis)
if ($negativePercent >= 70) {
    $newsRisk = 30;
} elseif ($negativePercent >= 40) {
    $newsRisk = 20;
} else {
    $newsRisk = 10;
}

// Total Risk
$totalRisk =
    $inflationRisk +
    $weatherRisk +
    $currencyRisk +
    $newsRisk;

    $riskTrend = [];

for ($i = 0; $i < 5; $i++) {

    $riskTrend[] = [
        'year' => date('Y') - $i,
        'value' => max(
            0,
            min(
                100,
                $totalRisk + rand(-10, 10)
            )
        )
    ];
}

$riskTrend = array_reverse($riskTrend);

    if ($totalRisk <= 40) {
    $riskStatus = 'Low Risk';
} elseif ($totalRisk <= 70) {
    $riskStatus = 'Medium Risk';
} else {
    $riskStatus = 'High Risk';
}


return view('countries.index', compact(
    'countries',
    'countryData',
    'gdp',
    'inflation',
    'population',
    'currency',
    'temperature',
    'windSpeed',
    'exchangeRate',
    'news',
    'totalRisk',
    'riskStatus',
    'positivePercent',
    'negativePercent',
    'gdpTrend',
    'inflationTrend',
    'riskTrend'
));
}
}