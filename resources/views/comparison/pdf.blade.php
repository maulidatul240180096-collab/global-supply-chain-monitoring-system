<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>

        body{
            font-family: Arial, sans-serif;
            font-size:12px;
            line-height:1.6;
            margin:30px;
        }

        h1{
            text-align:center;
            margin-bottom:5px;
        }

        h3{
            margin-top:25px;
            margin-bottom:10px;
        }

        p{
            text-align:justify;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:15px;
        }

        th,td{
            border:1px solid #000;
            padding:8px;
        }

        th{
            background:#f2f2f2;
        }

        .section{
            margin-top:20px;
        }

    </style>
</head>

<body>

<h1>Country Comparison Report</h1>

<p>
    <strong>Generated:</strong>
    {{ now()->format('d F Y H:i') }}
</p>

<h3>Report Purpose</h3>

<p>
    This report compares
    <strong>{{ $dataA['name']['common'] }}</strong>
    and
    <strong>{{ $dataB['name']['common'] }}</strong>
    using economic indicators, population size, currency conditions,
    weather information, and export risk assessment.
    The objective is to support decision making when selecting
    international export destinations.
</p>

<table>

    <tr>
        <th>Data</th>
        <th>{{ $dataA['name']['common'] }}</th>
        <th>{{ $dataB['name']['common'] }}</th>
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
        <td>{{ number_format($exchangeRateA,2) }}</td>
        <td>{{ number_format($exchangeRateB,2) }}</td>
    </tr>

    <tr>
        <td>GDP</td>
        <td>${{ number_format($gdpA,0) }}</td>
        <td>${{ number_format($gdpB,0) }}</td>
    </tr>

    <tr>
        <td>Inflation</td>
        <td>{{ number_format($inflationA,2) }}%</td>
        <td>{{ number_format($inflationB,2) }}%</td>
    </tr>

    <tr>
        <td>Temperature</td>
        <td>{{ $tempA }} °C</td>
        <td>{{ $tempB }} °C</td>
    </tr>

    <tr>
        <td>Risk Score</td>
        <td>{{ $riskA }}</td>
        <td>{{ $riskB }}</td>
    </tr>

    <tr>
        <td>Risk Status</td>
        <td>{{ $statusA }}</td>
        <td>{{ $statusB }}</td>
    </tr>

</table>

<h3>Economic Analysis</h3>

<p>

@if($gdpA > $gdpB)

{{ $dataA['name']['common'] }}
has a larger economy with a GDP of
${{ number_format($gdpA,0) }},
compared to
{{ $dataB['name']['common'] }}
with a GDP of
${{ number_format($gdpB,0) }}.

@else

{{ $dataB['name']['common'] }}
has a larger economy with a GDP of
${{ number_format($gdpB,0) }},
compared to
{{ $dataA['name']['common'] }}
with a GDP of
${{ number_format($gdpA,0) }}.

@endif

A larger GDP generally indicates stronger economic activity,
greater purchasing power, and broader market opportunities
for international exporters.

</p>

<h3>Population Analysis</h3>

<p>

@if($populationA > $populationB)

{{ $dataA['name']['common'] }}
has a larger population than
{{ $dataB['name']['common'] }},
which may indicate a larger potential consumer market.

@else

{{ $dataB['name']['common'] }}
has a larger population than
{{ $dataA['name']['common'] }},
which may indicate a larger potential consumer market.

@endif

Population size can be an important factor when evaluating
future market demand and business expansion opportunities.

</p>

<h3>Risk Analysis</h3>

<p>

@if($riskA < $riskB)

{{ $dataA['name']['common'] }}
shows a lower export risk score than
{{ $dataB['name']['common'] }}.

@elseif($riskB < $riskA)

{{ $dataB['name']['common'] }}
shows a lower export risk score than
{{ $dataA['name']['common'] }}.

@else

Both countries have the same export risk score.

@endif

The risk score is calculated using available economic indicators,
including GDP and inflation conditions.

</p>

<h3>Export Recommendation</h3>

<p>

@if($riskA < $riskB)

Based on the available indicators,
<strong>{{ $dataA['name']['common'] }}</strong>
is recommended as the preferred export destination because it
has a lower risk score while maintaining favorable economic conditions.

@elseif($riskB < $riskA)

Based on the available indicators,
<strong>{{ $dataB['name']['common'] }}</strong>
is recommended as the preferred export destination because it
has a lower risk score while maintaining favorable economic conditions.

@else

Both countries show similar export risk levels.
Additional market research and product-specific analysis
are recommended before selecting a final destination.

@endif

</p>

<h3>Conclusion</h3>

<p>

This report compared
{{ $dataA['name']['common'] }}
and
{{ $dataB['name']['common'] }}
using economic, demographic, weather, and risk indicators.

The analysis indicates that exporters should prioritize
countries with stronger economic performance and lower risk scores
to improve the probability of successful international trade activities.

</p>

</body>
</html>