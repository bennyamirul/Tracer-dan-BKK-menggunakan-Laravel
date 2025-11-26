<!--begin::Mobile Sidebar Menu-->
<div id="kt_landing_menu_mobile"
    class="menu menu-column menu-gray-600 menu-state-bg-light-primary menu-hover-primary fw-semibold fs-6 w-225px py-4"
    data-kt-drawer="true"
    data-kt-drawer-name="landing-menu"
    data-kt-drawer-activate="{default: true, lg: false}"
    data-kt-drawer-overlay="true"
    data-kt-drawer-width="225px"
    data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_landing_menu_toggle"
    data-kt-menu="true">

    <!--begin::User mini card-->
    @auth
    <div class="menu-item px-4 pb-4">
        <div class="d-flex align-items-center p-3 bg-light rounded">
            <div class="symbol symbol-35px me-3">
                <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('assets/media/avatars/blank.png') }}" alt="avatar" />
            </div>
            <div class="flex-grow-1">
                <div class="fw-bold text-gray-800 text-capitalize">{{ auth()->user()->nama }}</div>
                <div class="text-muted fs-8 text-capitalize">{{ str_replace('_',' ', auth()->user()->role) }}</div>
            </div>
        </div>
    </div>
    @endauth
    <!--end::User mini card-->

    <!--begin::Menu item - Beranda-->
    <div class="menu-item">
        <a class="menu-link py-3 px-4 {{ request()->routeIs('landing') ? 'active' : '' }}"
            href="{{ route('landing') }}"
            data-kt-drawer-dismiss="true">
            <span class="menu-icon"><i class="fa-solid fa-house fs-5"></i></span>
            <span class="menu-title">Beranda</span>
        </a>
    </div>
    <!--end::Menu item-->

    <!--begin::Menu item - Lowongan Kerja-->
    <div class="menu-item">
        <a class="menu-link py-3 px-4 {{ request()->routeIs('lowongan*') ? 'active' : '' }}"
            href="{{ route('lowongan') }}"
            data-kt-drawer-dismiss="true">
            <span class="menu-icon"><i class="fa-solid fa-briefcase fs-5"></i></span>
            <span class="menu-title">Lowongan Kerja</span>
        </a>
    </div>
    <!--end::Menu item-->

    <!--begin::Menu item - Informasi (Accordion)-->
    <div class="menu-item menu-accordion"
        data-kt-menu-trigger="click"
        data-kt-menu-placement="right-start">
        <span class="menu-link py-3 px-4">
            <span class="menu-icon"><i class="fa-solid fa-circle-info fs-5"></i></span>
            <span class="menu-title">Informasi</span>
            <span class="menu-arrow"></span>
        </span>
        <div class="menu-sub menu-sub-accordion">
            @auth
            @if(in_array(auth()->user()->role, ['pelamar_alumni', 'admin_sekolah', 'admin_dudi']))
            <div class="menu-item">
                <a href="{{ route('tracer-alumni') }}"
                    class="menu-link py-2 px-6 {{ request()->routeIs('tracer-alumni*') ? 'active' : '' }}"
                    data-kt-drawer-dismiss="true">
                    <span class="menu-icon me-2">
                        <i class="fa-solid fa-graduation-cap fs-6"></i>
                    </span>
                    <span class="menu-title">Tracer Alumni</span>
                </a>
            </div>
            @endif
            @endauth
            <div class="menu-item">
                <a href="{{ route('perusahaan') }}"
                    class="menu-link py-2 px-6 {{ request()->routeIs('perusahaan*') ? 'active' : '' }}"
                    data-kt-drawer-dismiss="true">
                    <span class="menu-icon me-2">
                        <i class="fa-solid fa-building fs-6"></i>
                    </span>
                    <span class="menu-title">Perusahaan</span>
                </a>
            </div>
        </div>
    </div>
    <!--end::Menu item-->

    <!--begin::Section title-->
    <div class="menu-content px-4 pt-2 pb-1 text-muted text-uppercase fs-8">Akun</div>
    <!--end::Section title-->

    @guest
    <!--begin::Auth actions-->
    <div class="menu-item">
        <a class="menu-link py-3 px-4" href="{{ route('login') }}" data-kt-drawer-dismiss="true">
            <span class="menu-icon"><i class="fa-solid fa-right-to-bracket fs-5"></i></span>
            <span class="menu-title">Masuk</span>
        </a>
    </div>
    <div class="menu-item">
        <a class="menu-link py-3 px-4" href="{{ route('register') }}" data-kt-drawer-dismiss="true">
            <span class="menu-icon"><i class="fa-regular fa-id-badge fs-5"></i></span>
            <span class="menu-title">Daftar</span>
        </a>
    </div>
    <!--end::Auth actions-->
    @else
    <!--begin::Logout-->
    <div class="menu-item">
        <form action="{{ route('logout') }}" method="POST" class="w-100">
            @csrf
            <button type="submit" class="menu-link w-100 py-3 px-4 btn btn-link text-start">
                <span class="menu-icon"><i class="fa-solid fa-arrow-right-from-bracket fs-5"></i></span>
                <span class="menu-title">Keluar</span>
            </button>
        </form>
    </div>
    <!--end::Logout-->
    @endguest

    <!--begin::Footer note-->
    <div class="menu-content px-4 pt-4">
        <div class="text-muted fs-8">BKK & Tracer Study</div>
    </div>
    <!--end::Footer note-->

</div>
<!--end::Mobile Sidebar Menu-->