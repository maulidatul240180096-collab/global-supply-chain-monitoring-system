@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@section('content')

<span class="badge bg-primary mb-2">
    <i class="bi bi-globe-americas me-1"></i>
    Global Export Analysis
</span>

<h2>Export Risk & Market Insights</h2>

<p class="text-muted">
    Analyze export destinations, economic conditions, logistics performance,
    and market risks before international trade decisions.
</p>

<div class="text-muted mb-3">
    Last Update: {{ now()->format('d F Y H:i') }}
</div>

@if(Auth::user()->role == 'admin')
<div class="mb-3">
    <a href="/dashboard/pdf" class="btn btn-danger">
        <i class="bi bi-file-earmark-pdf"></i>
        Export Dashboard Report
    </a>
</div>
@endif

<div class="alert alert-info">
    Dashboard provides export destination insights based on economic,
    weather, and logistics indicators.
</div>

<div class="row g-3">

    <div class="col-md-3">
        <div class="card stat-card countries-card shadow-sm">
            <div class="card-body">
                <div class="card-icon blue">
                    <i class="bi bi-globe-americas"></i>
                </div>
                <h6>Total Countries</h6>
                <h3>{{ $totalCountries }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card ports-card shadow-sm">
            <div class="card-body">
                <div class="card-icon orange">
                    <i class="bi bi-water"></i>
                </div>
                <h6>Total Ports</h6>
                <h3>{{ $totalPorts }}</h3>
            </div>
        </div>
    </div>

   @if(Auth::user()->role == 'admin')
<div class="col-md-3">
    <div class="card stat-card export-card shadow-sm">
        <div class="card-body">
            <div class="card-icon green">
                <i class="bi bi-box-seam"></i>
            </div>
            <h6>Export Destinations</h6>
            <h3>{{ $exportDestinations }}</h3>
        </div>
    </div>
</div>
@endif

@if(Auth::user()->role == 'admin')
    <div class="col-md-3">
        <div class="card stat-card risk-card shadow-sm">
            <div class="card-body">
                <div class="card-icon red">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>
                <h6>Average Risk</h6>
                <h3>{{ $averageRisk }}</h3>
            </div>
        </div>
    </div>
    @endif

    @if(Auth::user()->role == 'admin')
<div class="col-md-3">
    <div class="card stat-card shadow-sm">
        <div class="card-body">
            <div class="card-icon blue">
                <i class="bi bi-people-fill"></i>
            </div>
            <h6>Total Users</h6>
            <h3>{{ $totalUsers }}</h3>
        </div>
    </div>
</div>
@endif

    <div class="col-md-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body">
                <div class="card-icon orange">
                    <i class="bi bi-newspaper"></i>
                </div>
                <h6>News Articles</h6>
                <h3>{{ $totalNews }}</h3>
            </div>
        </div>
    </div>

    @if(Auth::user()->role == 'admin')
    <div class="col-md-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body">
                <div class="card-icon red">
                    <i class="bi bi-shield-exclamation"></i>
                </div>
                <h6>Highest Risk Country</h6>
                <h5>{{ $highestRiskCountry }}</h5>
            </div>
        </div>
    </div>
@endif

@if(Auth::user()->role == 'admin')
    <div class="col-md-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body">
                <div class="card-icon green">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h6>Lowest Risk Country</h6>
                <h5>{{ $lowestRiskCountry }}</h5>
            </div>
        </div>
    </div>

</div>
@endif

@if(Auth::user()->role == 'admin')
<div class="card mt-4">
    <div class="card-body">
        <h4>Risk Overview</h4>
        <canvas id="riskChart"></canvas>
    </div>
</div>
@endif

@if(Auth::user()->role == 'admin')
<div class="card mt-4 shadow-sm">
    <div class="card-body">

        <h4>Risk Summary</h4>

        <hr>

        <p>
            Highest Risk Country:
            <strong>{{ $highestRiskCountry }}</strong>
        </p>

        <p>
            Lowest Risk Country:
            <strong>{{ $lowestRiskCountry }}</strong>
        </p>

        <p>
            Average Risk Score:
            <strong>{{ $averageRisk }}</strong>
        </p>

    </div>
</div>
@endif

@if(isset($news) && count($news) > 0)

<div id="news-section" class="card chart-card shadow-sm mt-4">

    <div class="card-body">

        <h4>Latest Global Supply Chain News</h4>

        <div class="mb-3 mt-3">
            <input
                type="text"
                id="newsSearch"
                class="form-control"
                placeholder="Search news by title or description...">
        </div>

        <hr>

        @foreach($news as $article)

        <div class="news-item news-card mb-4">

            <div class="row">

                <div class="col-md-3">

                    @if(isset($article['image']))
                        <img
                            src="{{ $article['image'] }}"
                            class="img-fluid rounded">
                    @endif

                </div>

                <div class="col-md-9">

                    <h5>{{ $article['title'] }}</h5>

                    <p class="text-muted">
                        {{ $article['description'] }}
                    </p>

                    <small class="text-secondary">
                        {{ $article['source']['name'] }}
                        |
                        {{ \Carbon\Carbon::parse($article['publishedAt'])->format('d M Y H:i') }}
                    </small>

                    <br><br>

                    <a
                        href="{{ $article['url'] }}"
                        target="_blank"
                        class="btn btn-primary btn-sm">
                        Read More
                    </a>

                </div>

            </div>

        </div>

        <hr>

        @endforeach

    </div>

</div>

@endif

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
new Chart(
    document.getElementById('riskChart'),
    {
        type: 'doughnut',
        data: {
            labels: [
                'Highest Risk',
                'Average Risk',
                'Lowest Risk'
            ],
            datasets: [{
                label: 'Risk Score',
                data: [
                    100,
                    {{ $averageRisk }},
                    0
                ]
            }]
        }
    }
);
</script>

<script>
document.getElementById('newsSearch')
?.addEventListener('keyup', function () {

    let keyword = this.value.toLowerCase();

    document.querySelectorAll('.news-card')
    .forEach(function(card) {

        let text = card.innerText.toLowerCase();

        if (text.includes(keyword)) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }

    });

});
</script>

@endsection