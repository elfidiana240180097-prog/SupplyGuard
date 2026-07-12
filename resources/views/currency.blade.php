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
        type:'bar',
        data:{
            labels:[
                '{{ $country->currency_code }}'
            ],
            datasets:[{
                label:'Exchange Rate',
                data:[
                    {{ $exchangeRate }}
                ]
            }]
        }
    }
);

</script>

@endpush