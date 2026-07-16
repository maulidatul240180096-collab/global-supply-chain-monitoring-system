<?php

namespace App\Http\Controllers;
use App\Models\Favorite;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{

    public function index()
    {

        $totalCountries = 254;

        $totalPorts = 20;

        $highestRiskCountry =
            session('highestRiskCountry', '-');

        $lowestRiskCountry =
            session('lowestRiskCountry', '-');

        $averageRisk =
        (
            session('riskA', 0)
            +
            session('riskB', 0)
        ) / 2;


        $exportDestinations = Favorite::count();

        $totalUsers = User::count();

        $news = [];


        $response = Http::get(
            'https://gnews.io/api/v4/search',
            [
                'q' => 'supply chain OR logistics OR export',
                'lang' => 'en',
                'max' => 5,
                'apikey' => env('GNEWS_API_KEY')
            ]
        );


        if ($response->successful()) {

            $news =
            $response->json()['articles'] ?? [];

        }


        $totalNews = count($news);


        return view('dashboard', compact(
            'totalCountries',
            'totalPorts',
            'averageRisk',
            'highestRiskCountry',
            'lowestRiskCountry',
            'exportDestinations',
            'totalUsers',
            'totalNews',
            'news'
        ));

    }


    public function exportPdf()
    {

        $data = [

            'totalCountries' => 254,

            'totalPorts' => 20,

            'exportDestinations' => Favorite::count(),

            'totalUsers' => User::count(),

            'highestRiskCountry' =>
                session('highestRiskCountry', '-'),

            'lowestRiskCountry' =>
                session('lowestRiskCountry', '-'),

            'averageRisk' =>
            (
                session('riskA', 0)
                +
                session('riskB', 0)
            ) / 2

        ];


        $pdf = Pdf::loadView(
            'dashboard.report',
            $data
        );


        return $pdf->download(
            'dashboard-report.pdf'
        );

    }

}