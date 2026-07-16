@extends('layouts.member')

@section('content')

<div class="container">

    <h2 class="mb-4">
        My Watchlist
    </h2>

    <div class="card shadow-sm">

        <div class="card-body">

            @forelse($watchlists as $watchlist)

                <div class="border-bottom mb-3 pb-2">

                    <h5>
                        {{ $watchlist->country->country_name }}
                    </h5>

                </div>

            @empty

                <p>
                    No watchlist available
                </p>

            @endforelse

        </div>

    </div>

</div>

@endsection