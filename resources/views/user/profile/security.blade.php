@extends('user.layouts.user')

@section('title','Security')


@push('style')

@endpush

@section('content')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">Security</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Profile Settings</a>
                                </li>
                                <li class="breadcrumb-item active">Security
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">

            </div>
        </div>
        <div class="content-body">
            <div class="row">
                <div class="col-12">
                    <ul class="nav nav-pills mb-2">
                        <!-- account -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('user.profile')}}">
                                <i data-feather="user" class="font-medium-3 me-50"></i>
                                <span class="fw-bold">Profile</span>
                            </a>
                        </li>
                        <!-- security -->
                        <li class="nav-item">
                            <a class="nav-link active" href="{{route('user.profile.security')}}">
                                <i data-feather="lock" class="font-medium-3 me-50"></i>
                                <span class="fw-bold">Security</span>
                            </a>
                        </li>
                    </ul>

                    <!-- security -->

                    <div class="card">
                        <div class="card-header border-bottom">
                            <h4 class="card-title">Change Info</h4>
                        </div>
                        <div  class="card-body py-2 my-25">
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
                        </div>
                        <div class="card-body pt-1">
                            @include('user.layouts.alerts.flash')
                            <!-- form -->
                            <form class="validate-form" action="{{route('user.profile.security.update')}}" method="POST">
                                @csrf
                                @method('patch')
                                <div class="row">
                                    <div class="col-12 col-sm-6 mb-1">
                                        <label class="form-label" for="username">Username </label>
                                        <div class="input-group form-password-toggle input-group-merge">
                                            <input type="text" class="form-control" id="" name="username" placeholder="Enter Username" value="{{$user->name}}" data-msg="Please current password" />
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 mb-1">
                                        <label class="form-label" for="email">Email </label>
                                        <div class="input-group form-password-toggle input-group-merge">
                                            <input type="email" class="form-control" id="" name="email" placeholder="email@email.com" value="{{$user->email}}" data-msg="Please current password" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-6 mb-1">
                                        <label class="form-label" for="account-new-password">New Password</label>
                                        <div class="input-group form-password-toggle input-group-merge">
                                            <input type="password" id="password" name="password" class="form-control" placeholder="Enter new password" />
                                            <div class="input-group-text cursor-pointer">
                                                <i data-feather="eye"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 mb-1">
                                        <label class="form-label" for="account-retype-new-password">Retype New Password</label>
                                        <div class="input-group form-password-toggle input-group-merge">
                                            <input type="password" class="form-control" id="account-retype-new-password" name="password_confirmation" placeholder="Confirm your new password" />
                                            <div class="input-group-text cursor-pointer"><i data-feather="eye"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <p class="fw-bolder">Password requirements:</p>
                                        <ul class="ps-1 ms-25">
                                            <li class="mb-50">Minimum 8 characters long - the more, the better</li>
                                            <li class="mb-50">At least one lowercase character</li>
                                            <li>At least one number, symbol, or whitespace character</li>
                                        </ul>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary me-1 mt-1">Save changes</button>
                                        <button type="reset" class="btn btn-outline-secondary mt-1">Discard</button>
                                    </div>
                                </div>
                            </form>
                            <!--/ form -->
                        </div>
                    </div>
                    <!--/ security -->
                </div>
            </div>

        </div>
    </div>
</div>
@endsection



@push('script')
<script src="{{asset('app-assets/js/scripts/pages/page-account-settings-security.js')}}"></script>
@endpush

