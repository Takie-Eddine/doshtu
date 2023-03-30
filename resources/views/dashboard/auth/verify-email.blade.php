@extends('dashboard.auth.layouts.auth_layouts')

@section('title','Verify Email')


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
                    <!-- verify email basic -->
                    <div class="card mb-0">
                        <div class="card-body">
                            <a href="" class="brand-logo">
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
                                </svg>
                                <h2 class="brand-text text-primary ms-1">{{config('app.name')}}</h2> --}}
                                <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1086.75 533">
                                    <defs>
                                        <style>.cls-1{fill:#fff;}.cls-2{font-size:89.77px;fill:#0e1530;font-family:Lato-Black, Lato;font-weight:800;}.cls-3{fill:#f50c44;}</style>
                                    </defs>
                                    <rect class="cls-1" width="1086.75" height="533"/>
                                    <text class="cls-2" transform="translate(432.85 299.87)">DOSHTU</text>
                                    <path class="cls-3" d="M404.66,225.65l-62-35.78a13.77,13.77,0,0,0-13.77,0l-62,35.78a13.77,13.77,0,0,0-6.88,11.93V295.4A13.77,13.77,0,0,0,267,307.32l62,35.78a13.77,13.77,0,0,0,13.77,0l62-35.78a13.77,13.77,0,0,0,6.9-11.92V237.58A13.77,13.77,0,0,0,404.66,225.65ZM377,277.49,351.33,292.3V262.75L317.21,243l24.6-15.41L377,247.94Z"/>
                                    <polygon class="cls-1" points="376.98 247.94 376.98 277.49 351.33 292.3 351.33 262.75 317.21 243.04 341.81 227.63 376.98 247.94"/>
                                </svg>
                            </a>

                            <h2 class="card-title fw-bolder mb-1">Verify your email ✉️</h2>
                            <p class="card-text mb-2">
                                We've sent a link to your email address: <span class="fw-bolder">{{env('MAIL_FROM_ADDRESS')}}</span> Please follow the
                                link inside to continue.
                            </p>

                            <form action="{{ route('admin.verification.send') }}" method="post">
                                @csrf

                                <button type="submit" class="btn btn-primary w-100">Resend Verification Email</button>

                            </form>

                            <br>
                            <form action="{{ route('admin.logout') }}" method="post">
                                @csrf

                                <button type="submit" class="btn btn-flat-dark waves-effect">Logout</button>

                            </form>


                        </div>
                    </div>
                    <!-- / verify email basic -->
                </div>
            </div>

        </div>
    </div>
</div>

@endsection



@push('script')

@endpush






















{{-- <x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('admin.verification.send') }}">
                @csrf

                <div>
                    <x-primary-button>
                        {{ __('Resend Verification Email') }}
                    </x-primary-button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout> --}}
