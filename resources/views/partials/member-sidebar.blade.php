<div class="col-md-2 bg-white border-end min-vh-100">

    <div class="p-3">

        <h4 class="fw-bold text-success">
            MEMBER
        </h4>

        <hr>

        <div class="list-group list-group-flush">

            <a href="{{ route('member.dashboard') }}"
               class="list-group-item list-group-item-action">

                Dashboard

            </a>

            <a href="{{ route('member.news') }}"
               class="list-group-item list-group-item-action">

                News

            </a>

            <a href="{{ route('member.weather') }}"
               class="list-group-item list-group-item-action">
                Weather
            </a>

            <a href="{{ route('member.currency') }}"
               class="list-group-item list-group-item-action">

                Currency

            </a>

            <a href="{{ route('member.watchlists') }}"
               class="list-group-item list-group-item-action">

                My Watchlist

            </a>

            <a href="{{ route('member.countries') }}"
            class="list-group-item list-group-item-action">

            Countries

            </a>

            <a href="{{ route('member.ports') }}"
            class="list-group-item list-group-item-action">

            Ports

            </a>

        </div>

    </div>

</div>