@extends('layouts.master')

@section('content')

<h2 class="fw-bold mb-2">
    News Intelligence
</h2>

<p class="text-muted mb-4">
    News & Economic Intelligence for
    <strong>{{ $selectedCountry }}</strong>
</p>

<form method="GET" class="mb-4">

    <div class="row">

        <div class="col-md-4">

            <select
                name="country"
                class="form-select"
                onchange="this.form.submit()">

                @foreach($countries as $country)

                    <option
                        value="{{ $country->country_name }}"
                        {{ $selectedCountry == $country->country_name ? 'selected' : '' }}>

                        {{ $country->country_name }}

                    </option>

                @endforeach

            </select>

        </div>

    </div>

</form>

<div class="row mb-4">

    <div class="col-md-4">

        <div class="card text-center shadow-sm">

            <div class="card-body">

                <h5>Positive Score</h5>

                <h2 class="text-success">

                    {{ $positiveScore }}

                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card text-center shadow-sm">

            <div class="card-body">

                <h5>Negative Score</h5>

                <h2 class="text-danger">

                    {{ $negativeScore }}

                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card text-center shadow-sm">

            <div class="card-body">

                <h5>Sentiment</h5>

                <h2>

                    {{ $sentiment }}

                </h2>

            </div>

        </div>

    </div>

</div>

<div class="row mb-4">

    <div class="col-md-3">

        <div class="card text-center shadow-sm">

            <div class="card-body">

                <h6>Positive %</h6>

                <h3 class="text-success">

                    {{ $positivePercent }}%

                </h3>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card text-center shadow-sm">

            <div class="card-body">

                <h6>Neutral %</h6>

                <h3 class="text-primary">

                    {{ $neutralPercent }}%

                </h3>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card text-center shadow-sm">

            <div class="card-body">

                <h6>Negative %</h6>

                <h3 class="text-danger">

                    {{ $negativePercent }}%

                </h3>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card text-center shadow-sm">

            <div class="card-body">

                <h6>News Risk Score</h6>

                <h3 class="text-warning">

                    {{ $newsRiskScore }}

                </h3>

            </div>

        </div>

    </div>

</div>

<div class="card shadow-sm mb-4">

    <div class="card-header">

        <h5 class="mb-0">
            Sentiment Analysis Chart
        </h5>

    </div>

    <div class="card-body">

        <div class="d-flex justify-content-center">

            <div style="width:450px;height:450px;">

                <canvas id="sentimentChart"></canvas>

            </div>

        </div>

    </div>

</div>

<div class="row">

@forelse($articles as $article)

<div class="col-md-6 mb-4">

    <div class="card shadow-sm h-100">

        @if(!empty($article['image']))

            <img
                src="{{ $article['image'] }}"
                class="card-img-top"
                style="height:220px; object-fit:cover;">

        @endif

        <div class="card-body">

            <h5 class="fw-bold">

                {{ $article['title'] }}

            </h5>

            <p class="text-muted">

                {{ $article['description'] }}

            </p>

        </div>

        <div class="card-footer bg-white">

            <small class="text-muted">

                {{ $article['source']['name'] ?? 'Unknown Source' }}

            </small>

            <br><br>

            <a
                href="{{ $article['url'] }}"
                target="_blank"
                class="btn btn-success btn-sm">

                Read More

            </a>

        </div>

    </div>

</div>

@empty

<div class="col-12">

    <div class="alert alert-warning">

        No news found.

    </div>

</div>

@endforelse

</div>

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

new Chart(
    document.getElementById('sentimentChart'),
    {
        type: 'pie',

        data: {

            labels: [
                'Positive',
                'Neutral',
                'Negative'
            ],

            datasets: [{

                data: [
                    {{ $positivePercent }},
                    {{ $neutralPercent }},
                    {{ $negativePercent }}
                ]

            }]
        },

        options: {

            responsive: true,

            maintainAspectRatio: false

        }

    }
);

</script>

@endpush