<div class="col-md-2 sidebar-panel min-vh-100">

    <div class="p-3">

        <div class="text-center mb-4">

            <img
                src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0f172a&color=fff"
                class="rounded-circle shadow mb-3"
                width="85">

            <h6 class="fw-bold mb-1 text-dark">
                {{ auth()->user()->name }}
            </h6>

            <small class="text-success">
                ● Member Online
            </small>

        </div>

        <div class="member-clock mb-4">

            <div id="clock"></div>

            <small id="date"></small>

        </div>

        <h6 class="menu-title">
            MEMBER MENU
        </h6>

        <div class="list-group list-group-flush member-menu">

            <a href="{{ route('member.dashboard') }}"
               class="list-group-item list-group-item-action border-0 {{ request()->routeIs('member.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i>
                Dashboard
            </a>

            <a href="{{ route('member.news') }}"
               class="list-group-item list-group-item-action border-0 {{ request()->routeIs('member.news') ? 'active' : '' }}">
                <i class="bi bi-newspaper me-2"></i>
                News Intelligence
            </a>

            <a href="{{ route('member.weather') }}"
               class="list-group-item list-group-item-action border-0 {{ request()->routeIs('member.weather') ? 'active' : '' }}">
                <i class="bi bi-cloud-sun me-2"></i>
                Weather
            </a>

            <a href="{{ route('member.currency') }}"
               class="list-group-item list-group-item-action border-0 {{ request()->routeIs('member.currency') ? 'active' : '' }}">
                <i class="bi bi-currency-exchange me-2"></i>
                Currency
            </a>

            <a href="{{ route('member.watchlists') }}"
               class="list-group-item list-group-item-action border-0 {{ request()->routeIs('member.watchlists') ? 'active' : '' }}">
                <i class="bi bi-star-fill me-2"></i>
                Watchlist
            </a>

            <a href="{{ route('member.countries') }}"
               class="list-group-item list-group-item-action border-0 {{ request()->routeIs('member.countries') ? 'active' : '' }}">
                <i class="bi bi-globe me-2"></i>
                Countries
            </a>

            <a href="{{ route('member.ports') }}"
               class="list-group-item list-group-item-action border-0 {{ request()->routeIs('member.ports') ? 'active' : '' }}">
                <i class="bi bi-truck me-2"></i>
                Ports
            </a>

        </div>

    </div>

</div>

<style>

.sidebar-panel{
    background:rgba(255,255,255,.85);
    backdrop-filter:blur(20px);
    border-right:1px solid rgba(255,255,255,.4);
    box-shadow:0 10px 30px rgba(0,0,0,.06);
}

.member-clock{
    background:
    linear-gradient(
        135deg,
        #198754,
        #20c997
    );
    color:white;
    border-radius:16px;
    padding:14px;
    text-align:center;
    box-shadow:
    0 8px 20px rgba(25,135,84,.2);
}

.menu-title{
    font-size:12px;
    font-weight:700;
    color:#64748b;
    letter-spacing:1px;
    margin-bottom:12px;
}

.member-menu .list-group-item{
    border-radius:12px !important;
    margin-bottom:6px;
    font-weight:500;
    transition:.25s;
}

.member-menu .list-group-item:hover{
    background:#eef8f2;
    transform:translateX(4px);
}

.member-menu .active{
    background:
    linear-gradient(
        135deg,
        #198754,
        #20c997
    ) !important;

    color:white !important;
    border:none !important;

    box-shadow:
    0 8px 20px rgba(25,135,84,.2);
}

</style>