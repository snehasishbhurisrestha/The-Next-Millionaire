{{-- <header>
    <nav class="navbar  navbar-light fixed-top" id="mainNavbar">
        <div class="container d-flex justify-content-center ">
            <div class="col-lg-12 text-center justify-content-center" id="navbarNav">
                <div class="navbar-brand2" data-aos="fade-up"> <a class="navbar-brand" href="{{ route('home') }}"><img
                            src="{{ asset('assets/site-assets/images/IMG_6469.png') }}" alt="" height="40"></a></div>
            </div>
        </div>
    </nav>
</header> --}}

<header>
    <nav class="navbar navbar-light fixed-top" id="mainNavbar">
        <div class="container d-flex justify-content-between align-items-center">

            <!-- Left (optional menu) -->
            {{-- <div class="d-flex align-items-center">
                <!-- Add menu links here if needed -->
            </div> --}}

            <!-- Center: Logo -->
            <div class="text-center">
                <a class="navbar-brand" href="{{ route('home') }}" style="margin-top:-30px">
                    <img src="{{ asset('assets/site-assets/images/IMG_64610.png') }}" alt="Logo" height="40">
                </a>
            </div>

            <!-- Right: User Actions -->
            <div class="d-flex align-items-center">

                @guest
                    <a href="{{ route('login') }}" 
                       class="btn btn-outline-light d-flex align-items-center mt-lg-0">
                        <i class="fa fa-user me-2"></i> Login
                    </a>
                @else
                    <div class="dropdown">
                        <a href="#" 
                           class="btn btn-outline-light dropdown-toggle d-flex align-items-center mt-lg-0" 
                           id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="max-width:170px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                            <i class="fa fa-user me-2"></i> {{ Auth::user()->first_name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fa-solid fa-gauge me-2"></i>Dashboard</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" style="padding: 0;box-shadow: unset;">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endguest

            </div>
        </div>
    </nav>
</header>
