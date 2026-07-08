@extends('layouts.master')

@section('content')

<h2 class="fw-bold mb-4">
    🌦 Weather
</h2>

<p class="text-muted">
    Monitor weather conditions from selected countries.
</p>

<div class="row">

    <div class="col-md-4">

        <div class="card shadow-sm">

            <div class="card-body text-center">

                <h5>Temperature</h5>

                <h2 class="text-danger">-- °C</h2>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card shadow-sm">

            <div class="card-body text-center">

                <h5>Humidity</h5>

                <h2 class="text-primary">-- %</h2>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card shadow-sm">

            <div class="card-body text-center">

                <h5>Wind Speed</h5>

                <h2 class="text-success">-- km/h</h2>

            </div>

        </div>

    </div>

</div>

@endsection