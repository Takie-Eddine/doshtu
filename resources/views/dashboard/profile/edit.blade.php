@extends('dashboard.layouts.dashboard')

@section('title','Profile')


@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickers/pickadate/pickadate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/core/menu/menu-types/vertical-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/plugins/forms/pickers/form-flat-pickr.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/plugins/forms/pickers/form-pickadate.css')}}">
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
                        <h2 class="content-header-title float-start mb-0">Profile</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Profile Settings </a>
                                </li>
                                <li class="breadcrumb-item active"> Profile
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
                            <a class="nav-link active" href="{{route('admin.profile.update')}}">
                                <i data-feather="user" class="font-medium-3 me-50"></i>
                                <span class="fw-bold">Profile</span>
                            </a>
                        </li>
                        <!-- security -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('admin.profile.security')}}">
                                <i data-feather="lock" class="font-medium-3 me-50"></i>
                                <span class="fw-bold">Security</span>
                            </a>
                        </li>
                    </ul>

                    <!-- profile -->
                    <div class="card">
                        @include('dashboard.layouts.alerts.flash')
                        <div class="card-header border-bottom">
                            <h4 class="card-title">Profile Details</h4>
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

                        <div class="card-body py-2 my-25">
                            <!-- header section -->


                            <!--/ header section -->

                            <!-- form -->
                            <form class="validate-form mt-2 pt-50" action="{{route('admin.profile.update')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('patch')
                                <div class="d-flex">
                                    <a href="#" class="me-25">
                                        @if ($admin->profile->photo)
                                            <img src="{{asset('assets/profile_images/'.$admin->profile->photo)}}" id="account-upload-img" class="uploadedAvatar rounded me-50" alt="profile image" height="100" width="100" />
                                        @else
                                            <img src="" id="account-upload-img" class="uploadedAvatar rounded me-50" alt="profile image" height="100" width="100" />
                                        @endif

                                    </a>
                                    <!-- upload and reset button -->
                                    <div class="d-flex align-items-end mt-75 ms-1">
                                        <div>
                                            <label for="account-upload" class="btn btn-sm btn-primary mb-75 me-75">Upload</label>
                                            <input type="file" id="account-upload" name="photo" hidden accept="image/*" />
                                            <p class="mb-0">Allowed file types: png, jpg, jpeg.</p>
                                        </div>
                                    </div>
                                    <!--/ upload and reset button -->
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-12 col-sm-6 mb-1">
                                        <label class="form-label" for="accountFirstName">First Name</label>
                                        <input type="text" class="form-control" id="accountFirstName" name="first_name" placeholder="John"  data-msg="Please enter first name" @if ($admin->profile->first_name)
                                            value="{{$admin->profile->first_name}}"
                                        @else
                                            value="{{old('first_name')}}"
                                        @endif required />
                                    </div>
                                    <div class="col-12 col-sm-6 mb-1">
                                        <label class="form-label" for="accountLastName">Last Name</label>
                                        <input type="text" class="form-control" id="accountLastName" name="last_name" placeholder="Doe"  data-msg="Please enter last name" @if ($admin->profile->last_name)
                                        value="{{$admin->profile->last_name}}"
                                    @else
                                        value="{{old('last_name')}}"
                                    @endif required/>
                                    </div>
                                    <div class="col-12 col-md-6 mb-1 position-relative">
                                        <label class="form-label" for="fp-default">Birthday</label>
                                        <input type="date" id="fp-default" class="form-control flatpickr-basic flatpickr-input active" name="birthday" placeholder="18 June, 2020"  @if ($admin->profile->birthday)
                                        value="{{$admin->profile->birthday}}"
                                    @else
                                        value="{{old('birthday')}}"
                                    @endif />
                                    </div>
                                    <div class="col-12 col-sm-6 mb-1">
                                        <label class="form-label" class="d-block">Gender</label>
                                        <div class="form-check my-50">
                                            <input type="radio" id="validationRadio3" name="gender" value="male" class="form-check-input" @if ($admin->profile->gender === 'male')
                                                checked
                                            @endif  />
                                            <label class="form-check-label" for="validationRadio3">Male</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" id="validationRadio4" name="gender" value="female" class="form-check-input" @if ($admin->profile->gender == 'female')
                                            checked
                                        @endif  />
                                            <label class="form-check-label" for="validationRadio4">Female</label>
                                        </div>
                                    </div>
                                    {{-- <div class="col-12 col-sm-6 mb-1">
                                        <label class="form-label" for="accountEmail">Email</label>
                                        <input type="email" class="form-control" id="accountEmail" name="email" placeholder="Email" @if ($admin->email)
                                            value="{{$admin->email}}"
                                        @else
                                            value="{{old('email')}}"
                                        @endif required />
                                    </div> --}}

                                    <div class="col-12 col-sm-6 mb-1">
                                        <label class="form-label" for="country">Country</label>
                                        <select name="country" id="country" class="select2 form-select" required>
                                            <option value="">Select Country</option>
                                            @foreach ($countries as $country => $value)
                                                <option value="{{$country}}"  @selected($country == $admin->profile->country)>{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-6 mb-1">
                                        <label class="form-label" for="city">City </label>
                                        <input type="text" class="form-control city" id="city" name="city" placeholder=" Enter City " @if ($admin->profile->city)
                                        value="{{$admin->profile->city}}"
                                    @else
                                        value="{{old('city')}}"
                                    @endif />
                                    </div>

                                    <div class="col-12 col-sm-6 mb-1">
                                        <label class="form-label" for="accountAddress" >Address</label>
                                        <input type="text" class="form-control" id="accountAddress" name="street_address" placeholder="Your Address" @if ($admin->profile->street_address)
                                            value ="{{$admin->profile->street_address}}"
                                        @else
                                            value="{{old('street_address')}}"
                                        @endif />
                                    </div>

                                    <div class="col-12 col-sm-6 mb-1">
                                        <label class="form-label" for="accountZipCode">Zip Code</label>
                                        <input type="text" class="form-control account-zip-code" id="accountZipCode" name="postal_code" placeholder="Code" maxlength="6" @if ($admin->profile->postal_code)
                                        value ="{{$admin->profile->postal_code}}"
                                    @else
                                        value="{{old('postal_code')}}"
                                    @endif />
                                    </div>
                                    <div class="col-12 col-sm-6 mb-1">
                                        <label for="language" class="form-label">Locales</label>
                                        <select id="language" class="select2 form-select" name="locale">
                                            <option value="">Select Language</option>
                                            @foreach ($locales as $locale => $value)
                                                <option value="{{$locale}}" @selected($locale == $admin->profile->locale)>{{$value}}</option>
                                            @endforeach
                                        </select>
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

                    <!-- deactivate account  -->
                    <!--/ profile -->
                </div>
            </div>

        </div>
    </div>
</div>
@endsection



@push('script')

    <script src="{{asset('app-assets/js/scripts/pages/page-account-settings-account.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/pickers/pickadate/picker.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/pickers/pickadate/picker.date.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/pickers/pickadate/picker.time.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/pickers/pickadate/legacy.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>
    <script src="{{asset('app-assets/js/scripts/forms/pickers/form-pickers.js')}}"></script>
@endpush

