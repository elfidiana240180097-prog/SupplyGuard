@extends('layouts.master')

@section('content')

<div class="container">

    <h2 class="mb-4">
        Member Dashboard
    </h2>

    <div class="alert alert-primary">

        Welcome Member

    </div>

    <div class="card shadow-sm">

        <div class="card-header">

            Latest Published Articles

        </div>

        <div class="card-body">

            @forelse($articles as $article)

                <div class="mb-4">

                    <h4>
                        {{ $article->title }}
                    </h4>

                    <p>
                        {{ $article->summary }}
                    </p>

                    <hr>

                </div>

            @empty

                <p>
                    No articles available
                </p>

            @endforelse

        </div>

    </div>

</div>

@endsection