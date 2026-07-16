@extends('layouts.member')

@section('content')

<div class="container">

    <h2 class="mb-4">
        Currency Information
    </h2>

    <div class="card shadow-sm">

        <div class="card-body">

            <h4>
                {{ $country->country_name }}
            </h4>

            <p>

                Currency :
                <strong>
                    {{ $country->currency_name }}
                </strong>

            </p>

            <p>

                Exchange Rate :

                <strong>
                    {{ number_format($exchangeRate,2) }}
                </strong>

            </p>

        </div>

    </div>

</div>

@endsection