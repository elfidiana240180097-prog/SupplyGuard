@extends('layouts.member')

@section('content')

@if(session('success'))

<div class="alert alert-success">

    {{ session('success') }}

</div>

@endif

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold">
            Countries Information
        </h2>

        <p class="text-muted">
            Global country database for supply chain monitoring.
        </p>

    </div>

</div>

<div class="card mb-4">

    <div class="card-body">

        <form method="GET">

            <div class="input-group">

                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Search Country..."
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
                        class="img-fluid mb-3 border rounded"
                        style="height:70px;">

                    <h5 class="fw-bold">

                        {{ $country->country_name }}

                    </h5>

                    <hr>

                    <p class="mb-2">

                        <strong>Code:</strong>

                        {{ $country->country_code }}

                    </p>

                    <p class="mb-2">

                        <strong>Region:</strong>

                        {{ $country->region ?? '-' }}

                    </p>

                    <p class="mb-2">

                        <strong>Currency:</strong>

                        {{ $country->currency ?? '-' }}

                    </p>

                    <p class="mb-3">

                        <strong>Capital:</strong>

                        {{ $country->capital ?? '-' }}

                    </p>

                    @if(isset($watchlists) && in_array($country->id, $watchlists))

                        <button
                            class="btn btn-secondary w-100"
                            disabled>

                            <i class="bi bi-check-circle-fill"></i>

                            Already in Watchlist

                        </button>

                    @else

                        <form
                            action="{{ route('watchlists.store', $country->id) }}"
                            method="POST">

                            @csrf

                            <button
                                type="submit"
                                class="btn btn-success w-100">

                                <i class="bi bi-star-fill"></i>

                                Add to Watchlist

                            </button>

                        </form>

                    @endif

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

<div class="d-flex justify-content-center mt-4">

    {{ $countries->links() }}

</div>

@endsection