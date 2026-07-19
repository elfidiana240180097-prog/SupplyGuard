<div class="col-md-2 sidebar-member">

    <div class="p-3">

        <div class="text-center mb-4">

            <img
                src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0d6efd&color=fff"
                class="rounded-circle shadow mb-3"
                width="80">

            <h6 class="text-white mb-1">
                {{ auth()->user()->name }}
            </h6>

            <small class="text-info">
                Member Account
            </small>

        </div>

        <div class="glass-card text-center mb-4">

            <div id="clock"></div>

            <small id="date"></small>

        </div>

        <h6 class="menu-title">
            MEMBER MENU
        </h6>

        <div class="list-group member-menu">

            <a href="{{ route('member.dashboard') }}"
               class="list-group-item list-group-item-action {{ request()->routeIs('member.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i>
                Dashboard
            </a>

            <a href="{{ route('member.news') }}"
               class="list-group-item list-group-item-action {{ request()->routeIs('member.news') ? 'active' : '' }}">
                <i class="bi bi-newspaper me-2"></i>
                News
            </a>

            <a href="{{ route('member.weather') }}"
               class="list-group-item list-group-item-action {{ request()->routeIs('member.weather') ? 'active' : '' }}">
                <i class="bi bi-cloud-sun me-2"></i>
                Weather
            </a>

            <a href="{{ route('member.currency') }}"
               class="list-group-item list-group-item-action {{ request()->routeIs('member.currency') ? 'active' : '' }}">
                <i class="bi bi-currency-exchange me-2"></i>
                Currency
            </a>

            <a href="{{ route('member.countries') }}"
               class="list-group-item list-group-item-action {{ request()->routeIs('member.countries') ? 'active' : '' }}">
                <i class="bi bi-globe me-2"></i>
                Countries
            </a>

            <a href="{{ route('member.ports') }}"
               class="list-group-item list-group-item-action {{ request()->routeIs('member.ports') ? 'active' : '' }}">
                <i class="bi bi-truck me-2"></i>
                Ports
            </a>

            <a href="{{ route('member.watchlists') }}"
               class="list-group-item list-group-item-action {{ request()->routeIs('member.watchlists') ? 'active' : '' }}">
                <i class="bi bi-star-fill me-2"></i>
                Watchlist
            </a>

        </div>

    </div>

</div>

<style>

.sidebar-member{
    min-height:100vh;
    background:linear-gradient(
        180deg,
        #0f172a,
        #1e293b
    );
}

.glass-card{
    background:rgba(255,255,255,.08);
    border:1px solid rgba(255,255,255,.15);
    backdrop-filter:blur(12px);
    color:white;
    border-radius:16px;
    padding:15px;
}

.menu-title{
    color:#94a3b8;
    margin-bottom:15px;
}

.member-menu .list-group-item{
    background:transparent;
    border:none;
    color:#e2e8f0;
    border-radius:12px;
    margin-bottom:6px;
    transition:.3s;
}

.member-menu .list-group-item:hover{
    background:rgba(255,255,255,.08);
    transform:translateX(5px);
}

.member-menu .active{
    background:linear-gradient(
        135deg,
        #0d6efd,
        #06b6d4
    ) !important;
    color:white !important;
    font-weight:600;
}

</style>