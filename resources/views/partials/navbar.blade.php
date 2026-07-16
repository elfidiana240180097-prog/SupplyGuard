<nav class="navbar navbar-expand-lg navbar-dark bg-success shadow">

    <div class="container-fluid">

        <a class="navbar-brand d-flex align-items-center" href="#">

            <img src="{{ asset('images/logo.png') }}"
                 width="45"
                 class="me-2">

            <div>

                <div class="fw-bold">
                    SupplyGuard
                </div>

                <small style="font-size:11px;">
                    Global Supply Chain Risk Intelligence
                </small>

            </div>

        </a>

        @auth

        <div class="dropdown">

            <button
                class="btn btn-success dropdown-toggle"
                type="button"
                data-bs-toggle="dropdown">

                <i class="bi bi-person-circle me-1"></i>

                {{ auth()->user()->name }}

                <span class="badge bg-light text-dark ms-1">

                    {{ ucfirst(auth()->user()->role) }}

                </span>

            </button>

            <ul class="dropdown-menu dropdown-menu-end">

                <li>

                    <a class="dropdown-item"
                       href="{{ route('profile.edit') }}">

                        <i class="bi bi-person"></i>
                        Profile

                    </a>

                </li>

                <li>
                    <hr class="dropdown-divider">
                </li>

                <li>

                    <form
                        action="{{ route('logout') }}"
                        method="POST">

                        @csrf

                        <button
                            type="submit"
                            class="dropdown-item text-danger">

                            <i class="bi bi-box-arrow-right"></i>
                            Logout

                        </button>

                    </form>

                </li>

            </ul>

        </div>

        @endauth

    </div>

</nav>