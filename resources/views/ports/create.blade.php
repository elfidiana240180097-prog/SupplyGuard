@extends('layouts.master')

@section('content')

<div class="container">

    <h2 class="mb-4 fw-bold">
        ➕ Add Port
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

            <form action="{{ route('ports.store') }}" method="POST">

                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">Country</label>

                        <select name="country_id" class="form-select" required>

                            <option value="">-- Select Country --</option>

                            @foreach($countries as $country)

                                <option value="{{ $country->id }}">

                                    {{ $country->country_name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">Port Name</label>

                        <input type="text"
                               name="port_name"
                               class="form-control"
                               required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">Port Code</label>

                        <input type="text"
                               name="port_code"
                               class="form-control">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">City</label>

                        <input type="text"
                               name="city"
                               class="form-control">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">Latitude</label>

                        <input type="text"
                               name="latitude"
                               class="form-control">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">Longitude</label>

                        <input type="text"
                               name="longitude"
                               class="form-control">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">Status</label>

                        <select name="status" class="form-select">

                            <option value="Normal">Normal</option>

                            <option value="Busy">Busy</option>

                            <option value="Delayed">Delayed</option>

                            <option value="Closed">Closed</option>

                        </select>

                    </div>

                    <div class="col-md-12 mb-3">

                        <label class="form-label">Description</label>

                        <textarea name="description"
                                  rows="3"
                                  class="form-control"></textarea>

                    </div>

                </div>

                <button type="submit" class="btn btn-success">

                    <i class="bi bi-save"></i>

                    Save

                </button>

                <a href="{{ route('ports.index') }}"
                   class="btn btn-secondary">

                    Back

                </a>

            </form>

        </div>

    </div>

</div>

@endsection