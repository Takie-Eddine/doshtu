@extends('auth.layouts.auth_layouts')

@section('title','Register')


@push('style')

@endpush

@section('content')

<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="auth-wrapper auth-basic px-2">
                <div class="auth-inner my-2">
                    <!-- Register basic -->
                    <div class="card mb-0">
                        <div class="card-body">
                            <a href="" class="brand-logo">
                                <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1086.75 533">
                                    <defs>
                                        <style>.cls-1{fill:#fff;}.cls-2{font-size:89.77px;fill:#0e1530;font-family:Lato-Black, Lato;font-weight:800;}.cls-3{fill:#f50c44;}</style>
                                    </defs>
                                    <rect class="cls-1" width="1086.75" height="533"/>
                                    <text class="cls-2" transform="translate(432.85 299.87)">DOSHTU</text>
                                    <path class="cls-3" d="M404.66,225.65l-62-35.78a13.77,13.77,0,0,0-13.77,0l-62,35.78a13.77,13.77,0,0,0-6.88,11.93V295.4A13.77,13.77,0,0,0,267,307.32l62,35.78a13.77,13.77,0,0,0,13.77,0l62-35.78a13.77,13.77,0,0,0,6.9-11.92V237.58A13.77,13.77,0,0,0,404.66,225.65ZM377,277.49,351.33,292.3V262.75L317.21,243l24.6-15.41L377,247.94Z"/>
                                    <polygon class="cls-1" points="376.98 247.94 376.98 277.49 351.33 292.3 351.33 262.75 317.21 243.04 341.81 227.63 376.98 247.94"/>
                                </svg>
                                {{-- <svg viewbox="0 0 139 95" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="28">
                                    <defs>
                                        <lineargradient id="linearGradient-1" x1="100%" y1="10.5120544%" x2="50%" y2="89.4879456%">
                                            <stop stop-color="#000000" offset="0%"></stop>
                                            <stop stop-color="#FFFFFF" offset="100%"></stop>
                                        </lineargradient>
                                        <lineargradient id="linearGradient-2" x1="64.0437835%" y1="46.3276743%" x2="37.373316%" y2="100%">
                                            <stop stop-color="#EEEEEE" stop-opacity="0" offset="0%"></stop>
                                            <stop stop-color="#FFFFFF" offset="100%"></stop>
                                        </lineargradient>
                                    </defs>
                                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g id="Artboard" transform="translate(-400.000000, -178.000000)">
                                            <g id="Group" transform="translate(400.000000, 178.000000)">
                                                <path class="text-primary" id="Path" d="M-5.68434189e-14,2.84217094e-14 L39.1816085,2.84217094e-14 L69.3453773,32.2519224 L101.428699,2.84217094e-14 L138.784583,2.84217094e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L6.71554594,44.4188507 C2.46876683,39.9813776 0.345377275,35.1089553 0.345377275,29.8015838 C0.345377275,24.4942122 0.230251516,14.560351 -5.68434189e-14,2.84217094e-14 Z" style="fill: currentColor"></path>
                                                <path id="Path1" d="M69.3453773,32.2519224 L101.428699,1.42108547e-14 L138.784583,1.42108547e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L32.8435758,70.5039241 L69.3453773,32.2519224 Z" fill="url(#linearGradient-1)" opacity="0.2"></path>
                                                <polygon id="Path-2" fill="#000000" opacity="0.049999997" points="69.3922914 32.4202615 32.8435758 70.5039241 54.0490008 16.1851325"></polygon>
                                                <polygon id="Path-21" fill="#000000" opacity="0.099999994" points="69.3922914 32.4202615 32.8435758 70.5039241 58.3683556 20.7402338"></polygon>
                                                <polygon id="Path-3" fill="url(#linearGradient-2)" opacity="0.099999994" points="101.428699 0 83.0667527 94.1480575 130.378721 47.0740288"></polygon>
                                            </g>
                                        </g>
                                    </g>
                                </svg> --}}
                                {{-- <h2 class="brand-text text-primary ms-1">{{config('app.name')}}</h2> --}}
                            </a>

                            <h4 class="card-title mb-1">Adventure starts here 🚀</h4>
                            <p class="card-text mb-2">Make your app management easy and fun!</p>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <h5>Error Occured!</h5>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{$error}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            <form class="auth-register-form mt-2" action="{{ route('register') }}" method="POST">
                                @csrf
                                <div class="mb-1">
                                    <label for="register-username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="register-username" name="name" value="{{old('name')}}" placeholder="johndoe" aria-describedby="register-username" tabindex="1" autofocus />
                                </div>
                                <div class="mb-1">
                                    <label for="register-email" class="form-label">Email</label>
                                    <input type="text" class="form-control" id="register-email" name="email" value="{{old('email')}}" placeholder="john@example.com" aria-describedby="register-email" tabindex="2" />
                                </div>

                                <div class="mb-1">
                                    <label for="register-password" class="form-label">Password</label>

                                    <div class="input-group input-group-merge form-password-toggle">
                                        <input type="password" class="form-control form-control-merge" id="password" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="register-password" tabindex="3" />
                                        <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                    </div>
                                </div>

                                <div class="mb-1">
                                    <label for="register-password" class="form-label">Password Confirmation</label>

                                    <div class="input-group input-group-merge form-password-toggle">
                                        <input type="password" class="form-control form-control-merge" id="register-password" name="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="register-password" tabindex="3" />
                                        <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                    </div>
                                </div>
                                <div class="mb-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="agree" id="register-privacy-policy" tabindex="4" />
                                        <label class="form-check-label" for="register-privacy-policy">
                                            I agree to <a href="http://doshtu.com/policies/">privacy policy & terms</a>
                                        </label>
                                    </div>
                                </div>
                                <button class="btn btn-primary w-100" tabindex="5">Sign up</button>
                            </form>

                            <p class="text-center mt-2">
                                <span>Already have an account?</span>
                                <a href="{{route('login')}}">
                                    <span>Sign in instead</span>
                                </a>
                            </p>

                            <div class="divider my-2">
                                <div class="divider-text">or</div>
                            </div>

                            <div class="auth-footer-btn d-flex justify-content-center">
                                <a href="#" class="btn btn-facebook">
                                    <i data-feather="facebook"></i>
                                </a>
                                <a href="#" class="btn btn-twitter white">
                                    <i data-feather="twitter"></i>
                                </a>
                                <a href="#" class="btn btn-google">
                                    <i data-feather="mail"></i>
                                </a>
                                <a href="#" class="btn btn-github">
                                    <i data-feather="github"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- /Register basic -->
                </div>
            </div>

        </div>
    </div>
</div>

@endsection



@push('script')

@endpush








{{-- <form method="POST" action="{{ route('admin.register') }}">
    @csrf

    <!-- Name -->
    <div>
        <x-input-label for="name" :value="__('Name')" />

        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />

        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <!-- Email Address -->
    <div class="mt-4">
        <x-input-label for="email" :value="__('Email')" />

        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />

        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- Password -->
    <div class="mt-4">
        <x-input-label for="password" :value="__('Password')" />

        <x-text-input id="password" class="block mt-1 w-full"
                        type="password"
                        name="password"
                        required autocomplete="new-password" />

        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- Confirm Password -->
    <div class="mt-4">
        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

        <x-text-input id="password_confirmation" class="block mt-1 w-full"
                        type="password"
                        name="password_confirmation" required />

        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>

    <div class="flex items-center justify-end mt-4">
        <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('admin.login') }}">
            {{ __('Already registered?') }}
        </a>

        <x-primary-button class="ml-4">
            {{ __('Register') }}
        </x-primary-button>
    </div>
</form> --}}
