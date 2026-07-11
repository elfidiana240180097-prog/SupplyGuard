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

        <div class="card shadow-sm">

            <div class="card-header">

                <img
                    src="{{ $dataA->flag }}"
                    width="40">

                {{ $dataA->country_name }}

            </div>

            <div class="card-body">

                <p><b>Capital:</b> {{ $dataA->capital }}</p>

                <p><b>Region:</b> {{ $dataA->region }}</p>

                <p><b>Population:</b> {{ number_format($dataA->population) }}</p>

                <p><b>Currency:</b> {{ $dataA->currency_name }}</p>

            </div>

        </div>

    </div>

    <div class="col-md-6">

        <div class="card shadow-sm">

            <div class="card-header">

                <img
                    src="{{ $dataB->flag }}"
                    width="40">

                {{ $dataB->country_name }}

            </div>

            <div class="card-body">

                <p><b>Capital:</b> {{ $dataB->capital }}</p>

                <p><b>Region:</b> {{ $dataB->region }}</p>

                <p><b>Population:</b> {{ number_format($dataB->population) }}</p>

                <p><b>Currency:</b> {{ $dataB->currency_name }}</p>

            </div>

        </div>

    </div>

</div>

<div class="card shadow-sm mt-4">

    <div class="card-header">

        Population Comparison

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

        datasets: [{

            label: 'Population',

            data: [
                {{ $dataA->population ?? 0 }},
                {{ $dataB->population ?? 0 }}
            ]

        }]

    }

});

}

</script>

@endpush

@endsection