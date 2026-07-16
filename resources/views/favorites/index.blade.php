@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/favorites.css') }}">
@endsection

@section('content')

<span class="badge bg-primary mb-2">
    <i class="bi bi-globe-americas me-1"></i>
    Global Export Analysis
</span>

<h2>Export Destinations</h2>

<p class="text-muted">
    Manage and review countries identified as potential export markets.
</p>

<div class="row mb-4">

    <div class="col-md-4">
        <div class="card shadow-sm border-0 stats-card">
            <div class="card-body">
                <h6 class="text-muted">Total Destinations</h6>
                <h2 class="fw-bold">{{ $totalDestinations }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 stats-card">
            <div class="card-body">
                <h6 class="text-muted">Asia Destinations</h6>
                <h2 class="fw-bold">{{ $asiaMarkets }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 stats-card">
            <div class="card-body">
                <h6 class="text-muted">Europe Destinations</h6>
                <h2 class="fw-bold">{{ $europeMarkets }}</h2>
            </div>
        </div>
    </div>

</div>

<div class="card shadow-sm border-0 mb-4">

    <div class="card-body">

        <h5 class="fw-bold">
            Export Market Insight
        </h5>

        <p class="text-muted mb-0">
            {{ $insightText }}
        </p>

    </div>

</div>

<div class="card shadow-sm border-0 mb-4">

    <div class="card-body">

        <h5 class="fw-bold">
            Market Potential Summary
        </h5>

        <p>
            🟢 High Potential Markets :
            <strong>{{ $highMarkets }}</strong>
        </p>

        <p class="mb-0">
            🟡 Emerging Markets :
            <strong>{{ $emergingMarkets }}</strong>
        </p>

    </div>

</div>

<div class="card chart-card shadow-sm">
    <div class="card-body">

        @if(count($favorites) > 0)

      <table class="table table-hover align-middle">

    <thead>

        <tr>
           <th>Rank</th>
<th>Country</th>
<th>Region</th>
<th>Population</th>
<th>Potential</th>
<th>Action</th>
        </tr>

    </thead>

    <tbody>

       @foreach($tableData as $index => $country)

       <tr>

    <td>
        <span class="badge bg-primary">
            {{ $index + 1 }}
        </span>
    </td>

    <td>
        <i class="bi bi-globe-americas me-2"></i>
        {{ $country['name'] }}
    </td>

            <td>
                {{ $country['region'] }}
            </td>

            <td>
                {{ number_format($country['population']) }}
            </td>

            <td>

                @if($country['potential'] == 'High')

                    <span class="badge bg-success">
                        High
                    </span>

                @else

                    <span class="badge bg-warning text-dark">
                        Emerging
                    </span>

                @endif

            </td>

            <td>

                <a
                    href="/favorites/delete/{{ $country['id'] }}"
                    class="btn btn-danger btn-sm">

                    <i class="bi bi-trash"></i>
                    Delete

                </a>

            </td>

        </tr>

        @endforeach

    </tbody>

</table>

      

        @else

          <div class="text-center py-4">

    <div class="empty-icon mb-3">
        <i class="bi bi-box2-heart"></i>
    </div>

    <h5>No Export Destinations</h5>

    <p class="text-muted">
        No export destination countries have been added yet.
    </p>

</div>

        @endif

    </div>
</div>

@endsection