@extends('layouts.master')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="fw-bold mb-1">
            Analytics Dashboard
        </h2>

        <p class="text-muted mb-0">
            Business Intelligence & Supply Chain Analytics
        </p>
    </div>

</div>

<form method="GET" class="mb-4">

    <div class="row">

        <div class="col-md-4">

            <select
                name="country"
                class="form-select shadow-sm"
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

    <div class="col-md-3 mb-3">

        <div class="card border-0 shadow-sm h-100">

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

    <div class="col-md-3 mb-3">

        <div class="card border-0 shadow-sm h-100">

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

    <div class="col-md-3 mb-3">

        <div class="card border-0 shadow-sm h-100">

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

    <div class="col-md-3 mb-3">

        <div class="card border-0 shadow-sm h-100">

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

<div class="card border-0 shadow-sm mb-4">

    <div class="card-header bg-white">

        <h5 class="mb-0 fw-bold">
            Risk Components Analysis
        </h5>

    </div>

    <div class="card-body">

        <canvas id="riskChart"></canvas>

    </div>

</div>

<div class="row">

    <div class="col-md-6 mb-4">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-white">

                GDP Trend

            </div>

            <div class="card-body">

                <canvas id="gdpChart"></canvas>

            </div>

        </div>

    </div>

    <div class="col-md-6 mb-4">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-white">

                Inflation Trend

            </div>

            <div class="card-body">

                <canvas id="inflationChart"></canvas>

            </div>

        </div>

    </div>

</div>

<div class="row">

    <div class="col-md-6 mb-4">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-white">

                Currency Trend

            </div>

            <div class="card-body">

                <canvas id="currencyChart"></canvas>

            </div>

        </div>

    </div>

    <div class="col-md-6 mb-4">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-white">

                Risk Trend

            </div>

            <div class="card-body">

                <canvas id="riskTrendChart"></canvas>

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

new Chart(
document.getElementById('riskChart'),
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
            label:'Risk Components',
            data:[
                {{ $risk->weather_score ?? 0 }},
                {{ $risk->inflation_score ?? 0 }},
                {{ $risk->currency_score ?? 0 }},
                {{ $risk->news_score ?? 0 }},
                {{ $risk->port_score ?? 0 }}
            ]
        }]
    }
});

new Chart(
document.getElementById('gdpChart'),
{
    type:'line',

    data:{
        labels:[
            '2021',
            '2022',
            '2023',
            '2024',
            '2025'
        ],

        datasets:[{
            label:'GDP',
            data:@json($gdpTrend)
        }]
    }
});

new Chart(
document.getElementById('inflationChart'),
{
    type:'line',

    data:{
        labels:[
            '2021',
            '2022',
            '2023',
            '2024',
            '2025'
        ],

        datasets:[{
            label:'Inflation',
            data:@json($inflationTrend)
        }]
    }
});

new Chart(
document.getElementById('currencyChart'),
{
    type:'line',

    data:{
        labels:[
            'Day 1',
            'Day 2',
            'Day 3',
            'Day 4',
            'Day 5'
        ],

        datasets:[{
            label:'Currency',
            data:@json($currencyTrend)
        }]
    }
});

new Chart(
document.getElementById('riskTrendChart'),
{
    type:'bar',

    data:{
        labels:[
            'Period 1',
            'Period 2',
            'Period 3',
            'Period 4',
            'Current'
        ],

        datasets:[{
            label:'Risk Score',
            data:@json($riskTrend)
        }]
    }
});

</script>

@endpush