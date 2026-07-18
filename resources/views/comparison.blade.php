@extends('layouts.master')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="fw-bold mb-1">
            Country Comparison Engine
        </h2>

        <p class="text-muted mb-0">
            Compare economic, weather and supply chain risk indicators
        </p>
    </div>

</div>

<form method="GET" class="mb-4">

    <div class="row g-3">

        <div class="col-md-5">

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

        <div class="col-md-5">

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

            <button
                type="submit"
                class="btn btn-primary w-100">

                Compare

            </button>

        </div>

    </div>

</form>

@if($dataA && $dataB)

<div class="alert alert-info">

    <strong>Risk Winner:</strong>

    @if($riskA < $riskB)

        {{ $dataA->country_name }}

    @elseif($riskB < $riskA)

        {{ $dataB->country_name }}

    @else

        Equal Risk

    @endif

</div>

<div class="row">

    <div class="col-md-6 mb-4">

        <div class="card shadow-sm h-100 border-0">

            <div class="card-header bg-white">

                <img
                    src="https://flagcdn.com/48x36/{{ strtolower($dataA->country_code) }}.png"
                    width="40">

                <strong>
                    {{ $dataA->country_name }}
                </strong>

            </div>

            <div class="card-body">

                <p><b>Capital:</b> {{ $dataA->capital }}</p>

                <p><b>Region:</b> {{ $dataA->region }}</p>

                <p><b>Population:</b> {{ number_format($dataA->population) }}</p>

                <p><b>Currency:</b> {{ $dataA->currency_name }}</p>

                <p><b>Exchange Rate:</b> {{ number_format($currencyA,2) }}</p>

                <p><b>GDP:</b> ${{ number_format($gdpA,0) }}</p>

                <p><b>Inflation:</b> {{ round($inflationA,2) }}%</p>

                <p><b>Temperature:</b> {{ $temperatureA }} °C</p>

                <p>
                    <b>Risk Score:</b>

                    <span class="badge bg-danger">
                        {{ $riskA }}
                    </span>
                </p>

            </div>

        </div>

    </div>

    <div class="col-md-6 mb-4">

        <div class="card shadow-sm h-100 border-0">

            <div class="card-header bg-white">

                <img
                    src="https://flagcdn.com/48x36/{{ strtolower($dataB->country_code) }}.png"
                    width="40">

                <strong>
                    {{ $dataB->country_name }}
                </strong>

            </div>

            <div class="card-body">

                <p><b>Capital:</b> {{ $dataB->capital }}</p>

                <p><b>Region:</b> {{ $dataB->region }}</p>

                <p><b>Population:</b> {{ number_format($dataB->population) }}</p>

                <p><b>Currency:</b> {{ $dataB->currency_name }}</p>

                <p><b>Exchange Rate:</b> {{ number_format($currencyB,2) }}</p>

                <p><b>GDP:</b> ${{ number_format($gdpB,0) }}</p>

                <p><b>Inflation:</b> {{ round($inflationB,2) }}%</p>

                <p><b>Temperature:</b> {{ $temperatureB }} °C</p>

                <p>
                    <b>Risk Score:</b>

                    <span class="badge bg-danger">
                        {{ $riskB }}
                    </span>
                </p>

            </div>

        </div>

    </div>

</div>

<div class="card shadow-sm border-0">

    <div class="card-header bg-white">

        <h5 class="mb-0">
            Comparison Analytics
        </h5>

    </div>

    <div class="card-body">

        <canvas id="comparisonChart"></canvas>

    </div>

</div>

@endif

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const chart = document.getElementById('comparisonChart');

if(chart){

new Chart(chart, {

    type: 'bar',

    data: {

        labels: [
            'GDP',
            'Inflation',
            'Currency',
            'Temperature',
            'Risk Score'
        ],

        datasets: [

        {
            label: '{{ $dataA->country_name ?? "" }}',

            data: [
                {{ $gdpA ?? 0 }},
                {{ $inflationA ?? 0 }},
                {{ $currencyA ?? 0 }},
                {{ $temperatureA ?? 0 }},
                {{ $riskA ?? 0 }}
            ]
        },

        {
            label: '{{ $dataB->country_name ?? "" }}',

            data: [
                {{ $gdpB ?? 0 }},
                {{ $inflationB ?? 0 }},
                {{ $currencyB ?? 0 }},
                {{ $temperatureB ?? 0 }},
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