<nav class="navbar navbar-expand-lg navbar-dark">

    <div class="container-fluid">

        <a class="navbar-brand d-flex align-items-center" href="#">

            <div class="bg-white rounded-circle d-flex align-items-center justify-content-center me-3 shadow"
                 style="width:48px;height:48px;">

                <img src="{{ asset('images/logo.png') }}"
                     width="28">

            </div>

            <div>

                <div class="fw-bold fs-5">
                    SupplyGuard
                </div>

                <small class="opacity-75">
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
                    class="btn btn-light rounded-pill px-3 shadow-sm"
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

                    <li>
                        <hr class="dropdown-divider">
                    </li>

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