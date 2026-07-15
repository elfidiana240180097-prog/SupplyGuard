@extends('layouts.master')

@section('content')

<h2 class="fw-bold mb-4">
    Admin Dashboard
</h2>

<div class="row">

    <div class="col-md-4 mb-3">

        <div class="card shadow-sm">

            <div class="card-body text-center">

                <h5>Total Users</h5>

                <h2>{{ $users }}</h2>

            </div>

        </div>

    </div>

    <div class="col-md-4 mb-3">

        <div class="card shadow-sm">

            <div class="card-body text-center">

                <h5>Total Ports</h5>

                <h2>{{ $ports }}</h2>

            </div>

        </div>

    </div>

    <div class="col-md-4 mb-3">

        <div class="card shadow-sm">

            <div class="card-body text-center">

                <h5>Total Articles</h5>

                <h2>{{ $articles }}</h2>

            </div>

        </div>

    </div>

</div>

@endsection