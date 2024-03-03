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
                <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <h1 class="text-center">Sign Up</h1>
                        <p class="text-inverse text-opacity-50 text-center">One Admin ID is all you need to access all the Admin services.</p>
                        <div class="mb-3">
                            <label class="form-label" for="name" :value="__('Name')">Name <span class="text-danger">*</span></label>
                            <input id="name" class="form-control form-control-lg bg-inverse bg-opacity-5" type="text" name="name" :value="old('name')" required autofocus autocomplete="name">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <!-- Name -->
                        <div class="mb-3">
                            <label class="form-label" for="email" :value="__('Email')">Email Address <span class="text-danger">*</span></label>
                            <input id="email" class="form-control form-control-lg bg-inverse bg-opacity-5" type="email" name="email" :value="old('email')" required autocomplete="username">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <!-- Email Address -->

                        <div class="mb-3">
                            <label class="form-label" for="password" :value="__('Password')">Password <span class="text-danger">*</span></label>
                            <input class="form-control form-control-lg bg-inverse bg-opacity-5" 
                                            id="password" 
                                            type="password"
                                            name="password"
                                            required autocomplete="new-password">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <!-- Password -->
                        <div class="mb-3">
                            <label class="form-label" for="password_confirmation" :value="__('Confirm Password')">Confirm Password <span class="text-danger">*</span></label>
                            <input class="form-control form-control-lg bg-inverse bg-opacity-5" id="password_confirmation" class="block mt-1 w-full"
                                            type="password"
                                            name="password_confirmation" required autocomplete="new-password">
                        </div>
                        <!-- Confirm Password -->


                        <div class="flex items-center justify-end mt-4">
                            <div class="mb-3">
                                <x-primary-button class="btn btn-outline-theme btn-lg d-block w-100">
                                    {{ __('Register') }}
                                </x-primary-button>
                            </div>
                            <div class="text-inverse text-opacity-50 text-center">
                                Already have an Account? <a href="{{ route('login') }}">Log In</a>
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
