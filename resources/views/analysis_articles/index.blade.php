@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2>Artikel Analisis</h2>

        <p class="text-muted mb-0">
            Analysis reports and strategic recommendations for global trade and supply chain activities.
        </p>
    </div>

    @if(Auth::user()->role == 'admin')
    <a href="/analysis-articles/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>
        Add Artikel
    </a>
    @endif

</div>

@if($articles->count() > 0)

<div class="row">

    @foreach($articles as $article)

    <div class="col-md-6 mb-4">

        <div class="card shadow-sm h-100">

            <div class="card-body">

                <span class="badge bg-primary mb-2">
                    {{ $article->category }}
                </span>

                <h4>
                    {{ $article->title }}
                </h4>

               <p class="text-muted mb-2 d-flex align-items-center">

               @php

$countryInfo = collect($countries)->first(
    fn($item) =>
    strtolower($item['name']['common']) ==
    strtolower($article->country)
);

$flagCode = strtolower(
    $countryInfo['cca2'] ?? 'un'
);

@endphp

    <img
src="https://flagcdn.com/24x18/{{ $flagCode }}.png"
width="24"
class="me-2">

    {{ $article->country }}

</p>

                <p>
                    {{ $article->summary }}
                </p>

                <div class="mb-3">

                    <span class="badge bg-warning text-dark">
                        Risk: {{ $article->risk_level }}
                    </span>

                    <span class="badge bg-success">
                        {{ $article->recommendation }}
                    </span>

                </div>

               <small class="text-secondary">

    {{ $article->status }}:
    {{ $article->created_at->format('d M Y') }}

</small>

            </div>

            <div class="card-footer bg-white border-0">

              <a href="/analysis-articles/{{ $article->id }}"
   class="btn btn-outline-primary btn-sm">
    Read More
</a>

                @if(Auth::user()->role == 'admin')

               <a href="/analysis-articles/{{ $article->id }}/edit"
class="btn btn-warning">

    <i class="bi bi-pencil"></i>
    Edit

</a>

               <form action="/analysis-articles/{{ $article->id }}"
method="POST"
style="display:inline">

@csrf
@method('DELETE')

<button 
class="btn btn-danger"
onclick="return confirm('Hapus artikel ini?')">

<i class="bi bi-trash"></i>
Delete

</button>

</form>

                @endif

            </div>

        </div>

    </div>

    @endforeach

</div>

@else

<div class="alert alert-info">

    <h5>No Analysis Articles Available</h5>

    <p class="mb-0">
        No analysis articles have been published yet.
    </p>

</div>

@endif

@endsection