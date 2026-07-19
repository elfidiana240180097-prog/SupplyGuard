@extends('layouts.master')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                Admin Dashboard
            </h2>
            <p class="text-muted mb-0">
                Global Supply Chain Risk Intelligence Platform
            </p>
        </div>
    </div>

    <div class="row">

        <div class="col-md-4 col-lg-2 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted">Users</h6>
                    <h2>{{ $users }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-lg-2 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted">Countries</h6>
                    <h2>{{ $countries }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-lg-2 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted">Ports</h6>
                    <h2>{{ $ports }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-lg-2 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted">Articles</h6>
                    <h2>{{ $articles }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-lg-2 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted">Watchlists</h6>
                    <h2>{{ $watchlists }}</h2>
                </div>
            </div>
        </div>

    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">
                System Overview
            </h5>

            <ul class="list-group">

                <li class="list-group-item d-flex justify-content-between">
                    <span>Total Registered Users</span>
                    <strong>{{ $users }}</strong>
                </li>

                <li class="list-group-item d-flex justify-content-between">
                    <span>Total Countries Monitored</span>
                    <strong>{{ $countries }}</strong>
                </li>

                <li class="list-group-item d-flex justify-content-between">
                    <span>Total Ports Available</span>
                    <strong>{{ $ports }}</strong>
                </li>

                <li class="list-group-item d-flex justify-content-between">
                    <span>Total Analysis Articles</span>
                    <strong>{{ $articles }}</strong>
                </li>

                <li class="list-group-item d-flex justify-content-between">
                    <span>Total User Watchlists</span>
                    <strong>{{ $watchlists }}</strong>
                </li>

            </ul>
        </div>
    </div>

</div>

@endsection