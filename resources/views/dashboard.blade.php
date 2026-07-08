@extends('layouts.master')

@section('content')

<div class="row">

    <div class="col-md-12 mb-4">

        <div class="card shadow border-0">

            <div class="card-body">

                <h2 class="fw-bold text-success">
                    🌍 SupplyGuard Dashboard
                </h2>

                <p class="text-muted mb-0">
                    Welcome back,
                    <strong>{{ Auth::user()->name }}</strong>
                </p>

            </div>

        </div>

    </div>

</div>

<div class="row">

    <div class="col-md-3 mb-4">

        <div class="card shadow-sm border-0">

            <div class="card-body text-center">

                <i class="bi bi-globe fs-1 text-success"></i>

                <h5 class="mt-3">
                    Countries
                </h5>

                <a href="{{ route('countries.index') }}" class="btn btn-success btn-sm mt-2">
                    Open
                </a>

            </div>

        </div>

    </div>

    <div class="col-md-3 mb-4">

        <div class="card shadow-sm border-0">

            <div class="card-body text-center">

                <i class="bi bi-cloud-sun fs-1 text-primary"></i>

                <h5 class="mt-3">
                    Weather
                </h5>

                <a href="{{ route('weather') }}" class="btn btn-primary btn-sm mt-2">
                    Open
                </a>

            </div>

        </div>

    </div>

    <div class="col-md-3 mb-4">

        <div class="card shadow-sm border-0">

            <div class="card-body text-center">

                <i class="bi bi-currency-exchange fs-1 text-warning"></i>

                <h5 class="mt-3">
                    Currency
                </h5>

                <a href="{{ route('currency') }}" class="btn btn-warning btn-sm mt-2">
                    Open
                </a>

            </div>

        </div>

    </div>

    <div class="col-md-3 mb-4">

        <div class="card shadow-sm border-0">

            <div class="card-body text-center">

                <i class="bi bi-newspaper fs-1 text-danger"></i>

                <h5 class="mt-3">
                    News
                </h5>

                <a href="{{ route('news') }}" class="btn btn-danger btn-sm mt-2">
                    Open
                </a>

            </div>

        </div>

    </div>

</div>

@endsection