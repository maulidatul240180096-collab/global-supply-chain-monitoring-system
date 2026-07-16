@extends('layouts.app')

@section('content')

<h2 class="mb-4">
    Create Analysis Article
</h2>

<form method="POST" action="/analysis-articles/store">

    @csrf

    <div class="mb-3">
        <label class="form-label">Title</label>
        <input
            type="text"
            name="title"
            class="form-control"
            required>
    </div>

    <div class="mb-3">
        <label class="form-label">Country</label>
        <input
            type="text"
            name="country"
            class="form-control"
            required>
    </div>

    <div class="mb-3">
        <label class="form-label">Category</label>
        <select
            name="category"
            class="form-control">

            <option>Export Opportunity</option>
            <option>Market Analysis</option>
            <option>Supply Chain Risk</option>
            <option>Logistics Analysis</option>
            <option>Economic Outlook</option>

        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Summary</label>

        <textarea
            name="summary"
            rows="3"
            class="form-control"></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Content</label>

        <textarea
            name="content"
            rows="8"
            class="form-control"></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Risk Level</label>

        <select
            name="risk_level"
            class="form-control">

            <option>Low</option>
            <option>Medium</option>
            <option>High</option>

        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Recommendation</label>

        <select
            name="recommendation"
            class="form-control">

            <option>Recommended</option>
            <option>Consider Further</option>
            <option>Not Recommended</option>

        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Status</label>

        <select
            name="status"
            class="form-control">

            <option value="draft">
                Draft
            </option>

            <option value="published">
                Published
            </option>

        </select>
    </div>

    <button
        type="submit"
        class="btn btn-primary">

        Save Article

    </button>

</form>

@endsection