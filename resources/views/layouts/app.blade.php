<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'Kikwek') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('storage/uploads/KikWek.svg') }}" type="image/svg+xml">
    @include('layouts.submit_loader')
    @include('layouts.head')
</head>
    @php
     $balance = $balance ?? null;
    @endphp

<body>
    <!-- BEGIN #app -->
    <div id="app" class="app app-footer-fixed">
        <!-- BEGIN #header -->
        @include('layouts.header')
        <!-- END #header -->

        <!-- BEGIN #sidebar -->
        <div id="sidebar" class="app-sidebar">
            <!-- BEGIN scrollbar -->
            @include('layouts.sidebar', ['balance' => $balance])
            <!-- END scrollbar -->
        </div>
        <!-- END #sidebar -->

        <!-- BEGIN mobile-sidebar-backdrop -->
        <button class="app-sidebar-mobile-backdrop" data-toggle-target=".app"
            data-toggle-class="app-sidebar-mobile-toggled"></button>
        <!-- END mobile-sidebar-backdrop -->

        <!-- BEGIN #content -->
        <div id="content" class="app-content">
            @yield('content')
        </div>
        <!-- END #content -->

        <div id="footer" class="app-footer">
            &copy; 2023 KikWek All Right Reserved
        </div>

        <!-- BEGIN theme-panel -->
        @include('layouts.theme-panel')
        <!-- END theme-panel -->

        <!-- BEGIN btn-scroll-top -->
        <a href="#" data-toggle="scroll-to-top" class="btn-scroll-top fade"><i class="fa fa-arrow-up"></i></a>
        <!-- END btn-scroll-top -->
    </div>
    <!-- END #app -->

    @include('layouts.footer')
    <a href="{{ route('users-chat') }}" onclick="return false;">
        <div class="tawk-widget-icon btn-outline-theme active d-print-none" id="chat-button">
            <i class="fa fa-comments"></i>
        </div>
    </a>
</body>

</html>
