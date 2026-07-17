@extends('layouts.member')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold">
            Weather Monitoring
        </h2>

        <p class="text-muted">
            Real-time weather conditions affecting global supply chains.
        </p>

    </div>

</div>

<div class="card mb-4 shadow-sm">

    <div class="card-body">

        <form method="GET">

            <div class="row">

                <div class="col-md-10">

                    <select
                        name="search"
                        class="form-select">

                        <option value="">
                            🌍 Show All Countries
                        </option>

                        @foreach($weatherCountries as $item)

                            <option
                                value="{{ $item['country'] }}"
                                {{ request('search') == $item['country'] ? 'selected' : '' }}>

                                {{ $item['country'] }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-2">

                    <button
                        class="btn btn-primary w-100">

                        <i class="bi bi-search"></i>
                        Search

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

<div class="row mb-4">

    <div class="col-md-4">

        <div class="card text-center shadow-sm">

            <div class="card-body">

                <h6>Total Countries</h6>

                <h3>{{ count($weatherCountries) }}</h3>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card text-center shadow-sm">

            <div class="card-body">

                <h6>High Wind Alerts</h6>

                <h3>
                    {{ collect($weatherCountries)->where('risk','High Wind')->count() }}
                </h3>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card text-center shadow-sm">

            <div class="card-body">

                <h6>Storm Risk Alerts</h6>

                <h3>
                    {{ collect($weatherCountries)->where('risk','Storm Risk')->count() }}
                </h3>

            </div>

        </div>

    </div>

</div>

<div class="card mb-4 shadow-sm">

    <div class="card-header">

        Global Weather Map

    </div>

    <div class="card-body">

        <div id="weatherMap" style="height:500px;"></div>

    </div>

</div>

<div class="card shadow-sm">

    <div class="card-header">

        Global Weather Conditions

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead class="table-dark">

                    <tr>

                        <th>No</th>
                        <th>Country</th>
                        <th>Temperature</th>
                        <th>Wind Speed</th>
                        <th>Risk Status</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($weatherCountries as $weather)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>

                            @if(!empty($weather['flag']))
                                <span style="font-size:20px;">
                                    {{ $weather['flag'] }}
                                </span>
                            @endif

                            {{ $weather['country'] }}

                        </td>

                        <td>

                            {{ $weather['temperature'] }} °C

                        </td>

                        <td>

                            {{ $weather['wind'] }} km/h

                        </td>

                        <td>

                            @if($weather['risk'] == 'Normal')

                                <span class="badge bg-success">
                                    Normal
                                </span>

                            @elseif($weather['risk'] == 'High Wind')

                                <span class="badge bg-warning text-dark">
                                    High Wind
                                </span>

                            @else

                                <span class="badge bg-danger">
                                    Storm Risk
                                </span>

                            @endif

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="5" class="text-center">

                            No weather data available.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@push('scripts')

<script>

const map = L.map('weatherMap').setView([20, 0], 2);

L.tileLayer(
    'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
    {
        attribution: '&copy; OpenStreetMap'
    }
).addTo(map);

const weatherCountries = @json($weatherCountries);

weatherCountries.forEach(function(item){

    if(item.lat && item.lng){

        L.marker([
            item.lat,
            item.lng
        ])
        .addTo(map)
        .bindPopup(
            `
            <strong>${item.country}</strong><br>
            🌡 ${item.temperature} °C<br>
            💨 ${item.wind} km/h<br>
            ⚠ ${item.risk}
            `
        );

    }

});

</script>

@endpush

@endsection