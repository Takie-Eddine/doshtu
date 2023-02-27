@extends('user.layouts.user')

@section('title', 'Store')



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
                        <h2 class="content-header-title float-start mb-0">User</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{route('user.stores.index')}}">Stores</a>
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
            <div class="row">
                <div class="col-12">
                    @include('user.layouts.alerts.flash')

                    <!-- profile -->

                    <div class="row">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title">Store Details</h4>
                            </div>
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
                            <div class="card-body py-2 my-25">
                                <!-- header section -->
                                <div class="d-flex">
                                <form class="validate-form mt-2 pt-50" action="{{route('user.stores.store')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <a href="#" class="me-25">
                                        <img src="{{asset('assets/images/logo/store.png')}}" id="account-upload-img" class="uploadedAvatar rounded me-50" alt="profile image" height="100" width="100" />
                                    </a>
                                    <!-- upload and reset button -->
                                    <div class="d-flex align-items-end mt-75 ms-1">
                                        <div>
                                            <label for="account-upload" class="btn btn-sm btn-primary mb-75 me-75">Upload</label>
                                            <input type="file" name="store_logo" id="account-upload" hidden accept="image/*" />
                                            @error('store_logo')
                                            <span class="text-danger"> {{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!--/ upload and reset button -->
                                </div>
                                <!--/ header section -->

                                <!-- form -->

                                    <div class="row">
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="store_name">Store Name</label>
                                            <input type="text" class="form-control" id="store_name" name="store_name" placeholder="Store Name" value="{{old('store_name')}}"  />
                                            @error('store_name')
                                            <span class="text-danger"> {{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="store_email">Store Email</label>
                                            <input type="email" class="form-control" id="store_email" name="store_email" placeholder="Store Email" value="{{old('store_email')}}" />
                                            @error('store_email')
                                            <span class="text-danger"> {{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="store_mobile">Store Mobile</label>
                                            <input type="text" class="form-control account-number-mask" id="store_mobile" name="store_mobile" placeholder="05385014651" value="{{old('store_mobile')}}" />
                                            @error('store_mobile')
                                            <span class="text-danger"> {{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="country">Country</label>
                                            <select name="country" id="country" class="select2 form-select" required>
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $country => $value)
                                                    <option value="{{$country}}" >{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountState">State</label>
                                            <input type="text" class="form-control" id="accountState" name="state" placeholder="State" value="{{old('state')}}"/>
                                            @error('state')
                                            <span class="text-danger"> {{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountState">City</label>
                                            <input type="text" class="form-control" id="accountState" name="city" placeholder="City" value="{{old('city')}}"/>
                                            @error('city')
                                            <span class="text-danger"> {{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountZipCode">Pin Code</label>
                                            <input type="text" class="form-control account-zip-code" id="accountZipCode" name="pincode" placeholder="Code" maxlength="6" value="{{old('pincode')}}"/>
                                            @error('pincode')
                                            <span class="text-danger"> {{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountAddress">Address</label>
                                            <input type="text" class="form-control" id="accountAddress" name="address" placeholder="Your Address" value="{{old('address')}}"/>
                                            @error('address')
                                            <span class="text-danger"> {{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary mt-1 me-1">Save changes</button>
                                            <button type="reset" class="btn btn-outline-secondary mt-1">Discard</button>
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
</div>


@endsection
