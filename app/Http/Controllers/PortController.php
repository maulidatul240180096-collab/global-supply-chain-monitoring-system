<?php

namespace App\Http\Controllers;

class PortController extends Controller
{
    public function index()
    {
      $ports = [

    ['name'=>'Tanjung Priok','country'=>'Indonesia','lat'=>-6.104,'lng'=>106.880],
    ['name'=>'Belawan','country'=>'Indonesia','lat'=>3.784,'lng'=>98.683],
    ['name'=>'Tanjung Perak','country'=>'Indonesia','lat'=>-7.204,'lng'=>112.734],

    ['name'=>'Port of Shanghai','country'=>'China','lat'=>31.230,'lng'=>121.490],
    ['name'=>'Port of Ningbo','country'=>'China','lat'=>29.868,'lng'=>121.544],
    ['name'=>'Port of Shenzhen','country'=>'China','lat'=>22.543,'lng'=>114.057],

    ['name'=>'Port of Singapore','country'=>'Singapore','lat'=>1.264,'lng'=>103.840],

    ['name'=>'Port of Hamburg','country'=>'Germany','lat'=>53.546,'lng'=>9.966],
    ['name'=>'Port of Bremen','country'=>'Germany','lat'=>53.079,'lng'=>8.801],

    ['name'=>'Port of Rotterdam','country'=>'Netherlands','lat'=>51.924,'lng'=>4.477],

    ['name'=>'Port of Sydney','country'=>'Australia','lat'=>-33.868,'lng'=>151.209],
    ['name'=>'Port of Melbourne','country'=>'Australia','lat'=>-37.814,'lng'=>144.963],

    ['name'=>'Port of Los Angeles','country'=>'United States','lat'=>33.740,'lng'=>-118.270],
    ['name'=>'Port of New York','country'=>'United States','lat'=>40.712,'lng'=>-74.006],

    ['name'=>'Port of Mumbai','country'=>'India','lat'=>18.949,'lng'=>72.840],
    ['name'=>'Port of Chennai','country'=>'India','lat'=>13.082,'lng'=>80.270],

    ['name'=>'Port of Busan','country'=>'South Korea','lat'=>35.102,'lng'=>129.040],

    ['name'=>'Port of Tokyo','country'=>'Japan','lat'=>35.676,'lng'=>139.650],
    ['name'=>'Port of Yokohama','country'=>'Japan','lat'=>35.443,'lng'=>139.638],

    ['name'=>'Port of Dubai','country'=>'UAE','lat'=>25.276,'lng'=>55.296],

];

$selectedCountry = request('country');
$search = request('search');

$countries = collect($ports)
    ->pluck('country')
    ->unique()
    ->sort()
    ->values();

if ($selectedCountry) {

    $ports = array_filter(
        $ports,
        fn($port) => $port['country'] == $selectedCountry
    );

}

if ($search) {

    $ports = array_filter(
        $ports,
        fn($port) =>
            str_contains(
                strtolower($port['name']),
                strtolower($search)
            )
    );

}

return view('ports.index', [
    'ports' => $ports,
    'countries' => $countries
]);
    }
}