<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="/fontawesome-free-6.4.0-web/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>
<style>
    .input-group-addon {
        background-color: #fff;
        padding: 8px;
    }

    .input-group-addon i {
        color: #888;
    }
</style>

<body class="d-flex justify-content-center position-relative">
    <?php
    use App\Models\Notice;
    ?>
    @yield('alert')
    @if (session('success'))
        <div aria-live="polite" aria-atomic="true" class="position-absolute w-100">
            <!-- Position it: -->
            <!-- - `.toast-container` for spacing between toasts -->
            <!-- - `top-0` & `end-0` to position the toasts in the upper right corner -->
            <!-- - `.p-3` to prevent the toasts from sticking to the edge of the container  -->
            <div class="toast-container top-0 end-0 p-3">

                <!-- Then put toasts within -->
                <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true" data-aos="fade-left">
                    <div class="toast-header">
                        <i class="fa-solid fa-circle-check rounded me-2" style="color: #13C39C;"></i>
                        <strong class="me-auto">Success</strong>
                        <small class="text-muted">just now</small>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if (session('cart_item_left'))
        <div aria-live="polite" aria-atomic="true" class="position-absolute w-100">
            <!-- Position it: -->
            <!-- - `.toast-container` for spacing between toasts -->
            <!-- - `top-0` & `end-0` to position the toasts in the upper right corner -->
            <!-- - `.p-3` to prevent the toasts from sticking to the edge of the container  -->
            <div class="toast-container top-0 end-0 p-3">

                <!-- Then put toasts within -->
                <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true" data-aos="fade-left">
                    <div class="toast-header">
                        <i class="fa-solid fa-circle-exclamation me-2" style="color: #e1da0e;"></i>
                        <strong class="me-auto">Sorry</strong>
                        <small class="text-muted">just now</small>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        {{ session('cart_item_left') }}
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if (session('sold_out') || session('item_left'))
        <div aria-live="polite" aria-atomic="true" class="position-absolute w-100">
            <div style="height: 100vh;"
                class="toast-container d-flex justify-content-center align-items-center w-100 bg-black-50"
                data-aos="flip-right">
                <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true"
                    data-bs-backdrop="static" tabindex="-1" id="staticBackdrop" aria-labelledby="staticBackdropLabel">
                    <div class="toast-body py-5">
                        <div class="w-100  text-center">
                            <i class="fa-solid fa-face-sad-tear card-img-top"
                                style="font-size: 6rem; color: #FFDE6E;"></i>
                            <div class="card-body">
                                <h5 class="card-title fs-2 my-2">Sorry</h5>
                                <p class="card-text">
                                <p class="mb-0">
                                    @if (session('sold_out'))
                                        {{ session('sold_out') }}
                                    @endif
                                    @if (session('item_left'))
                                        {{ session('item_left') }}
                                    @endif
                                </p>
                                </p>
                                <button class="btn btn-primary rounded-pill col-11" aria-label="Close"
                                    data-bs-dismiss="toast">Ok</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if (session('seccess_order'))
        <div aria-live="polite" aria-atomic="true" class="position-absolute w-100">
            <div style="height: 100vh;"
                class="toast-container d-flex justify-content-center align-items-center w-100 bg-black-50"
                data-aos="flip-right">
                <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true"
                    data-bs-backdrop="static" tabindex="-1" id="staticBackdrop" aria-labelledby="staticBackdropLabel">
                    <div class="toast-body py-5">
                        <div class="w-100  text-center">
                            <i class="fa-solid fa-circle-check card-img-top"
                                style="font-size: 6rem; color: #13C39C;"></i>
                            <div class="card-body">
                                <h5 class="card-title fs-2 my-2">Success</h5>
                                <p class="card-text">
                                <p class="mb-0">
                                    {{ session('seccess_order') }}
                                </p>
                                </p>
                                <button class="btn btn-primary rounded-pill col-11" aria-label="Close"
                                    data-bs-dismiss="toast">Done</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- <div class="" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div> --}}
    <div class="container-desktop w-100">
        <div class="row m-0 p-0">
            <aside class="col-lg-2 col-12 py-lg-3 pt-3 p-0 d-flex justify-content-center align-items-center">
                <nav id="nav" class="p-lg-3 d-flex align-items-center justify-content-center">
                    <ul
                        class="list-unstyled w-100 py-lg-5 d-flex flex-lg-column flex-row justify-content-between px-4 px-lg-0">
                        <li class="mb-lg-5">
                            <a href="/" class="text-decoration-none">
                                <i class="fa-solid fa-house" id="nav_icon"></i>
                            </a>
                        </li>
                        <li class="mb-lg-5">
                            <a href="/cart" class="text-decoration-none">
                                <i class="fa-solid fa-cart-shopping" id="nav_icon"
                                    style="color: rgba(71, 71, 71, 1)"></i>
                            </a>
                        </li>
                        <li class="mb-lg-5 text-center">
                            <a href="/profile" class="text-decoration-none">
                                <i class="fa-solid fa-user" id="nav_icon"></i>
                            </a>
                        </li>
                        <li class="mb-lg-5 text-center">
                            <a href="/notice" class="text-decoration-none">
                                @if (Auth::check())
                                    @php
                                        $user = Auth::user();
                                        $notices_check = $user->notices()->where('is_checked', 0)->latest()->get();
                                    @endphp
                                    @if ($notices_check->count() == 0)
                                        <i class="fa-solid fa-bell" id="nav_icon"
                                            style="color: rgba(71, 71, 71, 1)"></i>
                                    @else
                                        <i class="fa-solid fa-bell fa-shake position-relative" id="nav_icon"
                                            style="color: rgba(71, 71, 71, 1)">
                                            <span style="font-size: 10px"
                                                class="position-absolute px-2 py-1 top-0 start-75 translate-middle badge rounded-pill bg-danger">
                                                {{ $notices_check->count() }}
                                                <span class="visually-hidden">.</span>
                                            </span>
                                        </i>
                                    @endif
                                @else
                                    <i class="fa-solid fa-bell" id="nav_icon"
                                        style="color: rgba(71, 71, 71, 1)"></i>
                                @endif
                            </a>
                        </li>
                        <li class="">
                            @if (Auth::user())
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>

                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();"
                                        class="">
                                        <i class="fa-solid fa-right-from-bracket" id="nav_icon"></i>
                                    </a>
                                </div>
                            @else
                                <a href="/login" class="text-decoration-none">
                                    <i class="fa-solid fa-right-to-bracket" id="nav_icon"></i>
                                </a>
                            @endif

                        </li>
                    </ul>
                </nav>
            </aside>
            <main class="col-lg-10 py-lg-4 pt-0 main px-lg-2 px-0" id="main">
                @yield('btn')
                @yield('main')
            </main>
        </div>
    </div>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        AOS.init();
    </script>
    @yield('script')

</body>

</html>