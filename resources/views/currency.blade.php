@extends('layouts.master')

@section('content')

<h2 class="fw-bold mb-4">
    Currency Impact Dashboard
</h2>

<form method="GET" class="mb-4">

    <div class="col-md-4">

        <select
            name="country"
            class="form-select"
            onchange="this.form.submit()">

            @foreach($countries as $item)

                <option
                    value="{{ $item->country_code }}"
                    {{ $country->country_code == $item->country_code ? 'selected' : '' }}>

                    {{ $item->country_name }}

                </option>

            @endforeach

        </select>

    </div>

</form>

<div class="row">

    <div class="col-md-3 mb-3">

        <div class="card shadow-sm">

            <div class="card-body text-center">

                <h6>Country</h6>

                <h5>{{ $country->country_name }}</h5>

            </div>

        </div>

    </div>

    <div class="col-md-3 mb-3">

        <div class="card shadow-sm">

            <div class="card-body text-center">

                <h6>Currency</h6>

                <h5>

                    {{ $country->currency_name }}

                    ({{ $country->currency_code }})

                </h5>

            </div>

        </div>

    </div>

    <div class="col-md-3 mb-3">

        <div class="card shadow-sm">

            <div class="card-body text-center">

                <h6>USD Exchange Rate</h6>

                <h4 class="text-success">

                    {{ number_format($exchangeRate,2) }}

                </h4>

            </div>

        </div>

    </div>

    <div class="col-md-3 mb-3">

        <div class="card shadow-sm">

            <div class="card-body text-center">

                <h6>Currency Risk</h6>

                <span class="badge bg-warning">

                    {{ $currencyRisk }}

                </span>

            </div>

        </div>

    </div>

</div>

<div class="card shadow-sm">

    <div class="card-header">

        Currency Chart

    </div>

    <div class="card-body">

        <canvas id="currencyChart"></canvas>

    </div>

</div>

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

new Chart(
    document.getElementById('currencyChart'),
    {
        type:'line',

        data:{

            labels:[
                '6 Days Ago',
                '5 Days Ago',
                '4 Days Ago',
                '3 Days Ago',
                '2 Days Ago',
                'Yesterday',
                'Today'
            ],

            datasets:[{

                label:'Exchange Rate',

                data:[

                    {{ max($exchangeRate - 150,0) }},
                    {{ max($exchangeRate - 120,0) }},
                    {{ max($exchangeRate - 90,0) }},
                    {{ max($exchangeRate - 60,0) }},
                    {{ max($exchangeRate - 40,0) }},
                    {{ max($exchangeRate - 20,0) }},
                    {{ $exchangeRate }}

                ]

            }]

        }

    }
);

</script>

@endpush