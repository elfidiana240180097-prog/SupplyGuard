<div class="col-md-2 bg-white border-end min-vh-100">

    <div class="p-3">

        <!-- Profile -->
        <div class="text-center mb-4">

            <img src="https://ui-avatars.com/api/?name=Admin&background=198754&color=fff"
                 class="rounded-circle mb-2"
                 width="80">

            <h6 class="mb-0">Administrator</h6>

            <small class="text-success">
                ● Online
            </small>

        </div>

        <!-- Clock -->
        <div class="alert alert-success text-center">

            <div id="clock"></div>

            <small id="date"></small>

        </div>

        <h5 class="fw-bold text-success mb-3">
            MENU
        </h5>

        <div class="list-group list-group-flush">

            <a href="{{ route('dashboard') }}"
               class="list-group-item list-group-item-action border-0 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i>
                Dashboard
            </a>

            <a href="{{ route('countries.index') }}"
               class="list-group-item list-group-item-action border-0 {{ request()->routeIs('countries.*') ? 'active' : '' }}">
                <i class="bi bi-globe me-2"></i>
                Countries
            </a>

            <a href="{{ route('weather') }}"
               class="list-group-item list-group-item-action border-0 {{ request()->routeIs('weather') ? 'active' : '' }}">
                <i class="bi bi-cloud-sun me-2"></i>
                Weather
            </a>

            <a href="{{ route('currency') }}"
               class="list-group-item list-group-item-action border-0 {{ request()->routeIs('currency') ? 'active' : '' }}">
                <i class="bi bi-currency-exchange me-2"></i>
                Currency
            </a>

            <a href="{{ route('news') }}"
               class="list-group-item list-group-item-action border-0 {{ request()->routeIs('news') ? 'active' : '' }}">
                <i class="bi bi-newspaper me-2"></i>
                News
            </a>

            <a href="{{ route('ports.index') }}"
               class="list-group-item list-group-item-action border-0 {{ request()->routeIs('ports') ? 'active' : '' }}">
                <i class="bi bi-truck me-2"></i>
                Ports
            </a>

            <a href="{{ route('risk') }}"
               class="list-group-item list-group-item-action border-0 {{ request()->routeIs('risk') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-line me-2"></i>
                Risk Analysis
            </a>

            <a href="{{ route('comparison') }}"
               class="list-group-item list-group-item-action border-0 {{ request()->routeIs('comparison') ? 'active' : '' }}">
                <i class="bi bi-arrow-left-right me-2"></i>
                Country Comparison
            </a>

        </div>

    </div>

</div>