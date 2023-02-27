@extends('supplier.layouts.supplier')

@section('title', 'View User')

@section('style')


@endsection



@section('content')

<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">User</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('supplier.dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{route('supplier.user.index')}}"> Users</a>
                                </li>
                                <li class="breadcrumb-item active"> View
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
                <div class="mb-1 breadcrumb-right">

                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="row">
                <div class="col-12">
                    <ul class="nav nav-pills mb-2">
                        <!-- account -->

                        <!-- security -->

                        <!-- billing and plans -->


                        <!-- connection -->

                        <!-- notification -->

                    </ul>

                    <!-- profile -->
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h4 class="card-title">Profile Details</h4>
                        </div>
                        <div class="card-body py-2 my-25">
                            <!-- header section -->
                            <div class="d-flex">
                                <a href="#" class="me-25">
                                    <img src="{{asset('assets/profile_images/' .$supplier->photo)}}" id="account-upload-img" class="uploadedAvatar rounded me-50" alt="profile image" height="100" width="100" />
                                </a>
                                <!-- upload and reset button -->

                                <!--/ upload and reset button -->
                            </div>
                            <!--/ header section -->

                            <!-- form -->
                            <form class="validate-form mt-2 pt-50">
                                <div class="row">
                                    <div class="col-12 col-sm-6 mb-1">
                                        <h5> First Name : </h5>
                                        <span> {{$supplier->first_name}}</span>
                                    </div>
                                    <div class="col-12 col-sm-6 mb-1">
                                        <h5> Last Name : </h5>
                                        <span> {{$supplier->first_name}}</span>
                                    </div>
                                    <div class="col-12 col-sm-6 mb-1">
                                        <h5> Email : </h5>
                                        <span> {{$supplier->email}}</span>
                                    </div>
                                    <div class="col-12 col-sm-6 mb-1">
                                        <h5> Username : </h5>
                                        <span> {{$supplier->name}}</span>
                                    </div>

                                    {{-- <div class="col-12 col-sm-6 mb-1">
                                        <h5> Mobile : </h5>
                                        <span> {{$supplier->mobile}}</span>
                                    </div> --}}

                                    <div class="col-12 col-sm-6 mb-1">
                                        <h5> Company : </h5>
                                        <span> {{$supplier->company->company_name}}</span>
                                    </div>
                                    <div class="col-12 col-sm-6 mb-1">
                                        <h5> Role : </h5>
                                        <span> {{$supplier->role->name}}</span>
                                    </div>
                                </div>
                            </form>
                            <!--/ form -->
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>




@endsection




@section('scripts')


@endsection
