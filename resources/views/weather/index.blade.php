@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/weather.css') }}">
@endsection


@section('content')

<span class="badge bg-primary mb-2">
    <i class="bi bi-globe-americas me-1"></i>
    Global Export Analysis
</span>

<h2>Weather & Logistics Analysis</h2>

<p class="text-muted">
    Evaluate weather conditions and their impact on logistics operations and export activities.
</p>

<form method="GET">

    <div class="mb-3">

        <label class="form-label">
            Select Country
        </label>

        <select
            name="country"
            class="form-select"
            onchange="this.form.submit()">

            <option value="">
                Select Country
            </option>

            @foreach($countries as $country)

                <option
                    value="{{ $country['name']['common'] }}"
                    {{ $selectedCountry == $country['name']['common'] ? 'selected' : '' }}>

                    {{ $country['name']['common'] }}

                </option>

            @endforeach

        </select>

    </div>

</form>

@if($weather)

<div class="row">

    <div class="col-md-4 mb-3">
       <div class="card info-card shadow-sm">
            <div class="card-body text-center">
                <div class="card-icon orange">
    <i class="bi bi-thermometer-half"></i>
</div>

<h6>Temperature</h6>
                <h3>
                    {{ $weather['current']['temperature_2m'] }} °C
                </h3>
            </div>
        </div>
    </div>


    <div class="col-md-4 mb-3">
      <div class="card info-card shadow-sm">
            <div class="card-body text-center">
                <div class="card-icon cyan">
    <i class="bi bi-wind"></i>
</div>

<h6>Wind Speed</h6>
                <h3>
                    {{ $weather['current']['wind_speed_10m'] }}
                </h3>
                <small>km/h</small>
            </div>
        </div>
    </div>


    <div class="col-md-4 mb-3">
       <div class="card info-card shadow-sm">
            <div class="card-body text-center">
               <div class="card-icon yellow">
    <i class="bi bi-brightness-high"></i>
</div>

<h6>Weather Status</h6>
                <h4>{{ $weatherStatus }}</h4>
            </div>
        </div>
    </div>


   <div class="col-md-4 mb-3">
      <div class="card info-card shadow-sm">
            <div class="card-body text-center">
                <div class="card-icon blue">
    <i class="bi bi-truck"></i>
</div>

<h6>Logistics Impact</h6>
                <h6>{{ $impact }}</h6>
            </div>
        </div>
    </div>
<div class="col-md-4 mb-3">
   <div class="card risk-card shadow-sm">
        <div class="card-body text-center">

           <div class="card-icon red">
    <i class="bi bi-exclamation-triangle-fill"></i>
</div>

            <h6>Weather Risk</h6>

            <h4>
                {{ $weatherRisk }}
            </h4>

        </div>
    </div>
</div>
</div>

<div class="card shadow-sm mt-4">
    <div class="card-body">

        <h5>
            Weather Analysis for
            {{ $selectedCountry }}
        </h5>

        <small class="text-muted">
    Last Updated:
    {{ $lastUpdate }}
</small>

<hr>

        <p>
            Current weather status:
            <strong>{{ $weatherStatus }}</strong>
        </p>

       <p>
    Supply chain condition:
    <strong>{{ $impact }}</strong>
</p>

<p>
    Weather risk:
    <strong>{{ $weatherRisk }}</strong>
</p>

<p>
    Recommendation:
    <strong>{{ $recommendation }}</strong>
</p>
</div>
</div>

<div class="card mt-4">
    <div class="card-body">
        <h5>Weather Overview</h5>
        <canvas id="weatherChart"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
new Chart(
    document.getElementById('weatherChart'),
    {
        type: 'bar',
        data: {
            labels: [
                'Temperature',
                'Wind Speed'
            ],
            datasets: [{
                label: 'Weather Metrics',
                data: [
                    {{ $weather['current']['temperature_2m'] }},
                    {{ $weather['current']['wind_speed_10m'] }}
                ]
            }]
        }
    }
);
</script>

@endif

@endsection