<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ env('APP_NAME' )}} - @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/user-admin-assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/user-admin-assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
    
    <!-- Toast message -->
    <link href="{{ asset('assets/admin-assets/plugins/toast/toastr.css') }}" rel="stylesheet" type="text/css" />
    <!-- Toast message -->

    @vite(['resources/js/app.js'])
    
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://unpkg.com/laravel-echo/dist/echo.iife.js"></script>


    <style>
        .logo-img{
            width: 100%;
            max-width: 140px;   /* adjust as per sidebar */
            height: auto;
            object-fit: contain;
        }

        .bg-gradient-primary {
            background-color: #000000;
            background-image: linear-gradient(148deg, #000000 10%, #d4af37 100%);
            background-size: cover;
        }
        .topbar{
            position: relative;
        }

        .logo-center{
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        .logo-img{
            height: 42px;      /* adjust size as needed */
            object-fit: contain;
        }

        .btn-dark{
            background:#000000 !important;
            border-color:#000000 !important;
            color:#fff !important;
        }
        .btn-dark:hover{
            background:#111 !important;
            border-color:#111 !important;
        }

    </style>
    
    <style>
        /* Sticky Support Button */
        .support-fab {
            position: fixed;
            bottom: 25px;
            right: 25px;
            width: 60px;
            height: 60px;
            background: linear-gradient(148deg, #000000 10%, #d4af37 100%);
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.35);
            z-index: 9999;
            animation: pulse 2s infinite;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        /* Hover effect */
        .support-fab:hover {
            transform: scale(1.1) rotate(8deg);
            color: #fff;
        }

        /* Pulse Animation */
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(212,175,55, 0.6);
            }
            70% {
                box-shadow: 0 0 0 15px rgba(212,175,55, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(212,175,55, 0);
            }
        }

    </style>
    
    @yield('style')
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('layouts.user-dash-include.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('layouts.user-dash-include.topbar')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid p-2" style="background:linear-gradient(162deg, #000000 10%, #d4af37 100%); height:100%"> <!-- linear-gradient(185deg, #8b8678, #74601E, black) -->

                    @yield('content')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer" style="background-color: #000000;">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright © 2025 <a href="{{ route('home') }}" style="color: #8f7625;">{{ config('app.name', 'Laravel') }}</a>.</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sticky Support Button -->
    <a href="https://wa.me/+917980395623" class="support-fab" title="Support">
        <i class="fas fa-headset"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets/user-admin-assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/user-admin-assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets/user-admin-assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets/user-admin-assets/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('assets/user-admin-assets/vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('assets/user-admin-assets/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('assets/user-admin-assets/js/demo/chart-pie-demo.js') }}"></script>
    
    <!-- toast message -->
    <script src="{{ asset('assets/admin-assets/plugins/toast/toastr.js') }}"></script>
    <script src="{{ asset('assets/admin-assets/js/toastr.init.js') }}"></script>
    <!-- toast message -->
    @include('layouts._massages')

    <script>
        function toggleSidebarForDevice(){
            if ($(window).width() < 992){
                $("body#page-top").addClass("sidebar-toggled");
                $("ul#accordionSidebar").addClass("toggled");
            } else {
                $("body#page-top").removeClass("sidebar-toggled");
                $("ul#accordionSidebar").removeClass("toggled");
            }
        }

        $(document).ready(toggleSidebarForDevice);
        $(window).resize(toggleSidebarForDevice);
    </script>

    <!-- Page level plugins -->
    <script src="{{ asset('assets/user-admin-assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/user-admin-assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('assets/user-admin-assets/js/demo/datatables-demo.js') }}"></script>
    
    <script>
        console.log('Init Echo script loaded');
        
        window.Pusher = Pusher;
        
        /**
         * IMPORTANT:
         * In CDN (IIFE) mode → Echo constructor is at `window.Echo.default`
         */
        const EchoConstructor = window.Echo?.default || window.Echo;
        
        window.echoInstance = new EchoConstructor({
            broadcaster: 'pusher',
            key: "{{ config('broadcasting.connections.pusher.key') }}",
            cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
            forceTLS: true,
            authEndpoint: '/broadcasting/auth',
            auth: {
                headers: {
                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute('content')
                }
            }
        });
        
        console.log('Echo instance created ✅', window.echoInstance);
    </script>


    @yield('script')
</body>

</html>