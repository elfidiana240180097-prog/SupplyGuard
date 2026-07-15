@extends('layouts.master')

@section('content')

<div class="container">

    <h2 class="mb-4">
        Create Analysis Article
    </h2>

    <form action="{{ route('articles.store') }}" method="POST">

        @csrf

        <div class="mb-3">

            <label>Title</label>

            <input
                type="text"
                name="title"
                class="form-control"
                required>

        </div>

        <div class="mb-3">

            <label>Summary</label>

            <textarea
                name="summary"
                class="form-control"
                rows="3"
                required></textarea>

        </div>

        <div class="mb-3">

            <label>Content</label>

            <textarea
                name="content"
                class="form-control"
                rows="8"
                required></textarea>

        </div>

        <div class="mb-3">

            <label>Status</label>

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
            class="btn btn-success">

            Save Article

        </button>

    </form>

</div>

@endsection