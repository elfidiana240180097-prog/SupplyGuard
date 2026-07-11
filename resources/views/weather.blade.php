@extends('layouts.master')

@section('content')

<h2 class="fw-bold mb-4">
    Weather Monitoring
</h2>

<form method="GET">

    <div class="row mb-4">

        <div class="col-md-4">

            <select name="country"
                    class="form-select"
                    onchange="this.form.submit()">

                <option value="">
                    Select Country
                </option>

                @foreach($countries as $country)

                    <option
                        value="{{ $country->id }}"
                        {{ request('country') == $country->id ? 'selected' : '' }}>

                        {{ $country->country_name }}

                    </option>

                @endforeach

            </select>

        </div>

    </div>

</form>

@if($weather)

<div class="row">

    <div class="col-md-6">

        <div class="card shadow">

            <div class="card-body text-center">

                <h5>Temperature</h5>

                <h2 class="text-danger">

                    {{ $weather['current']['temperature_2m'] }} °C

                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-6">

        <div class="card shadow">

            <div class="card-body text-center">

                <h5>Wind Speed</h5>

                <h2 class="text-primary">

                    {{ $weather['current']['wind_speed_10m'] }} km/h

                </h2>

            </div>

        </div>

    </div>

</div>

@endif

@endsection