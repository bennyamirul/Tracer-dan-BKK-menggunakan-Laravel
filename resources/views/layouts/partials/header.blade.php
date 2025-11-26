<div id="kt_header" style="" class="header align-items-stretch">
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <div class="d-flex align-items-center d-lg-none ms-n2 me-3" title="Show aside menu">
            <div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px" id="kt_aside_mobile_toggle">
                <!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
                <span class="svg-icon svg-icon-2x mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="black" />
                        <path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="black" />
                    </svg>
                </span>
                <!--end::Svg Icon-->
            </div>
        </div>
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0 ms-2">
            <a href="{{ route('admin.dashboard') }}" class="d-lg-none">
                <img alt="Logo" src="{{ asset('assets/media/logos/tp4.png') }}" class="h-40px" />
            </a>
        </div>
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
            <!--begin::Navbar-->
            <div class="d-flex align-items-center" id="kt_header_nav">
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_header_nav'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <!--begin::Title-->
                    <h1 class="text-dark fw-bolder fs-1 my-1">Manajemen Data<span class="text-muted  fw-normal ps-2 fs-5"> - @yield('title')</span></h1>
                    <!--end::Title-->
                </div>
            </div>
            <!--end::Navbar-->
            <!--begin::User-->
            <div class="d-flex align-items-center ms-auto" id="kt_header_user_menu_toggle">
                <!--begin::Menu wrapper-->
                @php
                $userAvatar = Auth::user()->avatar
                ? asset('storage/' . Auth::user()->avatar)
                : asset('assets/media/avatars/300-1.jpg');
                @endphp
                <div class="cursor-pointer symbol symbol-30px symbol-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                    <img src="{{ $userAvatar }}" alt="user" style="object-fit: cover;" />
                </div>
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px" data-kt-menu="true">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <div class="menu-content d-flex align-items-center px-3">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-50px me-5">
                                <img alt="Avatar" src="{{ $userAvatar }}" style="object-fit: cover;" />
                            </div>
                            <!--end::Avatar-->
                            <!--begin::Username-->
                            <div class="d-flex flex-column">
                                <div class="fw-bolder d-flex align-items-center fs-5">
                                    {{ Auth::user()->nama ?? 'User' }}
                                </div>
                                <a href="#" class="fw-bold text-muted text-hover-primary fs-7">{{ Auth::user()->email ?? 'email@example.com' }}</a>
                            </div>
                            <!--end::Username-->
                        </div>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu separator-->
                    <div class="separator my-2"></div>
                    <!--end::Menu separator-->
                    <!--begin::Menu item - Profile-->
                    <div class="menu-item px-5">
                        <a href="{{ Auth::user()->role == 'admin_sekolah' ? route('admin.profile') : (Auth::user()->role == 'admin_dudi' ? route('admin_dudi.profile') : '#') }}" class="menu-link px-5"> <span class="menu-icon">
                                <i class="fa-solid fa-user fs-5"></i>
                            </span>
                            <span class="menu-title">Profil Saya</span>
                        </a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu separator-->
                    <div class="separator my-2"></div>
                    <!--end::Menu separator-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-5">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-light-danger w-100">
                                <i class="ki-duotone ki-exit-right fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Keluar
                            </button>
                        </form>
                    </div>
                    <!--end::Menu item-->
                </div>
            </div>
            <!--end::User-->
        </div>
    </div>
</div>