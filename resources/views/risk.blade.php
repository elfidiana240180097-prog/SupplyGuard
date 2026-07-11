@extends('layouts.master')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2 class="fw-bold">
        Risk Analysis
    </h2>

    <a
        href="{{ route('risk.pdf') }}"
        class="btn btn-danger">

        Export PDF Report

    </a>

</div>

<form method="GET">

    <div class="row mb-4">

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

<div class="row">

    <div class="col-md-3 mb-4">

        <div class="card shadow-sm">

            <div class="card-body text-center">

                <h6>Population</h6>

                <h4 class="text-success">

                    {{ number_format($population) }}

                </h4>

            </div>

        </div>

    </div>

    <div class="col-md-3 mb-4">

        <div class="card shadow-sm">

            <div class="card-body text-center">

                <h6>GDP</h6>

                <h4 class="text-primary">

                    ${{ number_format($gdp) }}

                </h4>

            </div>

        </div>

    </div>

    <div class="col-md-3 mb-4">

        <div class="card shadow-sm">

            <div class="card-body text-center">

                <h6>Inflation</h6>

                <h4 class="text-danger">

                    {{ round($inflation,2) }}%

                </h4>

            </div>

        </div>

    </div>

    <div class="col-md-3 mb-4">

        <div class="card shadow-sm">

            <div class="card-body text-center">

                <h6>Risk Score</h6>

                <h3 class="fw-bold">

                    {{ $riskScore }}

                </h3>

                <span class="badge bg-warning">

                    {{ $riskLevel }}

                </span>

            </div>

        </div>

    </div>

</div>

<div class="card shadow-sm">

    <div class="card-header">

        <h5 class="mb-0">
            Risk Indicator Chart
        </h5>

    </div>

    <div class="card-body">

        <div class="d-flex justify-content-center">

            <div style="width:500px;height:500px;">

                <canvas id="riskChart"></canvas>

            </div>

        </div>

    </div>

</div>

<div class="card shadow-sm mt-4">

    <div class="card-header">

        <h5 class="mb-0">
            Top 10 Country Risk Ranking
        </h5>

    </div>

    <div class="card-body">

        <table class="table table-striped">

            <thead>

                <tr>

                    <th>Rank</th>
                    <th>Country</th>
                    <th>Population</th>
                    <th>Status</th>

                </tr>

            </thead>

            <tbody>

                @foreach($rankingCountries as $index => $country)

                <tr>

                    <td>{{ $index + 1 }}</td>

                    <td>{{ $country->country_name }}</td>

                    <td>{{ number_format($country->population) }}</td>

                    <td>

                        @if($country->population > 1000000000)

                            <span class="badge bg-danger">
                                High
                            </span>

                        @elseif($country->population > 100000000)

                            <span class="badge bg-warning">
                                Medium
                            </span>

                        @else

                            <span class="badge bg-success">
                                Low
                            </span>

                        @endif

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document.getElementById('riskChart');

new Chart(ctx, {

    type: 'doughnut',

    data: {

        labels: [
            'Population',
            'GDP',
            'Inflation',
            'Risk Score'
        ],

        datasets: [{

            data: [
                {{ round($population / 1000000, 2) }},
                {{ round($gdp / 100000000000, 2) }},
                {{ round($inflation, 2) }},
                {{ $riskScore }}
            ]

        }]
    },

    options: {

        responsive: true,

        maintainAspectRatio: false,

        plugins: {

            legend: {
                position: 'top'
            }

        }

    }

});

</script>

@endpush

@endsection