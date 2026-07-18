@extends('layouts.master')

@section('content')

<div class="container-fluid">

    <div class="row mb-4">

        <div class="col-md-12">

            <div class="card border-0 shadow">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center flex-wrap">

                        <div>

                            <h2 class="fw-bold text-success mb-1">

                                SupplyGuard Dashboard

                            </h2>

                            <p class="text-muted mb-0">

                                Welcome back,
                                <strong>{{ Auth::user()->name }}</strong>

                            </p>

                        </div>

                        <div>

                            <small class="text-muted">

                            </small>

                            <br>

                            <strong>

                            </strong>

                        </div>

                    </div>

                    <hr>

                    <form method="GET" action="{{ route('dashboard') }}">

                        <div class="row">

                            <div class="col-md-4">

                                <select
                                    name="country"
                                    class="form-select"
                                    onchange="this.form.submit()">

                                    @foreach($countries as $country)

                                        <option
                                            value="{{ $country->country_code }}"
                                            {{ $selectedCountry==$country->country_code ? 'selected':'' }}>

                                            {{ $country->country_name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>


    {{-- ===================== --}}
    {{-- SUMMARY CARD --}}
    {{-- ===================== --}}

    <div class="row">

        <div class="col-lg-3 col-md-6 mb-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body text-center">

                    <h6 class="text-muted">

                        Selected Country

                    </h6>

                    <h3 class="fw-bold text-success">

                        {{ $countryData->country_name ?? '-' }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6 mb-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body text-center">

                    <h6 class="text-muted">

                        Population

                    </h6>

                    <h3 class="fw-bold text-primary">

                        {{ number_format($population) }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6 mb-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body text-center">

                    <h6 class="text-muted">

                        GDP

                    </h6>

                    <h3 class="fw-bold text-success">

                        ${{ number_format($gdp,0) }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6 mb-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body text-center">

                    <h6 class="text-muted">

                        Inflation

                    </h6>

                    <h3 class="fw-bold text-danger">

                        {{ number_format($inflation,2) }} %

                    </h3>

                </div>

            </div>

        </div>

    </div>


    <div class="row">

        <div class="col-lg-3 col-md-6 mb-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body text-center">

                    <h6>Total Countries</h6>

                    <h2 class="fw-bold text-primary">

                        {{ $totalCountries }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6 mb-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body text-center">

                    <h6>High Risk</h6>

                    <h2 class="fw-bold text-danger">

                        {{ $highRiskCountries }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6 mb-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body text-center">

                    <h6>Medium Risk</h6>

                    <h2 class="fw-bold text-warning">

                        {{ $mediumRiskCountries }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6 mb-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body text-center">

                    <h6>Low Risk</h6>

                    <h2 class="fw-bold text-success">

                        {{ $lowRiskCountries }}

                    </h2>

                </div>

            </div>

        </div>

    </div>


    <div class="row">

        <div class="col-md-4 mb-4">

            <div class="card shadow border-0 h-100">

                <div class="card-body text-center">

                    <h6 class="text-muted">

                        Currency Rate

                    </h6>

                    <h2 class="fw-bold text-warning">

                        {{ number_format($currency,2) }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-4 mb-4">

            <div class="card shadow border-0 h-100">

                <div class="card-body text-center">

                    <h6 class="text-muted">

                        Temperature

                    </h6>

                    <h2 class="fw-bold text-info">

                        {{ $temperature }} °C

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-4 mb-4">

            <div class="card shadow border-0 h-100">

                <div class="card-body text-center">

                    <h6 class="text-muted">

                        Supply Chain Risk

                    </h6>

                    <h1 class="fw-bold">

                        {{ $riskScore }}

                    </h1>

                    @if($riskLevel=="Low")

                        <span class="badge bg-success">

                            LOW

                        </span>

                    @elseif($riskLevel=="Medium")

                        <span class="badge bg-warning">

                            MEDIUM

                        </span>

                    @elseif($riskLevel=="High")

                        <span class="badge bg-danger">

                            HIGH

                        </span>

                    @else

                        <span class="badge bg-dark">

                            CRITICAL

                        </span>

                    @endif

                </div>

            </div>

        </div>

    </div>

    {{-- ====================================================== --}}
{{-- GLOBAL MAP + RISK COMPONENT --}}
{{-- ====================================================== --}}

<div class="row">

    <div class="col-lg-8 mb-4">

        <div class="card border-0 shadow h-100">

            <div class="card-header bg-white">

                <h5 class="mb-0 fw-bold">

                    🌍 Global Monitoring Map

                </h5>

            </div>

            <div class="card-body">

                <div
                    id="worldMap"
                    style="height:500px;border-radius:10px;">

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-4 mb-4">

        <div class="card border-0 shadow h-100">

            <div class="card-header bg-white">

                <h5 class="fw-bold mb-0">

                    Risk Components

                </h5>

            </div>

            <div class="card-body">

                <canvas id="riskRadarChart"></canvas>

            </div>

        </div>

    </div>

</div>

{{-- ====================================================== --}}
{{-- PIE CHART + TOP RANKING --}}
{{-- ====================================================== --}}

<div class="row">

    <div class="col-lg-5 mb-4">

        <div class="card border-0 shadow h-100">

            <div class="card-header bg-white">

                <h5 class="fw-bold mb-0">

                    Risk Distribution

                </h5>

            </div>

            <div class="card-body">

                <canvas id="riskPieChart"></canvas>

            </div>

        </div>

    </div>

    <div class="col-lg-7 mb-4">

        <div class="card border-0 shadow h-100">

            <div class="card-header bg-white">

                <h5 class="fw-bold mb-0">

                    Top 5 Highest Risk Countries

                </h5>

            </div>

            <div class="card-body">

                <table class="table table-hover align-middle">

                    <thead>

                    <tr>

                        <th>#</th>

                        <th>Country</th>

                        <th>Risk</th>

                        <th>Status</th>

                    </tr>

                    </thead>

                    <tbody>

                    @foreach($topRiskCountries as $index=>$country)

                        <tr>

                            <td>

                                {{ $index+1 }}

                            </td>

                            <td>

                                {{ $country->country->country_name }}

                            </td>

                            <td>

                                <strong>

                                    {{ number_format($country->overall_score,2) }}

                                </strong>

                            </td>

                            <td>

                                @if($country->risk_level=="Low")

                                    <span class="badge bg-success">

                                        Low

                                    </span>

                                @elseif($country->risk_level=="Medium")

                                    <span class="badge bg-warning">

                                        Medium

                                    </span>

                                @elseif($country->risk_level=="High")

                                    <span class="badge bg-danger">

                                        High

                                    </span>

                                @else

                                    <span class="badge bg-dark">

                                        Critical

                                    </span>

                                @endif

                            </td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

{{-- ====================================================== --}}
{{-- RISK PROGRESS --}}
{{-- ====================================================== --}}

<div class="card border-0 shadow mb-4">

    <div class="card-header bg-white">

        <h5 class="fw-bold mb-0">

            Overall Supply Chain Risk

        </h5>

    </div>

    <div class="card-body">

        <div class="progress" style="height:30px;">

            <div

                class="progress-bar

                @if($riskScore<40)

                    bg-success

                @elseif($riskScore<60)

                    bg-warning

                @elseif($riskScore<80)

                    bg-danger

                @else

                    bg-dark

                @endif"

                role="progressbar"

                style="width: {{ min($riskScore,100) }}%;">

                {{ $riskScore }}

            </div>

        </div>

    </div>

</div>

@push('scripts')

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Leaflet -->
<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>

document.addEventListener("DOMContentLoaded",function(){

    /*
    |--------------------------------------------------------------------------
    | GLOBAL MAP
    |--------------------------------------------------------------------------
    */

    const latitude={{ $mapLat }};
    const longitude={{ $mapLng }};

    const map=L.map('worldMap').setView(
        [latitude,longitude],
        4
    );

    L.tileLayer(
        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        {
            maxZoom:19,
            attribution:'© OpenStreetMap'
        }
    ).addTo(map);

    L.marker([latitude,longitude])
        .addTo(map)
        .bindPopup(
            "<b>{{ $countryData->country_name }}</b>"
        )
        .openPopup();


    /*
    |--------------------------------------------------------------------------
    | RADAR CHART
    |--------------------------------------------------------------------------
    */

    new Chart(

        document.getElementById('riskRadarChart'),

        {

            type:'radar',

            data:{

                labels:[
                    'Weather',
                    'Inflation',
                    'Currency',
                    'News',
                    'Port'
                ],

                datasets:[{

                    label:'Risk Score',

                    data:@json($riskComponents),

                    fill:true

                }]

            },

            options:{

                responsive:true,

                scales:{
                    r:{
                        beginAtZero:true,
                        suggestedMax:50
                    }
                }

            }

        }

    );


    /*
    |--------------------------------------------------------------------------
    | PIE CHART
    |--------------------------------------------------------------------------
    */

    new Chart(

        document.getElementById('riskPieChart'),

        {

            type:'pie',

            data:{

                labels:[
                    'Low',
                    'Medium',
                    'High'
                ],

                datasets:[{

                    data:@json($riskDistribution)

                }]

            },

            options:{

                responsive:true,

                plugins:{

                    legend:{
                        position:'bottom'
                    }

                }

            }

        }

    );

});

</script>

@endpush

@endsection