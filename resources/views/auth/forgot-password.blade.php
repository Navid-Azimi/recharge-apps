<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">
<head>
	<meta charset="utf-8">
	<title>{{ config('app.name', 'Laravel') }}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

	@include('layouts.head')

</head>
<body>
	<!-- BEGIN #app -->
	<div id="app" class="app app-footer-fixed">
        <div class="login">
            <div class="login-content">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="my-3">
                        <a href="/login"><i class="fa fa-arrow-left"></i> Back</a>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="email" :value="__('Email')">Email Address <span class="text-danger">*</span></label>
                        <x-text-input id="email" class="form-control form-control-lg bg-inverse bg-opacity-5" type="email" name="email" :value="old('email')" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button>
                            {{ __('Email Password Reset Link') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
	<!-- END #app -->

    @include('layouts.footer')

</body>
</html>
