@extends('layouts.member')

@section('content')

<h2 class="fw-bold mb-4">
    Global Ports Information
</h2>

<form method="GET" class="mb-4">

    <div class="row">

        <div class="col-md-4">

            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Search Port..."
                value="{{ request('search') }}">

        </div>

        <div class="col-md-4">

            <select
                name="country"
                class="form-select">

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

        <div class="col-md-2">

            <button
                type="submit"
                class="btn btn-primary">

                Search

            </button>

        </div>

    </div>

</form>

<div class="card mb-4">

    <div class="card-body">

        <p class="mb-0">
            View port information around the world.
        </p>

    </div>

</div>

<div class="row mb-4">

    <div class="col-md-3">

        <div class="card text-center">

            <div class="card-body">

                <h6>Total Ports</h6>

                <h3>{{ $totalPorts }}</h3>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card text-center">

            <div class="card-body">

                <h6>Normal</h6>

                <h3>{{ $normalPorts }}</h3>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card text-center">

            <div class="card-body">

                <h6>Busy</h6>

                <h3>{{ $busyPorts }}</h3>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card text-center">

            <div class="card-body">

                <h6>Delayed</h6>

                <h3>{{ $delayedPorts }}</h3>

            </div>

        </div>

    </div>

</div>

<div class="card mb-4">

    <div class="card-header">
        Global Port Map
    </div>

    <div class="card-body">

        <div id="portMap" style="height:500px;"></div>

    </div>

</div>

<div class="table-responsive">

<table class="table table-bordered">

    <thead class="table-dark">

        <tr>

            <th>No</th>
            <th>Port</th>
            <th>Country</th>
            <th>City</th>
            <th>Status</th>

        </tr>

    </thead>

    <tbody>

    @forelse($ports as $port)

        <tr>

            <td>
            {{ ($ports->currentPage() - 1) * $ports->perPage() + $loop->iteration }}
            </td>

            <td>{{ $port->port_name }}</td>

            <td>{{ $port->country->country_name }}</td>

            <td>{{ $port->city }}</td>

            <td>{{ $port->status }}</td>

        </tr>

    @empty

        <tr>

            <td colspan="5" class="text-center">

                No port data available

            </td>

        </tr>

    @endforelse

    </tbody>

</table>

<div class="mt-3 d-flex justify-content-center">

    {{ $ports->withQueryString()->links() }}

</div>

</div>

@push('scripts')

<script>

const map = L.map('portMap').setView([20, 0], 2);

L.tileLayer(
    'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
    {
        attribution: '&copy; OpenStreetMap'
    }
).addTo(map);

const ports = @json($mapPorts);

ports.forEach(function(port){

    L.marker([
        port.latitude,
        port.longitude
    ])
    .addTo(map)
    .bindPopup(
        `
        <strong>${port.port_name}</strong><br>
        Country: ${port.country.country_name}<br>
        City: ${port.city}<br>
        Status: ${port.status}
        `
    );

});

</script>

@endpush

@endsection