@extends('layouts.master')

@section('content')

<h2 class="fw-bold mb-4">
    Country Comparison
</h2>

<form method="GET">

    <div class="row mb-4">

        <div class="col-md-4">

            <select
                name="countryA"
                class="form-select">

                @foreach($countries as $country)

                    <option
                        value="{{ $country->country_code }}"
                        {{ $countryA == $country->country_code ? 'selected' : '' }}>

                        {{ $country->country_name }}

                    </option>

                @endforeach

            </select>

        </div>

        <div class="col-md-4">

            <select
                name="countryB"
                class="form-select">

                @foreach($countries as $country)

                    <option
                        value="{{ $country->country_code }}"
                        {{ $countryB == $country->country_code ? 'selected' : '' }}>

                        {{ $country->country_name }}

                    </option>

                @endforeach

            </select>

        </div>

        <div class="col-md-2">

            <button class="btn btn-primary">
                Compare
            </button>

        </div>

    </div>

</form>

@if($dataA && $dataB)

<div class="row">

    <div class="col-md-6">

        <div class="card shadow-sm h-100">

            <div class="card-header">

                <img
                    src="https://flagcdn.com/48x36/{{ strtolower($dataA->country_code) }}.png"
                    width="40"
                    alt="{{ $dataA->country_name }}">

                {{ $dataA->country_name }}

            </div>

            <div class="card-body">

                <p><b>Capital:</b> {{ $dataA->capital }}</p>

                <p><b>Region:</b> {{ $dataA->region }}</p>

                <p><b>Population:</b> {{ number_format($dataA->population) }}</p>

                <p><b>Currency:</b> {{ $dataA->currency_name }}</p>

                <p>
                    <b>GDP:</b>
                    ${{ number_format($gdpA, 0) }}
                </p>

                <p>
                    <b>Inflation:</b>
                    {{ round($inflationA, 2) }}%
                </p>

                <p>
                    <b>Temperature:</b>
                    {{ $temperatureA }} °C
                </p>

                <p>
                    <b>Risk Score:</b>
                    {{ $riskA }}
                </p>

            </div>

        </div>

    </div>

    <div class="col-md-6">

        <div class="card shadow-sm h-100">

            <div class="card-header">

                <img
                    src="https://flagcdn.com/48x36/{{ strtolower($dataB->country_code) }}.png"
                    width="40"
                    alt="{{ $dataB->country_name }}">

                {{ $dataB->country_name }}

            </div>

            <div class="card-body">

                <p><b>Capital:</b> {{ $dataB->capital }}</p>

                <p><b>Region:</b> {{ $dataB->region }}</p>

                <p><b>Population:</b> {{ number_format($dataB->population) }}</p>

                <p><b>Currency:</b> {{ $dataB->currency_name }}</p>

                <p>
                    <b>GDP:</b>
                    ${{ number_format($gdpB, 0) }}
                </p>

                <p>
                    <b>Inflation:</b>
                    {{ round($inflationB, 2) }}%
                </p>

                <p>
                    <b>Temperature:</b>
                    {{ $temperatureB }} °C
                </p>

                <p>
                    <b>Risk Score:</b>
                    {{ $riskB }}
                </p>

            </div>

        </div>

    </div>

</div>

<div class="card shadow-sm mt-4">

    <div class="card-header">

        Risk Comparison Dashboard

    </div>

    <div class="card-body">

        <canvas id="comparisonChart"></canvas>

    </div>

</div>

@endif

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const chart = document.getElementById('comparisonChart');

if(chart){

new Chart(chart, {

    type: 'bar',

    data: {

        labels: [
            "{{ $dataA->country_name ?? '' }}",
            "{{ $dataB->country_name ?? '' }}"
        ],

        datasets: [

        {
            label: 'Population',
            data: [
                {{ $dataA->population ?? 0 }},
                {{ $dataB->population ?? 0 }}
            ]
        },

        {
            label: 'Inflation',
            data: [
                {{ $inflationA ?? 0 }},
                {{ $inflationB ?? 0 }}
            ]
        },

        {
            label: 'Temperature',
            data: [
                {{ $temperatureA ?? 0 }},
                {{ $temperatureB ?? 0 }}
            ]
        },

        {
            label: 'Risk Score',
            data: [
                {{ $riskA ?? 0 }},
                {{ $riskB ?? 0 }}
            ]
        }

        ]

    },

    options: {

        responsive: true,

        plugins: {

            legend: {
                display: true
            }

        }

    }

});

}

</script>

@endpush

@endsection