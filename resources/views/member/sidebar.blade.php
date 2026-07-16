<div class="col-md-2 bg-white border-end min-vh-100">

    <div class="p-3">

        <h4 class="text-success mb-4">
            Member Area
        </h4>

        <div class="list-group">

            <a href="{{ route('member.dashboard') }}"
               class="list-group-item list-group-item-action">
                Dashboard
            </a>

            <a href="{{ route('member.news') }}"
               class="list-group-item list-group-item-action">
                News
            </a>

            <a href="{{ route('member.currency') }}"
               class="list-group-item list-group-item-action">
                Currency
            </a>

            <a href="{{ route('member.watchlist') }}"
               class="list-group-item list-group-item-action">
                My Watchlist
            </a>

        </div>

    </div>

</div>