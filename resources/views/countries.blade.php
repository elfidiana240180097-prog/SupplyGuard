@extends('layouts.master')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="fw-bold">Countries</h2>
        <p class="text-muted">
            List of countries stored in the SupplyGuard database.
        </p>
    </div>

    <a href="{{ route('countries.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i>
        Add Country
    </a>

</div>

@if(session('success'))

<div class="alert alert-success">

    {{ session('success') }}

</div>

@endif

<div class="row">

@forelse($countries as $country)

<div class="col-lg-4 col-md-6 mb-4">

    <div class="card shadow-sm border-0 h-100">

        <img
            src="{{ $country->flag }}"
            class="card-img-top"
            style="height:180px; object-fit:cover;">

        <div class="card-body">

            <h5 class="fw-bold">
                {{ $country->country_name }}
            </h5>

            <hr>

            <p><strong>Country Code :</strong> {{ $country->country_code }}</p>

            <p><strong>Capital :</strong> {{ $country->capital }}</p>

            <p><strong>Region :</strong> {{ $country->region }}</p>

            <p><strong>Currency :</strong> {{ $country->currency_name }} ({{ $country->currency_code }})</p>

            <p><strong>Population :</strong> {{ number_format($country->population) }}</p>

        </div>

        <form
    action="{{ route('watchlists.store', $country->id) }}"
    method="POST"
    class="d-inline">

    @csrf

    <button
        type="submit"
        class="btn btn-primary btn-sm">

        <i class="bi bi-star-fill"></i>

        Watchlist

    </button>

</form>

        <div class="card-footer bg-white">

            <a href="{{ route('countries.edit',$country->id) }}"
               class="btn btn-warning btn-sm">

                <i class="bi bi-pencil-square"></i>

                Edit

            </a>

            <form action="{{ route('countries.destroy',$country->id) }}"
                  method="POST"
                  class="d-inline">

                @csrf

                @method('DELETE')

                <button
                    class="btn btn-danger btn-sm"
                    onclick="return confirm('Delete this country?')">

                    <i class="bi bi-trash"></i>

                    Delete

                </button>

            </form>

        </div>

    </div>

</div>

@empty

<div class="col-12">

<div class="alert alert-warning">

No country data available.

</div>

</div>

@endforelse

</div>

@endsection