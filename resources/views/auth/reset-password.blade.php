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
    <div id="app" class="app app-footer-fixed">
        <div class="login">
            <div class="login-content">
                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <!-- Password Reset Token -->
                    <div class="mb-3">
                        <input type="hidden" name="token" class="form-control form-control-lg bg-inverse bg-opacity-5" value="{{ $request->route('token') }}">
                    </div>

                    <!-- Email Address -->
                    <div class="mb-3">
                        <label class="form-label" for="email" :value="__('Email')">Email Address </label>
                        <x-text-input id="email" class="form-control form-control-lg bg-inverse bg-opacity-5" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label class="form-label" for="password" :value="__('Password')">Password </label>
                        <x-text-input id="password" class="form-control form-control-lg bg-inverse bg-opacity-5" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <label class="form-label" for="password_confirmation" :value="__('Confirm_Password')">Confirm Password </label>
                        <x-text-input id="password_confirmation" class="form-control form-control-lg bg-inverse bg-opacity-5"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="btn btn-outline-theme btn-lg d-block w-100">
                            {{ __('Reset Password') }}
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
