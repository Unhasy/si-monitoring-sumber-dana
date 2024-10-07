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
    <style>
        .content-start{
            padding: 20px;
        }
    </style>
</head>

<body>
    <div id="app">
        <div class="sidebar sidebar-dark sidebar-fixed border-end" :class="sidebar_show ? '' : ' hide'" id="sidebar">
            <div class="sidebar-header border-bottom">
                <div class="sidebar-brand">
                        SIM SUMBER DANA
                </div>
            </div>
            {{-- ini sidebar --}}
            <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
                <li class="nav-item">
                    <a class="nav-link" href="index.html">
                        <i class="fa-solid fa-gauge"></i> &nbsp; Dashboard
                    </a>
                </li>
                <li class="nav-group">
                    <a class="nav-link nav-group-toggle" href="#">
                        <i class="fa-solid fa-database"></i> &nbsp; Master Data</a>
                    </a>
                    <ul class="nav-group-items compact">
                        <li class="nav-item">
                            <a class="nav-link" href="base/accordion.html">
                                <span class="nav-icon">
                                    <span class="nav-icon-bullet"></span>
                                </span> 
                                    User
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="base/accordion.html">
                                <span class="nav-icon">
                                    <span class="nav-icon-bullet"></span>
                                </span> 
                                    Dasar Hukum
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="base/accordion.html">
                                <span class="nav-icon">
                                    <span class="nav-icon-bullet"></span>
                                </span> 
                                    Sub Kegiatan
                            </a>
                        </li>
                        
                    </ul>
                </li>
            </ul>
            {{-- ini end sidebar --}}
        </div>
        <div :style="sidebar_show ? 'padding-left:256px' : 'padding-left:0px'"
            class="wrapper d-flex flex-column min-vh-100">
            <header class="header header-sticky p-0">
                <div class="container-fluid border-bottom px-4">
                    <button class="header-toggler" type="button" @click="sidebar_show=!sidebar_show" style="margin-inline-start: -14px;">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <ul class="header-nav">
                        <li class="nav-item dropdown"><a class="nav-link py-0 pe-0" data-coreui-toggle="dropdown"
                                href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                <div class="avatar avatar-md">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end pt-0">
                                <div class="dropdown-header bg-body-tertiary text-body-secondary fw-semibold my-2">
                                    <div class="fw-semibold">Namaku</div>
                                </div>
                                <a class="dropdown-item" href="#">
                                    <i class="fa-solid fa-person"></i> &nbsp;&nbsp; Profil
                                </a>  
                                <a class="dropdown-item" href="#">
                                    <i class="fa-solid fa-arrow-right-from-bracket"></i> &nbsp; Logout
                                </a>  
                                
                            </div>
                        </li>
                    </ul>
                </div>
            </header>
            <div class="body flex-grow-1">
                <div class="content-start">
                    xxx
                </div>
            </div>
            <footer class="footer px-4">
                <div>&copy; 2024 . SIM SUMBER DANA</a></div>
            </footer>
        </div>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('coreui/js/coreui.bundle.js') }}"></script>
    <script src="{{ asset('coreui/vendor/simplebar.min.js') }}"></script>
    <script src="{{ asset('coreui/js/vue.js') }}"></script>
    <script>
        const header = document.querySelector('header.header');

        document.addEventListener('scroll', () => {
            if (header) {
                header.classList.toggle('shadow-sm', document.documentElement.scrollTop > 0);
            }
        });

        var app3 = new Vue({
            el: '#app',
            data: {
                sidebar_show: true
            },
            mounted: function () {

            }
        })

    </script>
</body>

</html>
