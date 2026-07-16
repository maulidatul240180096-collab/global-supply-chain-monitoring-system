@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/comparison.css') }}">
@endsection

@section('content')

<span class="badge bg-primary mb-2">
    <i class="bi bi-globe-americas me-1"></i>
    Global Export Analysis
</span>

<h2>Export Destination Comparison</h2>

<p class="text-muted">
    Compare export destinations based on economic indicators, weather conditions, exchange rates, and country risk assessments.
</p>

<div class="card comparison-card">
    <div class="card-body">

        <form method="GET" action="/comparison">

            <div class="row">

                <div class="col-md-5">

                    <label>Country A</label>

                    <select name="countryA" class="form-select">

                        <option selected>Select Country</option>

                       @foreach($countries as $country)
    <option
    value="{{ $country['name']['common'] }}"
    {{ request('countryA') == $country['name']['common'] ? 'selected' : '' }}
>
    {{ $country['name']['common'] }}
</option>
@endforeach

                    </select>

                </div>

                <div class="col-md-5">

                    <label>Country B</label>

                 <select name="countryB" class="form-select">

    <option value="">Select Country</option>

    @foreach($countries as $country)

        <option
            value="{{ $country['name']['common'] }}"
            {{ request('countryB') == $country['name']['common'] ? 'selected' : '' }}
        >
            {{ $country['name']['common'] }}
        </option>

    @endforeach

</select>

                </div>

                <div class="col-md-2">

                    <label>&nbsp;</label>

                   <button
type="submit"
class="btn btn-primary w-100">
<i class="bi bi-arrow-left-right"></i>
 Compare
</button>

                </div>

            </div>

        </form>

      </div>
</div>

@if(isset($dataA) && isset($dataB))

<div class="card comparison-card mt-4">
    <div class="card-body">

       <h4>
<i class="bi bi-bar-chart-line"></i>
 Comparison Result
</h4>

        <table class="table table-bordered">


           <tr>
    <th>Data</th>

    <th>
        <img src="https://flagsapi.com/{{ $dataA['cca2'] }}/flat/32.png">
        {{ $dataA['name']['common'] }}
    </th>

    <th>
        <img src="https://flagsapi.com/{{ $dataB['cca2'] }}/flat/32.png">
        {{ $dataB['name']['common'] }}
    </th>
</tr>
<tr>
    <td>Flag</td>

    <td>
        <img src="https://flagsapi.com/{{ $dataA['cca2'] }}/flat/64.png">
    </td>

    <td>
        <img src="https://flagsapi.com/{{ $dataB['cca2'] }}/flat/64.png">
    </td>
</tr>

            <tr>
                <td>Region</td>
                <td>{{ $dataA['region'] }}</td>
                <td>{{ $dataB['region'] }}</td>
            </tr>

            <tr>
                <td>Population</td>
<td>{{ number_format($populationA) }}</td>
<td>{{ number_format($populationB) }}</td>
            </tr>

            <tr>
    <td>Currency</td>
    <td>{{ $currencyA }}</td>
    <td>{{ $currencyB }}</td>
</tr>

<tr>
    <td>Exchange Rate</td>
    <td>{{ number_format($exchangeRateA, 2) }}</td>
    <td>{{ number_format($exchangeRateB, 2) }}</td>
</tr>

<tr>
    <td>GDP</td>
    <td>${{ number_format($gdpA, 0) }}</td>
    <td>${{ number_format($gdpB, 0) }}</td>
</tr>

<tr>
    <td>Inflation</td>
    <td>{{ number_format($inflationA, 2) }}%</td>
    <td>{{ number_format($inflationB, 2) }}%</td>
</tr>
<tr>
    <td>Temperature</td>
    <td>{{ $tempA }} °C</td>
    <td>{{ $tempB }} °C</td>
</tr>
<tr>
    <td>Risk Score</td>

    <td>
        {{ $riskA }}
        @if($riskA >= 50)
            <span class="badge bg-danger">High Risk</span>
        @else
            <span class="badge bg-success">Low Risk</span>
        @endif
    </td>

    <td>
        {{ $riskB }}
        @if($riskB >= 50)
            <span class="badge bg-danger">High Risk</span>
        @else
            <span class="badge bg-success">Low Risk</span>
        @endif
    </td>
</tr>
        </table>

    </div>
</div>


<div class="card mt-4">
    <div class="card-body">

        <h4>
<i class="bi bi-graph-up"></i>
 Comparison Chart
</h4>

        <canvas id="comparisonChart"></canvas>

    </div>
</div>


<div class="card mt-4">
    <div class="card-body">

        <h4>
<i class="bi bi-file-earmark-text"></i>
 Comparison Summary
</h4>

        @if($riskA < $riskB)

            <div class="alert alert-success">
                {{ $dataA['name']['common'] }}
               has a lower export risk than
                {{ $dataB['name']['common'] }}.
            </div>

        @elseif($riskB < $riskA)

            <div class="alert alert-success">
                {{ $dataB['name']['common'] }}
                is a safer export destination than
                {{ $dataA['name']['common'] }}.
            </div>

    @else

    <div class="alert alert-warning">
        Both countries have the same export risk score.
    </div>

@endif

    </div>
</div>

<div class="mt-3">
    <a
href="/comparison/pdf"
class="btn btn-danger">
<i class="bi bi-file-earmark-pdf"></i>
 Download PDF
</a>
</div>

@endif


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@if(isset($dataA) && isset($dataB))

<script>

const comparisonCtx =
document.getElementById('comparisonChart');

new Chart(comparisonCtx, {

    type: 'bar',

    data: {

     labels: [
    'GDP (Log)',
    'Inflation',
    'Temperature',
    'Risk Score'
],

        datasets: [

            {
                label: '{{ $dataA["name"]["common"] }}',

                data: [
    Math.log10({{ $gdpA }}),
    {{ $inflationA }},
    {{ $tempA }},
    {{ $riskA }}
]
            },

            {
                label: '{{ $dataB["name"]["common"] }}',

            data: [
    Math.log10({{ $gdpB }}),
    {{ $inflationB }},
    {{ $tempB }},
    {{ $riskB }}
]
            }

        ]
    },

    options: {
        responsive: true
    }

});

</script>

@endif

@endsection