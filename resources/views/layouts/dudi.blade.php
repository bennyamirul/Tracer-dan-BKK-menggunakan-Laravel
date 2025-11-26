<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name', 'BKK & Tracer Study') }}</title>
    <link rel="icon" href="{{ asset('assets/media/logos/tp4.png') }}" type="image/png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />

    {{-- ApexCharts for Dashboard Charts --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.45.1/dist/apexcharts.min.js"></script>

</head>

<body id="kt_body" class=" header-fixed header-tablet-and-mobile-fixed aside-enabled aside-fixed">
    @include('layouts.partials.sidebar-dudi')
    <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
        @include('layouts.partials.header')
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            @yield('content')
        </div>
        @include('layouts.partials.footer')
    </div>
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <!-- {{-- <script src="{{ asset('assets/js/custom/widgets.js') }}"></script> --}} -->
    <!-- {{-- Disabled widgets.js karena menggunakan custom chart, mencegah konflik --}} -->
    <script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('assets/js/custom/modals/new-target.js') }}"></script>
    <script src="{{ asset('assets/js/custom/modals/upgrade-plan.js') }}"></script>
    <script src="{{ asset('assets/js/custom/modals/modal-form-handler.js') }}"></script>

    @stack('scripts')
</body>

</html>