@extends('layouts.master')

@section('content')

<div class="container">

    <h2 class="mb-4 fw-bold">
        ✏ Edit Port
    </h2>

    <div class="card shadow">

        <div class="card-body">

            <form action="{{ route('ports.update',$port->id) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">Country</label>

                        <select name="country_id" class="form-select">

                            @foreach($countries as $country)

                                <option value="{{ $country->id }}"
                                    {{ $country->id == $port->country_id ? 'selected' : '' }}>

                                    {{ $country->country_name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">Port Name</label>

                        <input
                            type="text"
                            name="port_name"
                            class="form-control"
                            value="{{ $port->port_name }}">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">Port Code</label>

                        <input
                            type="text"
                            name="port_code"
                            class="form-control"
                            value="{{ $port->port_code }}">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">City</label>

                        <input
                            type="text"
                            name="city"
                            class="form-control"
                            value="{{ $port->city }}">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">Latitude</label>

                        <input
                            type="text"
                            name="latitude"
                            class="form-control"
                            value="{{ $port->latitude }}">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">Longitude</label>

                        <input
                            type="text"
                            name="longitude"
                            class="form-control"
                            value="{{ $port->longitude }}">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">Status</label>

                        <select name="status" class="form-select">

                            <option value="Normal" {{ $port->status=='Normal'?'selected':'' }}>Normal</option>

                            <option value="Busy" {{ $port->status=='Busy'?'selected':'' }}>Busy</option>

                            <option value="Delayed" {{ $port->status=='Delayed'?'selected':'' }}>Delayed</option>

                            <option value="Closed" {{ $port->status=='Closed'?'selected':'' }}>Closed</option>

                        </select>

                    </div>

                    <div class="col-md-12 mb-3">

                        <label class="form-label">Description</label>

                        <textarea
                            name="description"
                            class="form-control"
                            rows="3">{{ $port->description }}</textarea>

                    </div>

                </div>

                <button class="btn btn-primary">

                    Update

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