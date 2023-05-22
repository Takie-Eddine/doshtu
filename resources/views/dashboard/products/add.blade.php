@extends('dashboard.layouts.dashboard')

@section('title','Add Product')


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
                        <h2 class="content-header-title float-start mb-0">Supplier</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{route('admin.companies.index')}}">Suppliers</a>
                                </li>
                                <li class="breadcrumb-item active"><a >Create</a>
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
            <!-- Basic multiple Column Form section start -->
            <section id="multiple-column-form">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            @include('dashboard.layouts.alerts.flash')
                            <div class="card-header">
                                <h4 class="card-title">Create Supplier</h4>
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
                            <div class="card-body">
                                <form class="form" action="{{route('admin.products.store_xml')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="first-name-column">Company Name</label>
                                                <input type="text" id="first-name-column" class="form-control" name="company_name" placeholder=" Enter  Name" value="{{old('company_name')}}"  />
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="email-id-column">Company Email</label>
                                                <input type="email" id="email-id-column" class="form-control" placeholder="Enter  Email" name="email" value="{{old('email')}}" />
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="first-name-column">Company Description</label>
                                                <textarea name="description" id="textarea-counter" class="form-control char-textarea" cols="30" rows="2">{{old('description')}}</textarea>
                                            </div>
                                            <small class="textarea-counter-value float-end"><span class="char-count">0</span> / 30 </small>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="country-floating">Company Mobile Number</label>
                                                <input type="tel" id="country-floating" class="form-control" name="mobile" placeholder="Enter Mobile" value="{{old('mobile')}}" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="country">Country</label>
                                            <select name="country" id="country" class="select2 form-select" >
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $country => $value)
                                                    <option value="{{$country}}" {{old('country') == $country ? 'selected' : null}} >{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="city">City </label>
                                            <input type="text" class="form-control city" id="city" name="city" placeholder=" Enter City " value="{{old('city')}}" />
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="company-column">Adress</label>
                                                <input type="text" id="company-column" class="form-control" name="address" placeholder="Enter Your Address" value="{{old('address')}}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="first-name-column">User Name</label>
                                                <input type="text" id="first-name-column" class="form-control" name="username" placeholder=" Enter  Name" value="{{old('username')}}"  />
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="email-id-column">User Email</label>
                                                <input type="email" id="email-id-column" class="form-control" placeholder="Enter  Email" name="user_email" value="{{old('user_email')}}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="email-id-column">User Password</label>
                                                <input type="password"  class="form-control" placeholder="Enter  Password" name="password" value="{{old('password')}}" />
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="email-id-column">Product Link</label>
                                                <input type="url"  class="form-control" placeholder="Enter  Link" name="link" value="{{old('link')}}" />
                                            </div>
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
@endpush
