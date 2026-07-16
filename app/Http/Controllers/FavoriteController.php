<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FavoriteController extends Controller
{
  public function index()
{
    $favorites = \App\Models\Favorite::all();

    $allCountries = json_decode(
    file_get_contents(
        storage_path('app/countries.json')
    ),
    true
);

  $totalDestinations = $favorites->count();
  
$insightText = "You currently have {$totalDestinations} export destinations.";

$asiaMarkets = 0;
$europeMarkets = 0;

$highMarkets = 0;
$emergingMarkets = 0;

$largestPopulation = 0;
$largestCountry = '-';

foreach ($favorites as $favorite) {


$country = collect($allCountries)->first(
    fn ($item) =>
        strtolower($item['name']['common']) === strtolower($favorite->country_name)
);



if (!$country) {
    continue;
}


$region = $country['region'] ?? '';

$response = Http::get(
    "https://api.worldbank.org/v2/country/{$country['cca3']}/indicator/SP.POP.TOTL?format=json"
);

$population =
    $response->json()[1][0]['value']
    ?? 0;


if ($population > $largestPopulation) {

    $largestPopulation = $population;
    $largestCountry = $favorite->country_name;

}


if ($region == 'Asia') {
    $asiaMarkets++;
}

if ($region == 'Europe') {
    $europeMarkets++;
}

}

$insightText =
    "You currently have {$totalDestinations} export destinations. {$largestCountry} has the largest market size based on population.";

    $tableData = [];

foreach ($favorites as $favorite) {

    $country = collect($allCountries)->first(
        fn ($item) =>
        strtolower($item['name']['common']) === strtolower($favorite->country_name)
    );

    if (!$country) {
        continue;
    }

    $populationResponse = Http::get(
        "https://api.worldbank.org/v2/country/{$country['cca3']}/indicator/SP.POP.TOTL?format=json"
    );

    $population =
        $populationResponse->json()[1][0]['value']
        ?? 0;

    $potential =
        $population > 100000000
        ? 'High'
        : 'Emerging';

        if ($potential == 'High') {
    $highMarkets++;
} else {
    $emergingMarkets++;
}

    $tableData[] = [
        'name' => $favorite->country_name,
        'region' => $country['region'] ?? '-',
        'population' => $population,
        'potential' => $potential,
        'id' => $favorite->id
    ];
}

usort($tableData, function ($a, $b) {
    return $b['population'] <=> $a['population'];
});

return view('favorites.index', compact(
    'favorites',
    'totalDestinations',
    'asiaMarkets',
    'europeMarkets',
    'insightText',
    'tableData',
    'highMarkets',
    'emergingMarkets'
));
}

    public function store($country)
    {
        Favorite::firstOrCreate([
            'country_name' => $country
        ]);

        return redirect('/favorites');
    }

    public function destroy($id)
    {
        Favorite::findOrFail($id)->delete();

        return redirect('/favorites');
    }
}