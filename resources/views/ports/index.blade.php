@extends('layouts.master')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="fw-bold">Ports</h2>
        <p class="text-muted">
            List of ports in the SupplyGuard database.
        </p>
    </div>

    <a href="{{ route('ports.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i>
        Add Port
    </a>

</div>

@if(session('success'))

<div class="alert alert-success">

    {{ session('success') }}

</div>

@endif

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

        <div class="card text-center">

            <div class="card-body">

                <h5>Total Ports</h5>

                <h2>{{ $totalPorts }}</h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card text-center">

            <div class="card-body">

                <h5>Normal</h5>

                <h2>{{ $normalPorts }}</h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card text-center">

            <div class="card-body">

                <h5>Busy</h5>

                <h2>{{ $busyPorts }}</h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card text-center">

            <div class="card-body">

                <h5>Delayed</h5>

                <h2>{{ $delayedPorts }}</h2>

            </div>

        </div>

    </div>

</div>

<div class="card mb-4">

    <div class="card-header">

        🌍 Global Port Location Map

    </div>

    <div class="card-body">

        <div id="portMap" style="height:500px;"></div>

    </div>

</div>

<div class="table-responsive">

<table class="table table-bordered table-hover">

    <thead class="table-dark">

        <tr>

            <th>No</th>

            <th>Port</th>

            <th>Country</th>

            <th>City</th>

            <th>Status</th>

            <th>Action</th>

        </tr>

    </thead>

    <tbody>

    @forelse($ports as $port)

        <tr>

            <td>{{ $loop->iteration }}</td>

            <td>{{ $port->port_name }}</td>

            <td>{{ $port->country->country_name }}</td>

            <td>{{ $port->city }}</td>

            <td>{{ $port->status }}</td>

            <td>

                <a href="{{ route('ports.edit',$port->id) }}"
   class="btn btn-warning btn-sm">

    <i class="bi bi-pencil-square"></i>

    Edit

</a>

                <form action="{{ route('ports.destroy',$port->id) }}"
      method="POST"
      class="d-inline">

    @csrf
    @method('DELETE')

    <button
        class="btn btn-danger btn-sm"
        onclick="return confirm('Delete this port?')">

        <i class="bi bi-trash"></i>

        Delete

    </button>

</form>

            </td>

        </tr>

    @empty

        <tr>

            <td colspan="6" class="text-center">

                @if($selectedCountry)

    <td colspan="6" class="text-center text-warning">

        ⚠ No major seaport available for this country.

    </td>

@else

    <td colspan="6" class="text-center">

        No port data available.

    </td>

@endif

            </td>

        </tr>

    @endforelse

    </tbody>

</table>

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