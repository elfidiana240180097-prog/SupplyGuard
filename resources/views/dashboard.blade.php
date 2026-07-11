@extends('layouts.master')

@section('content')

<div class="row">

    <div class="col-md-12 mb-4">

        <div class="card shadow border-0">

            <div class="card-body">

                <h2 class="fw-bold text-success">
                    SupplyGuard Dashboard
                </h2>

                <p class="text-muted mb-0">
                    Welcome back,
                    <strong>{{ Auth::user()->name }}</strong>

                    <form method="GET" action="{{ route('dashboard') }}" class="mt-3">

    <div class="row">

        <div class="col-md-4">

            <select
                name="country"
                class="form-select"
                onchange="this.form.submit()">

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
                </p>

            </div>

        </div>

    </div>

</div>

<div class="row">

    <div class="col-md mb-4">

        <div class="card shadow-sm border-0 h-100">

            <div class="card-body text-center">

                <h6 class="text-muted">
                    Population
                </h6>

                <h4 class="fw-bold text-success">
                    {{ $population ? number_format($population) : 'N/A' }}
                </h4>

            </div>

        </div>

    </div>

    <div class="row">

    <div class="col-md-3 mb-4">

        <div class="card shadow-sm border-0">

            <div class="card-body text-center">

                <h6>Total Countries</h6>

                <h3 class="fw-bold text-primary">
                    {{ $totalCountries }}
                </h3>

            </div>

        </div>

    </div>

    <div class="col-md-3 mb-4">

        <div class="card shadow-sm border-0">

            <div class="card-body text-center">

                <h6>High Risk</h6>

                <h3 class="fw-bold text-danger">
                    {{ $highRiskCountries }}
                </h3>

            </div>

        </div>

    </div>

    <div class="col-md-3 mb-4">

        <div class="card shadow-sm border-0">

            <div class="card-body text-center">

                <h6>Medium Risk</h6>

                <h3 class="fw-bold text-warning">
                    {{ $mediumRiskCountries }}
                </h3>

            </div>

        </div>

    </div>

    <div class="col-md-3 mb-4">

        <div class="card shadow-sm border-0">

            <div class="card-body text-center">

                <h6>Low Risk</h6>

                <h3 class="fw-bold text-success">
                    {{ $lowRiskCountries }}
                </h3>

            </div>

        </div>

    </div>

</div>

    <div class="col-md mb-4">

        <div class="card shadow-sm border-0 h-100">

            <div class="card-body text-center">

                <h6 class="text-muted">
                    GDP
                </h6>

                <h4 class="fw-bold text-primary">
                    {{ $gdp ? '$'.number_format($gdp) : 'N/A' }}
                </h4>

            </div>

        </div>

    </div>

    <div class="col-md mb-4">

        <div class="card shadow-sm border-0 h-100">

            <div class="card-body text-center">

                <h6 class="text-muted">
                    Inflation
                </h6>

                <h4 class="fw-bold text-danger">
                    {{ $inflation ? round($inflation,2).' %' : 'N/A' }}
                </h4>

            </div>

        </div>

    </div>

    <div class="col-md mb-4">

        <div class="card shadow-sm border-0 h-100">

            <div class="card-body text-center">

                <h6 class="text-muted">
                    Currency
                </h6>

                <h4 class="fw-bold text-warning">
                    {{ $currency ? 'IDR '.number_format($currency,0) : 'N/A' }}
                </h4>

            </div>

        </div>

    </div>

    <div class="col-md mb-4">

        <div class="card shadow-sm border-0 h-100">

            <div class="card-body text-center">

                <h6 class="text-muted">
                    Weather
                </h6>

                <h4 class="fw-bold text-info">
                    {{ $temperature ? $temperature.' °C' : 'N/A' }}
                </h4>

            </div>

        </div>

    </div>

</div>

<div class="card shadow border-0 mb-4">

    <div class="card-body text-center">

        <h5 class="text-muted">
            Supply Chain Risk Score
        </h5>

        <h1 class="fw-bold">

            {{ $riskScore }}

        </h1>

        @if($riskLevel == 'Low')

            <span class="badge bg-success fs-6">
                LOW RISK
            </span>

        @elseif($riskLevel == 'Medium')

            <span class="badge bg-warning fs-6">
                MEDIUM RISK
            </span>

        @elseif($riskLevel == 'High')

            <span class="badge bg-danger fs-6">
                HIGH RISK
            </span>

        @else

            <span class="badge bg-dark fs-6">
                CRITICAL RISK
            </span>

        @endif

    </div>

</div>

<div class="card shadow border-0 mt-4">

    <div class="card-header">

        <h5 class="mb-0">
            Global Monitoring Map
        </h5>

    </div>

    <div class="card-body">

        <div id="worldMap"
             style="height:500px;">
        </div>

    </div>

</div>



@push('scripts')

<script>

var lat = {{ $countryData->latitude ?? 0 }};
var lng = {{ $countryData->longitude ?? 0 }};

var map = L.map('worldMap').setView([lat, lng], 4);

L.tileLayer(
'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
{
    maxZoom: 19
}
).addTo(map);

L.marker([lat, lng])
.addTo(map)
.bindPopup(
'{{ $countryData->country_name ?? "Country" }}'
);

</script>

@endpush

@endsection