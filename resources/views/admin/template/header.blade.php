<ul class="header-nav">
    <li class="nav-item dropdown"><a class="nav-link py-0 pe-0" data-coreui-toggle="dropdown"
            href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <div class="avatar avatar-md">
                <i class="fa-solid fa-user"></i>
            </div>
        </a>
        <div class="dropdown-menu dropdown-menu-end pt-0">
            <div class="dropdown-header bg-body-tertiary text-body-secondary fw-semibold my-2">
                <div class="fw-semibold">{{ auth()->user()->name }}</div>
            </div>
            <a class="dropdown-item" href="#">
                <i class="fa-solid fa-person"></i> &nbsp;&nbsp; Profil
            </a>  

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="dropdown-item" type="submit"><i class="fa-solid fa-arrow-right-from-bracket"></i> &nbsp; Logout</button>
            </form>
        </div>
    </li>
</ul>