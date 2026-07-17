@extends('layouts.app')

@section('content')

<h2 class="mb-4">
    Edit Analysis Article
</h2>


<form method="POST" action="/analysis-articles/{{ $article->id }}">

    @csrf
    @method('PUT')


    <div class="mb-3">

        <label class="form-label">
            Title
        </label>

        <input 
            type="text"
            name="title"
            class="form-control"
            value="{{ $article->title }}"
            required>

    </div>


    <div class="mb-3">

        <label class="form-label">
            Country
        </label>

        <input
            type="text"
            name="country"
            class="form-control"
            value="{{ $article->country }}"
            required>

    </div>


    <div class="mb-3">

        <label class="form-label">
            Category
        </label>

        <select name="category" class="form-control">

            <option 
            {{ $article->category == 'Export Opportunity' ? 'selected' : '' }}>
                Export Opportunity
            </option>

            <option
            {{ $article->category == 'Market Analysis' ? 'selected' : '' }}>
                Market Analysis
            </option>

            <option
            {{ $article->category == 'Supply Chain Risk' ? 'selected' : '' }}>
                Supply Chain Risk
            </option>

            <option
            {{ $article->category == 'Logistics Analysis' ? 'selected' : '' }}>
                Logistics Analysis
            </option>

        </select>

    </div>


    <div class="mb-3">

        <label class="form-label">
            Summary
        </label>

        <textarea
            name="summary"
            class="form-control"
            rows="3">{{ $article->summary }}</textarea>

    </div>


    <div class="mb-3">

        <label class="form-label">
            Content
        </label>

        <textarea
            name="content"
            class="form-control"
            rows="8">{{ $article->content }}</textarea>

    </div>


    <div class="mb-3">

        <label class="form-label">
            Risk Level
        </label>

        <select name="risk_level" class="form-control">

            <option 
            {{ $article->risk_level == 'Low' ? 'selected' : '' }}>
                Low
            </option>

            <option 
            {{ $article->risk_level == 'Medium' ? 'selected' : '' }}>
                Medium
            </option>

            <option 
            {{ $article->risk_level == 'High' ? 'selected' : '' }}>
                High
            </option>

        </select>

    </div>


    <div class="mb-3">

        <label class="form-label">
            Recommendation
        </label>

        <select name="recommendation" class="form-control">

            <option
            {{ $article->recommendation == 'Recommended' ? 'selected' : '' }}>
                Recommended
            </option>

            <option
            {{ $article->recommendation == 'Consider Further' ? 'selected' : '' }}>
                Consider Further
            </option>

            <option
            {{ $article->recommendation == 'Not Recommended' ? 'selected' : '' }}>
                Not Recommended
            </option>

        </select>

    </div>

<div class="mb-3">

    <label class="form-label">
        Status
    </label>

    <select name="status" class="form-control" required>

    <option value="published"
{{ $article->status == 'published' ? 'selected' : '' }}>
    Published
</option>

<option value="draft"
{{ $article->status == 'draft' ? 'selected' : '' }}>
    Draft
</option>

    </select>

</div>

    <button class="btn btn-primary">

        Update Article

    </button>


    <a href="/analysis-articles" 
       class="btn btn-secondary">

        Cancel

    </a>


</form>

@endsection