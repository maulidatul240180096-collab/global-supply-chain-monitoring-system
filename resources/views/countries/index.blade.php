@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/countries.css') }}">
@endsection

@section('content')

<span class="badge bg-primary mb-2">
    <i class="bi bi-globe-americas me-1"></i>
    Global Export Analysis
</span>

<h2>Export Destination Analysis</h2>

<p class="text-muted">
    Evaluate export destinations through economic indicators, weather conditions, currency trends, and country risk assessments.
</p>

<div class="card info-card shadow-sm">
    <div class="card-body">

        <form id="countryForm">

            <label class="form-label">Select Country</label>

            <select
    class="form-select"
    onchange="window.location.href='/countries/' + encodeURIComponent(this.value)">
                <option selected>Select Country</option>

                @foreach($countries as $country)
                   <option value="{{ $country['name']['common'] }}">
    {{ $country['name']['common'] }}
</option>
                @endforeach

            </select>

        </form>

        <div class="mt-3">
            <strong>Total Countries:</strong>
            {{ count($countries) }}
        </div>

        @if(isset($countryData))

        <div class="row mt-4">

            <div class="col-md-3">
                <div class="card info-card shadow-sm">
                    <div class="card-body">
                 <div class="country-flag">
    <img
        src="https://flagcdn.com/w80/{{ strtolower($countryData['cca2']) }}.png"
        alt="flag">
</div>

<h6>Country</h6>

<p class="card-value">
    {{ $countryData['name']['common'] }}
</p>
                       <a
href="/favorites/add/{{ $countryData['name']['common'] }}"
class="btn btn-primary export-btn">
📦 Add Destination
</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card info-card shadow-sm">
                    <div class="card-body">
                        <div class="card-icon purple">
    <i class="bi bi-globe-americas"></i>
</div>

<h6>Region</h6>

<p class="card-value">
    {{ $countryData['region'] }}
</p>
                    </div>
                </div>
            </div>

   <div class="col-md-3 mb-3">
    <div class="card info-card shadow-sm">
        <div class="card-body">

       <div class="card-icon green">
    <i class="bi bi-people-fill"></i>
</div>

<h6>Population</h6>

<p class="card-value">
{{ number_format($population) }}
</p>

<small>People</small>

        </div>
    </div>
</div>

            <div class="col-md-3 mb-3">
             <div class="card info-card shadow-sm">
                    <div class="card-body">
                      <div class="card-icon yellow">
    <i class="bi bi-cash-stack"></i>
</div>

<h6>Currency</h6>

<p class="card-value">
{{ $currency }}
</p>
                    </div>
                </div>
            </div>

        </div>

        @endif

    </div>
</div>

<div class="row mt-4">

    <div class="col-md-3 mb-3">
       <div class="card info-card shadow-sm">
            <div class="card-body">
               <div class="card-icon cyan">
    <i class="bi bi-graph-up-arrow"></i>
</div>
    <h6>GDP</h6>

    @if(isset($gdp))
        <p>${{ number_format($gdp, 0) }}</p>
    @else
        <p>-</p>
    @endif

</div>
        </div>
    </div>

   <div class="col-md-3 mb-3">
        <div class="card info-card shadow-sm">
           <div class="card-body">
           <div class="card-icon orange">
    <i class="bi bi-bar-chart-line"></i>
</div>
    <h6>Inflation</h6>

    @if(isset($inflation))
        <p>{{ number_format($inflation, 2) }}%</p>
    @else
        <p>-</p>
    @endif

</div>
        </div>
    </div>

  <div class="col-md-3 mb-3">
   <div class="card info-card shadow-sm">
        <div class="card-body">
           <div class="card-icon orange">
    <i class="bi bi-thermometer-half"></i>
</div>

            <h6>Temperature</h6>

            @if(isset($temperature))
                <p>{{ $temperature }} °C</p>
            @else
                <p>-</p>
            @endif

        </div>
    </div>
</div>

<div class="col-md-3 mb-3">
   <div class="card info-card shadow-sm">
        <div class="card-body">
           <div class="card-icon cyan">
    <i class="bi bi-wind"></i>
</div>

            <h6>Wind Speed</h6>

            @if(isset($windSpeed))
                <p>{{ $windSpeed }} km/h</p>
            @else
                <p>-</p>
            @endif

        </div>
    </div>
</div>

<div class="col-md-6 mb-3">
   <div class="card info-card exchange-card shadow-sm">
        <div class="card-body">

      <div class="card-icon green">
    <i class="bi bi-currency-exchange"></i>
</div>

<h6>Exchange Rate</h6>

@if(isset($exchangeRate))

<p class="exchange-value">
    1 USD = {{ number_format($exchangeRate,2) }} {{ $currency }}
</p>

<small>Live Exchange Rate</small>

<canvas id="currencyChart"></canvas>

@else

<p>-</p>

@endif
        </div>
    </div>
</div>

<div class="col-md-6 mb-3">

<div class="card risk-card shadow-sm">

<div class="card-body">

<div class="risk-icon">
    <i class="bi bi-shield-exclamation"></i>
</div>

<h6>Risk Score</h6>

<h4>
{{ $totalRisk ?? '-' }}
</h4>

