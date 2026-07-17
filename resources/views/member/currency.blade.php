@extends('layouts.member')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold">
            Currency Information
        </h2>

        <p class="text-muted">
            Monitor global currencies affecting supply chain activities.
        </p>

    </div>

</div>

<div class="card mb-4 shadow-sm">

    <div class="card-body">

        <form method="GET">

            <div class="input-group">

                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Search Country or Currency..."
                    value="{{ request('search') }}">

                <button class="btn btn-primary">

                    <i class="bi bi-search"></i>

                    Search

                </button>

            </div>

        </form>

    </div>

</div>

<div class="row">

    @forelse($countries as $country)

    <div class="col-md-4 mb-4">

        <div class="card h-100 shadow-sm">

            <div class="card-body text-center">

                <img
                    src="https://flagcdn.com/w160/{{ strtolower($country->country_code) }}.png"
                    alt="{{ $country->country_name }}"
                    class="img-fluid border rounded mb-3"
                    style="height:70px;">

                <h5 class="fw-bold">
                    {{ $country->country_name }}
                </h5>

                <hr>

                <p class="mb-2">

                    <strong>Currency</strong><br>

                    {{ $country->currency_name ?? '-' }}

                </p>

                <p class="mb-2">

                    <strong>Currency Code</strong><br>

                    {{ $country->currency_code ?? '-' }}

                </p>

                <p class="mb-3">

                    <strong>Exchange Rate (USD)</strong><br>

                    {{ number_format($rates[$country->currency_code] ?? 0, 2) }}

                </p>

                <button
                    class="btn btn-outline-primary btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#currency{{ $country->id }}">

                    View Details

                </button>

            </div>

        </div>

    </div>

    <div
        class="modal fade"
        id="currency{{ $country->id }}"
        tabindex="-1">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">

                        {{ $country->country_name }}

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="text-center mb-3">

                        <img
                            src="https://flagcdn.com/w160/{{ strtolower($country->country_code) }}.png"
                            class="img-fluid border rounded"
                            style="height:80px;">

                    </div>

                    <p>

                        <strong>Country:</strong>

                        {{ $country->country_name }}

                    </p>

                    <p>

                        <strong>Currency:</strong>

                        {{ $country->currency_name ?? '-' }}

                    </p>

                    <p>

                        <strong>Currency Code:</strong>

                        {{ $country->currency_code ?? '-' }}

                    </p>

                    <p>

                        <strong>Exchange Rate (USD):</strong>

                        {{ number_format($rates[$country->currency_code] ?? 0, 2) }}

                    </p>

                    <p>

                        <strong>Region:</strong>

                        {{ $country->region ?? '-' }}

                    </p>

                    <p>

                        <strong>Capital:</strong>

                        {{ $country->capital ?? '-' }}

                    </p>

                </div>

            </div>

        </div>

    </div>

    @empty

    <div class="col-12">

        <div class="alert alert-warning">

            No currency data available.

        </div>

    </div>

    @endforelse

</div>

<div class="d-flex justify-content-center mt-4">

    {{ $countries->withQueryString()->links() }}

</div>

@endsection