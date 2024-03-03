<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">
<head>
	<meta charset="utf-8">
	<title>{{ config('app.name', 'Laravel') }}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<link href="css/main.pro.css" rel="stylesheet">
	@include('layouts.head')

</head>
<body>
	<!-- BEGIN #app -->
	<div id="app" class="app app-footer-fixed">
        <div class="login">
            <div class="login-content">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <h1 class="text-center">Sign In</h1>
                    <div class="text-inverse text-opacity-50 text-center mb-4">
                        For your protection, please verify your identity.
                    </div>
                    <!-- Email Address -->
                    <div class="mb-3">
                        <label class="form-label" for="email" :value="__('Email')">Email Address <span class="text-danger">*</span></label>
                        <x-text-input id="email" class="form-control form-control-lg bg-inverse bg-opacity-5" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="mb-3">
                        <div class="d-flex">
                            <label class="form-label" for="password" :value="__('Password')">Password <span class="text-danger">*</span></label>
                            <a href="{{ route('password.request') }}" class="ms-auto text-inverse text-decoration-none text-opacity-50">Forgot password?</a>
                        </div>
                        <input type="password" class="form-control form-control-lg bg-inverse bg-opacity-5" id="password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" >
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <!-- Password -->
                    <div class="mb-3">
                        <div class="form-check">
                            <input  class="form-check-input" type="checkbox" name="remember" id="remember_me" type="checkbox">
                            <label  class="form-check-label" for="remember_me">{{ __('Remember me') }}</label>
                        </div>
                    </div>
                    <!-- Remember Me -->
                    <div class="text-center text-inverse text-opacity-50">
                        <div class="text-center text-inverse text-opacity-50">
                            <button type="submit" class="btn btn-outline-theme btn-lg d-block w-100 fw-500 mb-3 p-2">{{ __('Log in') }}</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
	<!-- END #app -->

    @include('layouts.footer')

</body>
</html>
