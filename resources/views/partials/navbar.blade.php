<nav class="navbar navbar-expand-lg member-navbar">

    <div class="container-fluid">

        <a class="navbar-brand d-flex align-items-center" href="#">

            <div class="logo-wrapper">

                <img src="{{ asset('images/logo.png') }}"
                     width="28">

            </div>

            <div>

                <div class="fw-bold fs-4">
                    SupplyGuard
                </div>

                <small>
                    Global Supply Chain Risk Intelligence
                </small>

            </div>

        </a>

        @auth

        <div class="d-flex align-items-center">

            <div class="text-end me-3 text-white">

                <div class="fw-semibold">
                    {{ auth()->user()->name }}
                </div>

                <small class="opacity-75">
                    {{ ucfirst(auth()->user()->role) }}
                </small>

            </div>

            <div class="dropdown">

                <button
                    class="btn btn-light rounded-pill px-4"
                    type="button"
                    data-bs-toggle="dropdown">

                    <i class="bi bi-person-circle me-1"></i>
                    Account

                </button>

                <ul class="dropdown-menu dropdown-menu-end border-0 shadow">

                    <li>
                        <a class="dropdown-item"
                           href="{{ route('profile.edit') }}">

                            <i class="bi bi-person me-2"></i>
                            Profile

                        </a>
                    </li>

                    <li><hr class="dropdown-divider"></li>

                    <li>

                        <form action="{{ route('logout') }}"
                              method="POST">

                            @csrf

                            <button
                                type="submit"
                                class="dropdown-item text-danger">

                                <i class="bi bi-box-arrow-right me-2"></i>
                                Logout

                            </button>

                        </form>

                    </li>

                </ul>

            </div>

        </div>

        @endauth

    </div>

</nav>

<style>

.member-navbar{

    background:linear-gradient(
        135deg,
        #198754,
        #20c997
    );

    padding:18px 24px;

    box-shadow:
    0 10px 30px rgba(0,0,0,.12);

}

.member-navbar .navbar-brand{

    color:white !important;

}

.member-navbar small{

    color:rgba(255,255,255,.8);

}

.logo-wrapper{

    width:52px;
    height:52px;

    border-radius:50%;

    background:white;

    display:flex;
    align-items:center;
    justify-content:center;

    margin-right:14px;

    box-shadow:
    0 8px 20px rgba(0,0,0,.15);

}

</style>