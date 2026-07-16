@extends('layouts.member')

@section('content')

<div class="container">

    <h2 class="mb-4">
        Latest Supply Chain News
    </h2>

    <div class="row">

        @forelse($articles as $article)

        <div class="col-md-6 mb-4">

            <div class="card h-100 shadow-sm">

                <div class="card-body">

                    <h5>
                        {{ $article->title }}
                    </h5>

                    <p class="text-muted">
                        {{ $article->summary }}
                    </p>

                </div>

            </div>

        </div>

        @empty

        <div class="col-12">

            <div class="alert alert-info">

                No articles available

            </div>

        </div>

        @endforelse

    </div>

</div>

@endsection