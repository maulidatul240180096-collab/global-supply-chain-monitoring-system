@extends('layouts.app')

@section('css')

<link rel="stylesheet"
href="https://unpkg.com/leaflet/dist/leaflet.css"/>

<link rel="stylesheet"
href="{{ asset('css/ports.css') }}">

@endsection

@section('content')

<span class="badge bg-primary mb-2">
    <i class="bi bi-globe-americas me-1"></i>
    Global Export Analysis
</span>

<h2>Port Network Analysis</h2>

<p class="text-muted">
    Explore global ports and logistics networks that support international export activities.
</p>

<form method="GET">

    <div class="row">

        <div class="col-md-6">

            <label class="form-label">
                Filter Country
            </label>

            <select
                name="country"
                class="form-select">

                <option value="">
                    All Countries
                </option>

                @foreach($countries as $country)

                    <option
                        value="{{ $country }}"
                        {{ request('country') == $country ? 'selected' : '' }}>

                        {{ $country }}

                    </option>

                @endforeach

            </select>

        </div>

        <div class="col-md-4">

            <label class="form-label">
                Search Port
            </label>

            <input
                type="text"
                name="search"
                class="form-control"
                value="{{ request('search') }}"
                placeholder="Enter port name">

        </div>

        <div class="col-md-2">

            <label>&nbsp;</label>

            <button
                type="submit"
                class="btn btn-primary w-100">

                Search

            </button>

        </div>

    </div>

</form>

<div class="row mt-4">

    <div class="col-md-3 mb-3">
        <div class="card info-card shadow-sm">
            <div class="card-body">

                <div class="card-icon blue">
                    <i class="bi bi-water"></i>
                </div>

                <h6>Total Ports</h6>
                <p>{{ count($ports) }}</p>

            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card info-card shadow-sm">
            <div class="card-body">

                <div class="card-icon green">
                    <i class="bi bi-globe"></i>
                </div>

                <h6>Countries</h6>
                <p>{{ count($countries) }}</p>

            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card info-card shadow-sm">
            <div class="card-body">

                <div class="card-icon cyan">
                    <i class="bi bi-geo-alt-fill"></i>
                </div>

                <h6>Locations</h6>
                <p>{{ count($ports) }}</p>

            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card info-card shadow-sm">
            <div class="card-body">

                <div class="card-icon orange">
                    <i class="bi bi-ship"></i>
                </div>

                <h6>Network</h6>
                <p>Global</p>

            </div>
        </div>
    </div>

</div>

<div class="card chart-card shadow-sm mt-4">

    <div class="card-body">

        <h5>Global Port Map</h5>

        <div id="map"></div>

    </div>

</div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>

var map = L.map('map').setView([-2.5,118], 4);

L.tileLayer(
    'https://tile.openstreetmap.org/{z}/{x}/{y}.png'
).addTo(map);

@foreach($ports as $port)

L.marker([
    {{ $port['lat'] }},
    {{ $port['lng'] }}
])
.addTo(map)
.bindPopup(
    "<b>{{ $port['name'] }}</b><br>{{ $port['country'] }}"
);

@endforeach

</script>

@endsection