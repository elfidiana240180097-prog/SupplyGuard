@extends('layouts.member')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold">
            Latest Supply Chain News
        </h2>

        <p class="text-muted">
            Stay updated with the latest global supply chain intelligence.
        </p>

    </div>

</div>

<div class="row">

    @forelse($articles as $article)

    <div class="col-md-6 col-lg-4 mb-4">

        <div class="card h-100 shadow-sm">

            @if($article->image)

                <img
                    src="{{ $article->image }}"
                    class="card-img-top"
                    style="height:220px; object-fit:cover;"
                    alt="{{ $article->title }}"
                    onerror="this.style.display='none'">

            @endif

            <div class="card-body d-flex flex-column">

                <small class="text-muted mb-2">

                    <i class="bi bi-calendar-event"></i>

                    {{ $article->created_at->format('d M Y') }}

                </small>

                <h5 class="fw-bold">

                    {{ $article->title }}

                </h5>

                <p class="text-muted">

                    {{ Str::limit($article->summary, 120) }}

                </p>

                <div class="mt-auto">

                    <button
                        class="btn btn-outline-primary btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#article{{ $article->id }}">

                        Read More

                    </button>

                </div>

            </div>

        </div>

    </div>

    <div
        class="modal fade"
        id="article{{ $article->id }}"
        tabindex="-1">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">

                        {{ $article->title }}

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    @if($article->image)

                        <img
                            src="{{ $article->image }}"
                            class="img-fluid mb-3 rounded"
                            alt="{{ $article->title }}"
                            onerror="this.style.display='none'">

                    @endif

                    <p class="text-muted">

                        {{ $article->created_at->format('d F Y') }}

                    </p>

                    <hr>

                    <p>

                        {!! nl2br(e($article->content)) !!}

                    </p>

                </div>

            </div>

        </div>

    </div>

    @empty

    <div class="col-12">

        <div class="alert alert-info">

            No articles available.

        </div>

    </div>

    @endforelse

</div>

@endsection