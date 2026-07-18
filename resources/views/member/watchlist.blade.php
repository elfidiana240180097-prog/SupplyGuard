@extends('layouts.member')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="fw-bold mb-1">
            My Watchlist
        </h2>

        <p class="text-muted mb-0">
            Countries monitored for global supply chain risk analysis.
        </p>
    </div>

</div>

<div class="row">

    @forelse($watchlists as $watchlist)

        @php

            $riskScore =
                $watchlist->country->riskScore->overall_score ?? 0;

            $riskLevel =
                $watchlist->country->riskScore->risk_level ?? 'Low';

            $badgeClass =
                $riskLevel === 'High'
                    ? 'bg-danger'
                    : ($riskLevel === 'Medium'
                        ? 'bg-warning text-dark'
                        : 'bg-success');

        @endphp

        <div class="col-lg-4 col-md-6 mb-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body text-center">

                    <img
                        src="https://flagcdn.com/w160/{{ strtolower($watchlist->country->country_code) }}.png"
                        class="img-fluid border rounded mb-3"
                        style="height:70px;"
                        alt="{{ $watchlist->country->country_name }}">

                    <h5 class="fw-bold">
                        {{ $watchlist->country->country_name }}
                    </h5>

                    <span class="badge {{ $badgeClass }} mb-3">
                        {{ $riskLevel }} Risk
                    </span>

                    <hr>

                    <div class="row text-start">

                        <div class="col-6 mb-2">
                            <strong>Code</strong>
                        </div>

                        <div class="col-6 mb-2 text-end">
                            {{ $watchlist->country->country_code }}
                        </div>

                        <div class="col-6 mb-2">
                            <strong>Region</strong>
                        </div>

                        <div class="col-6 mb-2 text-end">
                            {{ $watchlist->country->region ?? '-' }}
                        </div>

                        <div class="col-6 mb-2">
                            <strong>Capital</strong>
                        </div>

                        <div class="col-6 mb-2 text-end">
                            {{ $watchlist->country->capital ?? '-' }}
                        </div>

                        <div class="col-6 mb-2">
                            <strong>Currency</strong>
                        </div>

                        <div class="col-6 mb-2 text-end">
                            {{ $watchlist->country->currency_name ?? '-' }}
                        </div>

                        <div class="col-6 mb-2">
                            <strong>Risk Score</strong>
                        </div>

                        <div class="col-6 mb-2 text-end">
                            {{ number_format($riskScore, 2) }}
                        </div>

                    </div>

                    <hr>

                    <form
                        action="{{ route('watchlists.destroy', $watchlist->id) }}"
                        method="POST">

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="btn btn-danger w-100">

                            Remove Watchlist

                        </button>

                    </form>

                </div>

            </div>

        </div>

    @empty

        <div class="col-12">

            <div class="alert alert-info shadow-sm">

                No countries in your watchlist yet.

            </div>

        </div>

    @endforelse

</div>

@endsection