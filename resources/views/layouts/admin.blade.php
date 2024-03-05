<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/f0be33b496.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="/css/admin.css">
</head>

<body>
    <div aria-live="polite" aria-atomic="true" class="position-relative">
        <div class="toast-container top-0 end-0 p-3">
            <div id="toast" @if (session('success')) class="toast show" @endif class="toast"
                role="alert" aria-live="assertive" aria-atomic="true" data-aos="fade-left">
                <div class="toast-header">
                    <i class="fa-solid fa-circle-check rounded me-2" style="color: #13C39C;"></i>
                    <strong class="me-auto">Success</strong>
                    <small class="text-muted">just now</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    DONE
                </div>
            </div>
        </div>
    </div>
    <div aria-live="polite" aria-atomic="true" class="position-relative">
        <div class="toast-container top-0 end-0 p-3">
            <div id="toast" @if (session('error')) class="toast show" @endif class="toast"
                role="alert" aria-live="assertive" aria-atomic="true" data-aos="fade-left">
                <div class="toast-header">
                    <i class="fa-solid fa-circle-check rounded me-2" style="color: #c31313;"></i>
                    <strong class="me-auto">Error</strong>
                    <small class="text-muted">just now</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{session('error')}}
                </div>
            </div>
        </div>
    </div>
    <div class="row d-flex flex-lg-row flex-column g-0">
        <aside class="col-lg-2  px-3 d-flex flex-lg-column flex-row" style="background: #15C7FF;">
            <h1 class=" h4 text-white text-center mt-4 d-none d-lg-inline">
                <i class="fa-solid fa-lock" aria-hidden="true"></i>
                <span class=" ms-1">Admin</span>
            </h1>
            {{-- <div style="height: 1.8px;" class="bg-black rounded-pill d-none d-lg-inline"></div> --}}
            <div class="text-success w-100">
                <ul class="my-md-3 m-0 list-unstyled d-flex flex-lg-column flex-row justify-content-around w-100">
                    <li class="text-center text-lg-start p-2">
                        <a href="/admin" class="text-decoration-none text-white">
                            <i class="fas fa-home"></i>
                            <span class=" d-none d-lg-inline">Home</span>
                        </a>
                    </li>
                    <li class="text-center text-lg-start p-2">
                        <a href="/admin/orders" class="text-decoration-none text-white">
                            <i class="fa-solid fa-basket-shopping"></i>
                            <span class=" d-none d-lg-inline">Orders</span>
                        </a>
                    </li>
                    <li class="text-center text-lg-start p-2">
                        <a href="/admin/create" class="text-decoration-none text-white">
                            <i class="fa-solid fa-circle-plus"></i>
                            <span class=" d-none d-lg-inline">Create Item</span>
                        </a>
                    </li>
                    <li class="text-center text-lg-start p-2">
                        <a href="/admin/items" class="text-decoration-none text-white">
                            <i class="fa-solid fa-rectangle-list"></i>
                            <span class=" d-none d-lg-inline">Items</span>
                        </a>
                    </li>
                    <li class="text-center text-lg-start p-2">
                        <a href="/admin/users" class="text-decoration-none text-white">
                            <i class="fa-solid fa-users"></i>
                            <span class=" d-none d-lg-inline">Users</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>
        <main class="p-0 col-lg-10 col-12">
            <nav class="navbar bg-light shadow-sm border navbar-expand p-0">
                <ul class="navbar-nav ms-auto me-0">
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="/profile">Profile</a>
                            </li>
                            <li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>


                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                  document.getElementById('logout-form').submit();"
                                    class="text-decoration-none dropdown-item">
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <section class="shadow-sm border tab-content w-100" id="myTabContent">
                @yield('content')
            </section>
        </main>
    </div>
    @yield('links')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    @yield('script')
    <script>
        function Delete_item(id) {
            if (confirm("Are you sure?") == true) {
                var checkedItems = $('input[name="items[]"]:checked')
                    .map(function() {
                        return $(this).val();
                    })
                    .get();

                if (checkedItems.length === 0) {
                    alert('Please select items to delete.');
                    return;
                }

                axios.post('/delete/item', {
                        item_ids: checkedItems
                    })
                    .then(function(response) {
                        // Remove the deleted items from the table
                        checkedItems.forEach(function(itemId) {
                            $('#' + itemId).remove();
                        });
                        var toast = document.getElementById('toast');
                        toast.classList.add('show');
                    })
                    .catch(function(error) {
                        console.log(error);
                        alert('An error occurred while deleting the items.');
                    });
            }
        }
    </script>
</body>

</html>
