<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TradeIntel | Global Export Insights</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">

    @yield('css')
</head>
<body>

<nav class="top-navbar">

    <div class="navbar-title">
        <i class="bi bi-globe2 me-2"></i>
        TradeIntel | Global Export Insights
    </div>

</nav>

<div class="container-fluid">
    <div class="row">

        <div class="col-md-2 sidebar p-4">

            <div class="sidebar-brand mb-4">

               <div class="d-flex align-items-center mb-2">

    <i class="bi bi-globe-americas fs-2 me-2"></i>

    <h4 class="mb-0">
        TradeIntel
    </h4>

</div>

<small>
    Export Decision Support
</small>

<hr>

<div class="text-white">
    Welcome,
    <strong>{{ Auth::user()->name }}</strong>
</div>
            </div>

            <ul class="nav flex-column">

                <li class="nav-item mb-2">
                    <a href="/dashboard" class="nav-link menu-item">
                        <i class="bi bi-speedometer2 me-2"></i>
                        Dashboard
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="/countries" class="nav-link menu-item">
                        <i class="bi bi-globe2 me-2"></i>
                        Country Insights
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="/weather" class="nav-link menu-item">
                        <i class="bi bi-cloud-sun me-2"></i>
                        Weather Conditions
                    </a>
                </li>

               @auth
@if(Auth::user()->role == 'admin')
<li class="nav-item mb-2">
    <a href="/comparison" class="nav-link menu-item">
        <i class="bi bi-bar-chart-line me-2"></i>
        Country Comparison
    </a>
</li>
@endif
@endauth

                <li class="nav-item mb-2">
                    <a href="/ports" class="nav-link menu-item">
                        <i class="bi bi-geo-alt-fill me-2"></i>
                        Port Network
                    </a>
                </li>

               @auth
@if(Auth::user()->role == 'admin')
<li class="nav-item mb-2">
    <a href="/favorites" class="nav-link menu-item">
        <i class="bi bi-box-seam me-2"></i>
        Export Destinations
    </a>
</li>
@endif
@endauth

                <li class="nav-item mb-2">
                    <a href="/dashboard#news-section" class="nav-link menu-item">
                        <i class="bi bi-newspaper me-2"></i>
                        News Intelligence
                    </a>
                </li>

                <li class="nav-item mb-2">
    <a href="/analysis-articles" class="nav-link menu-item">
        <i class="bi bi-journal-text me-2"></i>
        Artikel Analisis
    </a>
</li>

                <li class="nav-item mt-3">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button
                            type="submit"
                            class="btn btn-danger w-100">

                            <i class="bi bi-box-arrow-right me-2"></i>
                            Logout

                        </button>
                    </form>
                </li>

            </ul>

        </div>

        <div class="col-md-10 p-4 main-content">
            @yield('content')
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>
</html>