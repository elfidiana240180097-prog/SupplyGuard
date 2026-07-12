@extends('layouts.master')

@section('content')

<h2 class="fw-bold mb-3">
    Global Port Location Dashboard
</h2>

<p class="text-muted">
    Interactive global port monitoring using OpenStreetMap & Leaflet.
</p>

<form method="GET" class="mb-4">

    <div class="row">

        <div class="col-md-4">

            <select
                name="country"
                class="form-select"
                onchange="this.form.submit()">

                <option value="">
                    All Countries
                </option>

                @foreach($countries as $country)

                    <option
                        value="{{ $country->country_code }}"
                        {{ $selectedCountry == $country->country_code ? 'selected' : '' }}>

                        {{ $country->country_name }}

                    </option>

                @endforeach

            </select>

        </div>

    </div>

</form>

<div class="row mb-4">

    <div class="col-md-3">

        <div class="card shadow-sm">

            <div class="card-body text-center">

                <h6>Total Ports</h6>

                <h3>{{ $ports->count() }}</h3>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card shadow-sm">

            <div class="card-body text-center">

                <h6>Normal</h6>

                <h3 class="text-success">

                    {{ $ports->where('status','Normal')->count() }}

                </h3>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card shadow-sm">

            <div class="card-body text-center">

                <h6>Busy</h6>

                <h3 class="text-warning">

                    {{ $ports->where('status','Busy')->count() }}

                </h3>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card shadow-sm">

            <div class="card-body text-center">

                <h6>Delayed</h6>

                <h3 class="text-danger">

                    {{ $ports->where('status','Delayed')->count() }}

                </h3>

            </div>

        </div>

    </div>

</div>

<div
    id="map"
    class="shadow rounded"
    style="height:650px;">
</div>

@endsection

@push('scripts')

<script>

const map = L.map('map').setView([20, 0], 2);

L.tileLayer(
    'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
    {
        maxZoom: 18
    }
).addTo(map);

let bounds = [];

@foreach($ports as $port)

@if($port->latitude && $port->longitude)

L.marker([
    {{ $port->latitude }},
    {{ $port->longitude }}
])
.addTo(map)
.bindPopup(`
    <b>{{ $port->port_name }}</b><br>
    Country: {{ $port->country->country_name }}<br>
    City: {{ $port->city }}<br>
    Status: {{ $port->status }}
`);

bounds.push([
    {{ $port->latitude }},
    {{ $port->longitude }}
]);

@endif

@endforeach

if(bounds.length > 0){

    map.fitBounds(bounds);

}

</script>

@endpush