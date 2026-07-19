<div class="col-md-2 sidebar-panel min-vh-100">

```
<div class="p-3">

    <div class="text-center mb-4">

        <div
            class="mx-auto mb-3 d-flex align-items-center justify-content-center"
            style="
                width:90px;
                height:90px;
                border-radius:50%;
                background:linear-gradient(135deg,#198754,#20c997);
                box-shadow:0 10px 25px rgba(25,135,84,.25);
            ">

            <i class="bi bi-person-fill text-white fs-1"></i>

        </div>

        <h6 class="fw-bold mb-1">
            {{ auth()->user()->name }}
        </h6>

        <small class="text-muted">
            {{ ucfirst(auth()->user()->role) }}
        </small>

        <div class="mt-2">
            <span class="badge bg-success">
                Online
            </span>
        </div>

    </div>

    <div
        class="card border-0 shadow-sm mb-4">

        <div class="card-body text-center">

            <div
                id="clock"
                class="fw-bold fs-5 text-success">
            </div>

            <small
                id="date"
                class="text-muted">
            </small>

        </div>

    </div>

    <div class="mb-3">

        <small class="text-uppercase text-muted fw-bold">
            Navigation
        </small>

    </div>

    <div class="list-group list-group-flush">

        <a href="{{ route('dashboard') }}"
           class="list-group-item list-group-item-action border-0 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2 me-2"></i>
            Dashboard
        </a>

        <a href="{{ route('countries.index') }}"
           class="list-group-item list-group-item-action border-0 {{ request()->routeIs('countries.*') ? 'active' : '' }}">
            <i class="bi bi-globe2 me-2"></i>
            Countries
        </a>

        <a href="{{ route('watchlists.index') }}"
           class="list-group-item list-group-item-action border-0 {{ request()->routeIs('watchlists.*') ? 'active' : '' }}">
            <i class="bi bi-star-fill me-2"></i>
            Watchlist
        </a>

        <a href="{{ route('weather') }}"
           class="list-group-item list-group-item-action border-0 {{ request()->routeIs('weather') ? 'active' : '' }}">
            <i class="bi bi-cloud-sun me-2"></i>
            Weather Monitoring
        </a>

        <a href="{{ route('currency') }}"
           class="list-group-item list-group-item-action border-0 {{ request()->routeIs('currency') ? 'active' : '' }}">
            <i class="bi bi-currency-exchange me-2"></i>
            Currency Intelligence
        </a>

        <a href="{{ route('news') }}"
           class="list-group-item list-group-item-action border-0 {{ request()->routeIs('news') ? 'active' : '' }}">
            <i class="bi bi-newspaper me-2"></i>
            News Intelligence
        </a>

        <a href="{{ route('ports.index') }}"
           class="list-group-item list-group-item-action border-0 {{ request()->routeIs('ports.*') ? 'active' : '' }}">
            <i class="bi bi-truck me-2"></i>
            Port Management
        </a>

        <a href="{{ route('ports.map') }}"
           class="list-group-item list-group-item-action border-0 {{ request()->routeIs('ports.map') ? 'active' : '' }}">
            <i class="bi bi-geo-alt-fill me-2"></i>
            Port Map
        </a>

        <a href="{{ route('risk') }}"
           class="list-group-item list-group-item-action border-0 {{ request()->routeIs('risk') ? 'active' : '' }}">
            <i class="bi bi-shield-exclamation me-2"></i>
            Risk Analysis
        </a>

        <a href="{{ route('comparison') }}"
           class="list-group-item list-group-item-action border-0 {{ request()->routeIs('comparison') ? 'active' : '' }}">
            <i class="bi bi-arrow-left-right me-2"></i>
            Comparison
        </a>

        <a href="{{ route('analytics') }}"
           class="list-group-item list-group-item-action border-0 {{ request()->routeIs('analytics') ? 'active' : '' }}">
            <i class="bi bi-graph-up-arrow me-2"></i>
            Analytics
        </a>

        @if(auth()->user()->role === 'admin')

        <hr>

        <small class="text-uppercase text-muted fw-bold px-3 mb-2">
            Administration
        </small>

        <a href="{{ route('users.index') }}"
           class="list-group-item list-group-item-action border-0 {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <i class="bi bi-people-fill me-2"></i>
            User Management
        </a>

        <a href="{{ route('articles.index') }}"
           class="list-group-item list-group-item-action border-0 {{ request()->routeIs('articles.*') ? 'active' : '' }}">
            <i class="bi bi-journal-richtext me-2"></i>
            Articles Management
        </a>

        @endif

    </div>

</div>
```

</div>
