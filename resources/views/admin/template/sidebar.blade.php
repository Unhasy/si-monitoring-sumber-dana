<ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fa-solid fa-gauge"></i> &nbsp; Dashboard
        </a>
    </li>
    <li class="nav-group">
        <a class="nav-link nav-group-toggle" href="#">
            <i class="fa-solid fa-database"></i> &nbsp; Master Data</a>
        </a>
        <ul class="nav-group-items compact">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('master.user') }}">
                    <span class="nav-icon">
                        <span class="nav-icon-bullet"></span>
                    </span> 
                        User
                </a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link" href="{{ route('master.dasarhukum') }}">
                    <span class="nav-icon">
                        <span class="nav-icon-bullet"></span>
                    </span> 
                        Dasar Hukum
                </a>
            </li> --}}
            <li class="nav-item">
                <a class="nav-link" href="{{ route('master.nomenklatur') }}">
                    <span class="nav-icon">
                        <span class="nav-icon-bullet"></span>
                    </span> 
                        Nomenklatur
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('master.sumberdana') }}">
                    <span class="nav-icon">
                        <span class="nav-icon-bullet"></span>
                    </span> 
                        Sumber Dana
                </a>
            </li>
            
        </ul>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('realisasi') }}">
            <i class="fa-solid fa-pen-to-square"></i> &nbsp; Realisasi Sumber Dana
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('laporan') }}">
            <i class="fa-solid fa-chart-simple"></i> &nbsp; Laporan & Monitoring
        </a>
    </li>
</ul>