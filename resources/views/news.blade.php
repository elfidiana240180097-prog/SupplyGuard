@extends('layouts.master')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="fw-bold mb-1">
            News Intelligence Dashboard
        </h2>

        <p class="text-muted mb-0">
            Real-Time Economic News Monitoring &
            Sentiment Analysis
        </p>
    </div>

</div>

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

    <div class="col-md-3">

        <div class="card border-0 shadow-sm text-center">

            <div class="card-body">

                <h6 class="text-muted">
                    Positive Score
                </h6>

                <h2 class="fw-bold text-success">
                    {{ $positiveScore }}
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-0 shadow-sm text-center">

            <div class="card-body">

                <h6 class="text-muted">
                    Negative Score
                </h6>

                <h2 class="fw-bold text-danger">
                    {{ $negativeScore }}
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-0 shadow-sm text-center">

            <div class="card-body">

                <h6 class="text-muted">
                    Sentiment
                </h6>

                <h2 class="fw-bold">

                    @if($sentiment == 'Positive')

                        <span class="text-success">
                            Positive
                        </span>

                    @elseif($sentiment == 'Negative')

                        <span class="text-danger">
                            Negative
                        </span>

                    @else

                        <span class="text-primary">
                            Neutral
                        </span>

                    @endif

                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-0 shadow-sm text-center">

            <div class="card-body">

                <h6 class="text-muted">
                    News Risk Score
                </h6>

                <h2 class="fw-bold text-warning">
                    {{ $newsRiskScore }}
                </h2>

            </div>

        </div>

    </div>

</div>

<div class="row mb-4">

    <div class="col-md-7">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-header bg-white">

                <h5 class="mb-0 fw-bold">
                    Sentiment Distribution
                </h5>

            </div>

            <div class="card-body">

                <canvas id="sentimentChart"></canvas>

            </div>

        </div>

    </div>

    <div class="col-md-5">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-header bg-white">

                <h5 class="mb-0 fw-bold">
                    Analysis Summary
                </h5>

            </div>

            <div class="card-body">

                <table class="table">

                    <tr>
                        <th>Positive News</th>
                        <td>{{ $positivePercent }}%</td>
                    </tr>

                    <tr>
                        <th>Neutral News</th>
                        <td>{{ $neutralPercent }}%</td>
                    </tr>

                    <tr>
                        <th>Negative News</th>
                        <td>{{ $negativePercent }}%</td>
                    </tr>

                    <tr>
                        <th>Risk Score</th>
                        <td>{{ $newsRiskScore }}</td>
                    </tr>

                    <tr>
                        <th>Final Sentiment</th>
                        <td>{{ $sentiment }}</td>
                    </tr>

                </table>

            </div>

        </div>

    </div>

</div>

<h4 class="fw-bold mb-3">
    Latest Economic News
</h4>

<div class="row">

@forelse($articles as $article)

<div class="col-md-6 mb-4">

    <div class="card border-0 shadow-sm h-100">

        @if(!empty($article['image']))

            <img
                src="{{ $article['image'] }}"
                class="card-img-top"
                style="height:220px;object-fit:cover">

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
        type: 'doughnut',

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

            plugins: {

                legend: {

                    position: 'bottom'

                }

            }

        }

    }
);

</script>

@endpush