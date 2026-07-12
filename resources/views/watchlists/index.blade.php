@extends('layouts.master')

@section('content')

<h2 class="fw-bold mb-4">
    My Watchlist
</h2>

@if(session('success'))

<div class="alert alert-success">

    {{ session('success') }}

</div>

@endif

<div class="row">

@forelse($watchlists as $watchlist)

<div class="col-md-4 mb-4">

    <div class="card shadow-sm h-100">

        <div class="card-body">

            <h5 class="fw-bold">

                {{ $watchlist->country->country_name }}

            </h5>

            <p>

                <strong>Capital:</strong>
                {{ $watchlist->country->capital }}

            </p>

            <p>

                <strong>Region:</strong>
                {{ $watchlist->country->region }}

            </p>

            <form
                action="{{ route('watchlists.destroy', $watchlist->id) }}"
                method="POST">

                @csrf
                @method('DELETE')

                <button
                    class="btn btn-danger btn-sm">

                    Remove

                </button>

            </form>

        </div>

    </div>

</div>

@empty

<div class="col-12">

    <div class="alert alert-warning">

        No countries in watchlist.

    </div>

</div>

@endforelse

</div>

@endsection