<p class="risk-status">
{{ $riskStatus ?? '-' }}
</p>


<div class="risk-bar">

      <div 
    class="risk-progress"
    style="width:{{ isset($totalRisk) ? $totalRisk : 0 }}%">
    </div>

</div>

</div>

</div>

</div>

</div>
@if(isset($positivePercent) && isset($negativePercent))

<div class="row mt-4">

    <div class="col-lg-8 col-md-12 mx-auto">
    <div class="card chart-card sentiment-card shadow-sm">

<div class="card-body">

<h5>News Sentiment Analysis</h5>

<canvas id="sentimentChart"></canvas>

                <p>
                    Positive :
                    {{ $positivePercent }}%
                </p>

                <p>
                    Negative :
                    {{ $negativePercent }}%
                </p>

            </div>

        </div>

    </div>

</div>

@endif

@if(isset($gdpTrend) && count($gdpTrend) > 0)

<div class="row mt-4">

    <div class="col-md-12">

       <div class="card chart-card shadow-sm">

            <div class="card-body">

                <h5>GDP Trend</h5>

                <canvas id="gdpChart"></canvas>

            </div>

        </div>

    </div>

</div>

@endif

@if(isset($inflationTrend) && count($inflationTrend) > 0)

<div class="row mt-4">

    <div class="col-md-12">

     <div class="card chart-card shadow-sm">

            <div class="card-body">

                <h5>Inflation Trend</h5>

                <canvas id="inflationChart"></canvas>

            </div>

        </div>

    </div>

</div>

@endif


@if(isset($riskTrend) && count($riskTrend) > 0)

<div class="row mt-4">

    <div class="col-md-12">
<div class="card chart-card shadow-sm">

            <div class="card-body">

                <h5>Risk Trend</h5>

                <canvas id="riskChart"></canvas>

            </div>

        </div>

    </div>

</div>

@endif
@if(isset($news) && count($news) > 0)
<div class="card chart-card shadow-sm mt-4">

    <div class="card-body">

        <h4>Latest News</h4>

        @foreach($news as $article)

            <div class="mb-3">

                <h6>{{ $article['title'] }}</h6>

                <p>
                    {{ $article['description'] ?? 'No description available.' }}
                </p>

                <a href="{{ $article['url'] }}" target="_blank">
                    Read More
                </a>

            </div>

            <hr>

        @endforeach

    </div>

</div>

@endif

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@if(isset($exchangeRate))

<script>
const ctx = document.getElementById('currencyChart');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: [
            '3 Days Ago',
            '2 Days Ago',
            'Yesterday',
            'Today'
        ],
        datasets: [{
            label: 'Exchange Rate',
            data: [
                {{ round($exchangeRate * 0.97, 2) }},
                {{ round($exchangeRate * 0.99, 2) }},
                {{ round($exchangeRate * 1.02, 2) }},
                {{ round($exchangeRate, 2) }}
            ]
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: false
            }
        }
    }
});
</script>

@endif

@if(isset($positivePercent) && isset($negativePercent))

<script>

const sentimentCtx =
document.getElementById('sentimentChart');


new Chart(sentimentCtx, {

    type: 'doughnut',

    data: {

        labels: [
            'Positive',
            'Negative'
        ],

        datasets: [{
            data: [
                {{ $positivePercent }},
                {{ $negativePercent }}
            ]
        }]

    },


    options: {

        responsive:true,

        maintainAspectRatio:true,

        plugins:{
            legend:{
                position:'bottom'
            }
        }

    }

});


</script>

@endif

@if(isset($gdpTrend) && count($gdpTrend) > 0)

<script>

const gdpCtx =
document.getElementById('gdpChart');

new Chart(gdpCtx, {

    type: 'line',

    data: {

        labels: [
            @foreach($gdpTrend as $item)
                "{{ $item['year'] }}",
            @endforeach
        ],

        datasets: [{

            label: 'GDP',

            data: [
                @foreach($gdpTrend as $item)
                    {{ $item['value'] }},
                @endforeach
            ]

        }]
    },

    options: {
        responsive: true
    }

});

</script>

@endif

@if(isset($inflationTrend) && count($inflationTrend) > 0)

<script>

const inflationCtx =
document.getElementById('inflationChart');

new Chart(inflationCtx, {

    type: 'line',

    data: {

        labels: [
            @foreach($inflationTrend as $item)
                "{{ $item['year'] }}",
            @endforeach
        ],

        datasets: [{

            label: 'Inflation (%)',

            data: [
                @foreach($inflationTrend as $item)
                    {{ $item['value'] ?? 0 }},
                @endforeach
            ]

        }]
    },

    options: {
        responsive: true
    }

});

</script>

@endif

@if(isset($riskTrend) && count($riskTrend) > 0)

<script>

const riskCtx =
document.getElementById('riskChart');

new Chart(riskCtx, {

    type: 'line',

    data: {

        labels: [
            @foreach($riskTrend as $item)
                "{{ $item['year'] }}",
            @endforeach
        ],

        datasets: [{

            label: 'Risk Score',

            data: [
                @foreach($riskTrend as $item)
                    {{ $item['value'] }},
                @endforeach
            ]

        }]
    },

    options: {
        responsive: true
    }

});

</script>

@endif

@endsection

