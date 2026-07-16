@extends('layouts.app')

@section('content')

<div class="card shadow-sm">

    <div class="card-body">

        <span class="badge bg-primary mb-3">
            {{ $article->category }}
        </span>

        <h2 class="mb-3">
            {{ $article->title }}
        </h2>

        <div class="row mb-4">

            <div class="col-md-3">
                <strong>Country</strong>
                <p>{{ $article->country }}</p>
            </div>

            <div class="col-md-3">
                <strong>Risk Level</strong>
                <p>{{ $article->risk_level }}</p>
            </div>

            <div class="col-md-3">
                <strong>Recommendation</strong>
                <p>{{ $article->recommendation }}</p>
            </div>

            <div class="col-md-3">
                <strong>Published</strong>
                <p>{{ $article->created_at->format('d M Y') }}</p>
            </div>

        </div>

        <hr>

        <h5>Executive Summary</h5>

        <p class="text-muted">
            {{ $article->summary }}
        </p>

        <hr>

        <h5>Analysis Report</h5>

        <div class="mt-3">

            {!! nl2br(e($article->content)) !!}

        </div>

    </div>

</div>

<div class="mt-3">

    <a href="/analysis-articles" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i>
        Back to Articles
    </a>

</div>

@endsection