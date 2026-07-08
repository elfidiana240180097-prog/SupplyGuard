@extends('layouts.master')

@section('content')

<div class="container">

    <h2 class="mb-4 fw-bold">
        ➕ Add Country
    </h2>

    <div class="card shadow">

        <div class="card-body">

            @if ($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <form action="{{ route('countries.store') }}" method="POST">

                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Country Code</label>
                        <input type="text" name="country_code" class="form-control" value="{{ old('country_code') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Country Name</label>
                        <input type="text" name="country_name" class="form-control" value="{{ old('country_name') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Capital</label>
                        <input type="text" name="capital" class="form-control" value="{{ old('capital') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Region</label>
                        <input type="text" name="region" class="form-control" value="{{ old('region') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sub Region</label>
                        <input type="text" name="subregion" class="form-control" value="{{ old('subregion') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Currency Code</label>
                        <input type="text" name="currency_code" class="form-control" value="{{ old('currency_code') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Currency Name</label>
                        <input type="text" name="currency_name" class="form-control" value="{{ old('currency_name') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Population</label>
                        <input type="number" name="population" class="form-control" value="{{ old('population') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Latitude</label>
                        <input type="text" name="latitude" class="form-control" value="{{ old('latitude') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Longitude</label>
                        <input type="text" name="longitude" class="form-control" value="{{ old('longitude') }}">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Flag URL</label>
                        <input type="text" name="flag" class="form-control" value="{{ old('flag') }}">
                    </div>

                </div>

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Save
                </button>

                <a href="{{ route('countries.index') }}" class="btn btn-secondary">
                    Back
                </a>

            </form>

        </div>

    </div>

</div>

@endsection