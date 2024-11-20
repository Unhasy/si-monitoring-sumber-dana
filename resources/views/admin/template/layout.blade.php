<!DOCTYPE html>
<html lang="en">

<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="SI MONITOR SUMBER DANA">
    <meta name="author" content="Unhasy TIM">
    <meta name="keyword" content="SIM">
    <title>SI MONITOR SUMBER DANA</title>
    <!-- Vendors styles-->
    <link rel="stylesheet" href="{{ asset('coreui/vendor/simplebar.css') }}">
    <!-- Main styles for this application-->
    <link href="{{ asset('coreui/css/coreui.css') }}" rel="stylesheet">
    <link href="{{ asset('coreui/fontawesome/css/fontawesome.css') }}" rel="stylesheet">
    <link href="{{ asset('coreui/fontawesome/css/brands.css') }}" rel="stylesheet">
    <link href="{{ asset('coreui/fontawesome/css/solid.css') }}" rel="stylesheet">
    <script src="{{ asset('coreui/js/vue.js') }}"></script>
    <script src="{{ asset('coreui/js/axios.min.js') }}"></script>
    <script src="{{ asset('coreui/js/highcharts.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .content-start{
            padding: 20px;
        }
        .modal {
          transition: opacity 0.15s linear;
          z-index: 1050; /* Pastikan modal berada di atas */
        }
        .modal.show {
          opacity: 1;
        }
        
        .modal-backdrop {
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          background-color: rgba(0, 0, 0, 0.8); /* Warna gelap */
          backdrop-filter: blur(5px); /* Efek blur */
          z-index: 1040; /* Di bawah modal */
        }
        .fade-enter-active, .fade-leave-active {
            transition: opacity 0.3s ease;
        }
        .fade-enter, .fade-leave-to {
            opacity: 0;
        }
    </style>
</head>

<body>
    <div id="app">
        <div class="sidebar sidebar-dark sidebar-fixed border-end" :class="sidebar_show ? '' : ' hide'" id="sidebar">
            <div class="sidebar-header border-bottom" style="justify-content:center!important">
                <div class="sidebar-brand">
                    <i class="fa-solid fa-money-check-dollar"></i> <b>SIM SUMBER DANA</b>
                </div>
            </div>
            {{-- sidebar --}}
            @include('admin.template.sidebar')
            {{-- end sidebar --}}
        </div>
        <div :style="sidebar_show ? 'padding-left:256px' : 'padding-left:0px'"
            class="wrapper d-flex flex-column min-vh-100">
            <header class="header header-sticky p-0">
                <div class="container-fluid border-bottom px-4">
                    <button class="header-toggler" type="button" @click="sidebar_show=!sidebar_show" style="margin-inline-start: -14px;">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    {{-- header --}}
                    @include('admin.template.header')
                    {{-- end header --}}
                </div>
            </header>
            <div class="body flex-grow-1">
                <div class="content-start">
                    @yield('content')
                </div>
            </div>
              {{-- footer --}}
              @include('admin.template.footer')
              {{-- end footer --}}
        </div>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('coreui/js/coreui.bundle.js') }}"></script>
    <script src="{{ asset('coreui/vendor/simplebar.min.js') }}"></script>
    <script>
        const header = document.querySelector('header.header');
        
        document.addEventListener('scroll', () => {
            if (header) {
                header.classList.toggle('shadow-sm', document.documentElement.scrollTop > 0);
            }
        });
        import Swal from 'sweetalert2'
    </script>
    @yield('scripts')
</body>

</html>
