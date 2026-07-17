@extends('layouts.member')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold">
            My Watchlist
        </h2>

        <p class="text-muted">
            Countries you are monitoring for supply chain risks.
        </p>

    </div>

</div>

<div class="row">

    @forelse($watchlists as $watchlist)

        <div class="col-md-4 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-body text-center">

                    <img
                        src="https://flagcdn.com/w160/{{ strtolower($watchlist->country->country_code) }}.png"
                        class="img-fluid mb-3 border rounded"
                        style="height:70px;"
                        alt="{{ $watchlist->country->country_name }}">

                    <h5 class="fw-bold">

                        {{ $watchlist->country->country_name }}

                    </h5>

                    <hr>

                    <p>

                        <strong>Code:</strong>

                        {{ $watchlist->country->country_code }}

                    </p>

                    <p>

                        <strong>Region:</strong>

                        {{ $watchlist->country->region ?? '-' }}

                    </p>

                    <p>

                        <strong>Currency:</strong>

                        {{ $watchlist->country->currency ?? '-' }}

                    </p>

                    <p>

                        <strong>Capital:</strong>

                        {{ $watchlist->country->capital ?? '-' }}

                    </p>

                    <form
                        action="{{ route('watchlists.destroy', $watchlist->id) }}"
                        method="POST">

                        @csrf
                        @method('DELETE')

                        <button
                            class="btn btn-danger w-100">

                            <i class="bi bi-trash"></i>

                            Remove Watchlist

                        </button>

                    </form>

                </div>

            </div>

        </div>

    @empty

        <div class="col-12">

            <div class="alert alert-info">

                No countries in your watchlist yet.

            </div>

        </div>

    @endforelse

</div>

@endsection