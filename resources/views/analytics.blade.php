@extends('layouts.master')

@section('content')

<h2 class="fw-bold mb-4">
    Analytics Dashboard
</h2>

<form method="GET" class="mb-4">

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

<div class="row mb-4">

    <div class="col-md-3">

        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">

                <h6 class="text-muted">
                    Population
                </h6>

                <h4 class="fw-bold text-primary">
                    {{ number_format($population) }}
                </h4>

            </div>
        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">

                <h6 class="text-muted">
                    GDP
                </h6>

                <h4 class="fw-bold text-success">
                    ${{ number_format($gdp) }}
                </h4>

            </div>
        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">

                <h6 class="text-muted">
                    Inflation
                </h6>

                <h4 class="fw-bold text-danger">
                    {{ number_format($inflation,2) }}%
                </h4>

            </div>
        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">

                <h6 class="text-muted">
                    Risk Score
                </h6>

                <h4 class="fw-bold text-warning">
                    {{ number_format($risk->overall_score ?? 0,2) }}
                </h4>

            </div>
        </div>

    </div>

</div>

<div class="card border-0 shadow-sm">

    <div class="card-header bg-white">

        <h5 class="mb-0 fw-bold">
            Risk Components Analysis
        </h5>

    </div>

    <div class="card-body">

        <canvas id="riskChart" height="110"></canvas>

    </div>

</div>

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document.getElementById('riskChart');

const gradient = ctx
    .getContext('2d')
    .createLinearGradient(0, 0, 0, 400);

gradient.addColorStop(0, 'rgba(25,135,84,0.45)');
gradient.addColorStop(1, 'rgba(25,135,84,0.02)');

new Chart(ctx, {

    type: 'line',

    data: {

        labels: [
            'Weather',
            'Inflation',
            'Currency',
            'News',
            'Port'
        ],

        datasets: [{

            label: 'Risk Score',

            data: [

                {{ $risk->weather_score ?? 0 }},
                {{ $risk->inflation_score ?? 0 }},
                {{ $risk->currency_score ?? 0 }},
                {{ $risk->news_score ?? 0 }},
                {{ $risk->port_score ?? 0 }}

            ],

            borderWidth: 4,

            borderColor: '#198754',

            backgroundColor: gradient,

            fill: true,

            tension: 0.45,

            pointRadius: 6,

            pointHoverRadius: 9,

            pointBackgroundColor: '#198754'

        }]

    },

    options: {

        responsive: true,

        plugins: {

            legend: {

                display: true

            }

        },

        scales: {

            y: {

                beginAtZero: true,

                max: 60

            }

        }

    }

});

</script>

@endpush