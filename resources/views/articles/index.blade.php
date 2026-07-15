@extends('layouts.master')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2 class="fw-bold">
        Articles Management
    </h2>

    <a href="{{ route('articles.create') }}"
       class="btn btn-success">

        <i class="bi bi-plus-circle"></i>
        Create Article

    </a>

</div>

@if(session('success'))

<div class="alert alert-success">

    {{ session('success') }}

</div>

@endif

<div class="card shadow-sm">

    <div class="card-body">

        <table class="table table-bordered">

            <thead>

                <tr>

                    <th>ID</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Action</th>

                </tr>

            </thead>

            <tbody>

                @forelse($articles as $article)

                <tr>

                    <td>{{ $article->id }}</td>

                    <td>{{ $article->title }}</td>

                    <td>

                        @if($article->status == 'published')

                            <span class="badge bg-success">
                                Published
                            </span>

                        @else

                            <span class="badge bg-secondary">
                                Draft
                            </span>

                        @endif

                    </td>

                    <td>

                        <a href="{{ route('articles.edit',$article) }}"
                           class="btn btn-warning btn-sm">

                            Edit

                        </a>

                        <form
                            action="{{ route('articles.destroy',$article) }}"
                            method="POST"
                            class="d-inline">

                            @csrf
                            @method('DELETE')

                            <button
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete article?')">

                                Delete

                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="4" class="text-center">

                        No Articles Found

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection