@extends('user.layouts.user')

@section('title', 'Create User')


@push('style')
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/forms/select/select2.min.css')}}">
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
                        <h2 class="content-header-title float-start mb-0">User</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{route('user.user.index')}}">Users</a>
                                </li>
                                <li class="breadcrumb-item active"><a>Add</a>
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


            <!-- Basic multiple Column Form section start -->
            <section id="multiple-column-form">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">

                            </div>
                            <div class="card-body">
                                @include('user.layouts.alerts.flash')
                                <form class="form" action="{{route('user.user.store')}}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="first-name-column">Username</label>
                                                <input type="text" id="first-name-column" class="form-control" placeholder="Username" name="name" value="{{old('name')}}" />
                                            </div>
                                            @error('name')
                                                <span class="text-danger"> {{ $message }}</span>
                                            @enderror
                                        </div>
                                        {{-- <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="first-name-column">Last Name</label>
                                                <input type="text" id="first-name-column" class="form-control" placeholder="Last Name" name="last_name" value="{{old('last_name')}}" />
                                            </div>
                                                @error('last_name')
                                                    <span class="text-danger"> {{ $message }}</span>
                                                @enderror
                                        </div> --}}

                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="email-id-column">Email</label>
                                                <input type="email" id="email-id-column" class="form-control" name="email" placeholder="Email" value="{{old('email')}}"/>
                                            </div>
                                            @error('email')
                                                <span class="text-danger"> {{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="company-column">Password</label>
                                                <input type="password" id="password" class="form-control" name="password" placeholder="Password" />
                                            </div>
                                            @error('password')
                                                    <span class="text-danger"> {{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="company-column">Password Confirmation</label>
                                                <input type="password" id="" class="form-control" name="password_confirmation" placeholder="Confirm Password" />
                                            </div>
                                            @error('password')
                                                    <span class="text-danger"> {{ $message }}</span>
                                            @enderror
                                        </div>


                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="country-floating">Role</label>
                                                <select name="role_id" class="form-select" id="selectDefault">
                                                    @if ($roles && $roles->count()>0)
                                                        @foreach ($roles as $role)
                                                            <option value="{{$role->id}}">{{$role->name}}</option>
                                                        @endforeach
                                                    @endif

                                                </select>
                                            </div>
                                            @error('role_id')
                                                    <span class="text-danger"> {{ $message }}</span>
                                                @enderror
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="country-floating">Store</label>
                                                <select name="store[]" class="select2 form-select" id="select2-multiple" multiple>
                                                        @forelse ($stores as $store)
                                                            <option value="{{$store->id}}">{{$store->store_name}}</option>
                                                        @empty
                                                            <div>
                                                                <span>No store defined.</span>
                                                            </div>
                                                        @endforelse
                                                </select>
                                            </div>
                                            @error('store')
                                                    <span class="text-danger"> {{ $message }}</span>
                                                @enderror
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary me-1">Submit</button>
                                            <button type="reset" class="btn btn-outline-secondary">Reset</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Basic Floating Label Form section end -->

        </div>
    </div>
</div>



@endsection


@push('script')
<script src="{{asset('app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{asset('app-assets/js/scripts/forms/form-select2.js')}}"></script>
@endpush

