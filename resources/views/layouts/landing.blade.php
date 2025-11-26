<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMK Teratai Putih Global 4 - @yield('title')</title>
    <link rel="icon" href="{{ asset('assets/media/logos/tp4.png') }}" type="image/png">
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->

    <!--begin::Global Stylesheets Bundle-->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->


    @stack('styles')
</head>

<body id="kt_body" data-bs-spy="scroll" data-bs-target="#kt_landing_menu" data-bs-offset="200" class="bg-white position-relative d-flex flex-column min-vh-100">
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root flex-grow-1">
        @include('layouts.partials.landing-header')

        <!--begin::Mobile Sidebar (hanya aktif di mobile)-->
        @include('layouts.partials.landing-sidebar')
        <!--end::Mobile Sidebar-->

        <!--begin::Content-->
        <main class="flex-grow-1">
            @yield('content')
        </main>
        <!--end::Content-->
    </div>
    <!--end::Main-->

    @include('layouts.partials.landing-footer')

    <!--begin::Scrolltop-->
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <span class="svg-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="black" />
                <path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="black" />
            </svg>
        </span>
    </div>
    <!--end::Scrolltop-->
    <!--begin::Javascript-->
    <!--begin::Global Javascript Bundle-->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->

    <!--begin::Page Vendors Javascript-->
    <script src="{{ asset('assets/plugins/custom/fslightbox/fslightbox.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/typedjs/typedjs.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <!--end::Page Vendors Javascript-->

    <!--begin::Page Custom Javascript-->
    <script src="{{ asset('assets/js/custom/landing.js') }}"></script>
    <!-- pricing.js dihapus dari layout umum karena menyebabkan error saat elemen target tidak ada -->
    <!--end::Page Custom Javascript-->

    <!--begin::Safe Initialization-->
    <script>
        // Safe initialization untuk KTMenu - hanya init jika element ada
        document.addEventListener('DOMContentLoaded', function() {
            // Reinitialize KTMenu dengan error handling
            if (typeof KTMenu !== 'undefined') {
                try {
                    const menuElements = document.querySelectorAll('[data-kt-menu="true"]');
                    menuElements.forEach(function(element) {
                        if (element && !element.ktMenuInitialized) {
                            KTMenu.createInstances('[data-kt-menu="true"]');
                            element.ktMenuInitialized = true;
                        }
                    });
                } catch (e) {
                    // Silently catch menu initialization errors
                    console.log('Menu initialization handled');
                }
            }
        });
    </script>
    <!--end::Safe Initialization-->

    @stack('scripts')
    <!--end::Javascript-->
</body>

</html>