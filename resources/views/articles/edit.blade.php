@extends('layouts.master')

@section('content')

<div class="container">

    <h2 class="mb-4">
        Edit Article
    </h2>

    <form
        action="{{ route('articles.update',$article) }}"
        method="POST">

        @csrf
        @method('PUT')

        <div class="mb-3">

            <label>Title</label>

            <input
                type="text"
                name="title"
                class="form-control"
                value="{{ $article->title }}"
                required>

        </div>

        <div class="mb-3">

            <label>Summary</label>

            <textarea
                name="summary"
                class="form-control"
                rows="3"
                required>{{ $article->summary }}</textarea>

        </div>

        <div class="mb-3">

            <label>Content</label>

            <textarea
                name="content"
                class="form-control"
                rows="8"
                required>{{ $article->content }}</textarea>

        </div>

        <div class="mb-3">

            <label>Status</label>

            <select
                name="status"
                class="form-control">

                <option
                    value="draft"
                    {{ $article->status=='draft'?'selected':'' }}>
                    Draft
                </option>

                <option
                    value="published"
                    {{ $article->status=='published'?'selected':'' }}>
                    Published
                </option>

            </select>

        </div>

        <button
            type="submit"
            class="btn btn-primary">

            Update Article

        </button>

    </form>

</div>

@endsection