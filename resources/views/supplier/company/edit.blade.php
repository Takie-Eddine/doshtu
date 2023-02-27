@extends('supplier.layouts.supplier')

@section('title','Company')


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
                        <h2 class="content-header-title float-start mb-0">Company</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('supplier.dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{route('supplier.company')}}">Company</a>
                                </li>
                                <li class="breadcrumb-item active"><a > {{$company->company_name}} </a>
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
            @include('supplier.layouts.alerts.flash')
            <!-- Basic multiple Column Form section start -->
            <section id="multiple-column-form">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Edit {{$company->company_name}}</h4>
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
                                <form class="form" action="{{route('supplier.company.update')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('patch')
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="first-name-column">Company Name</label>
                                                <input type="text" id="first-name-column" class="form-control" name="company_name" placeholder=" Enter  Name" value="{{$company->company_name}}"  />
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="email-id-column">Email</label>
                                                <input type="email" id="email-id-column" class="form-control" placeholder="Enter  Email" name="email" value="{{$company->email}}" />
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="first-name-column">Description</label>
                                                <textarea name="description" id="textarea-counter" class="form-control char-textarea" cols="30" rows="2">{{$company->description}}</textarea>
                                            </div>
                                            <small class="textarea-counter-value float-end"><span class="char-count">0</span> / 30 </small>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="country-floating">Mobile Number</label>
                                                <input type="tel" id="country-floating" class="form-control" name="mobile" placeholder="Enter Mobile" value="{{$company->mobile}}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="country-floating">Office Number</label>
                                                <input type="tel" id="country-floating" class="form-control" name="mobile_office" placeholder="Enter Office Number" value="{{$company->office_mobile}}" />
                                            </div>
                                        </div>


                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="country">Country</label>
                                            <select name="country" id="country" class="select2 form-select" required>
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $country => $value)
                                                    <option value="{{$country}}"  @selected($country == $company->country)>{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="city">City </label>
                                            <input type="text" class="form-control city" id="city" name="city" placeholder=" Enter City " value="{{$company->city}}"/>
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="city">State </label>
                                            <input type="text" class="form-control city" id="city" name="state" placeholder=" Enter State " value="{{$company->state}}"/>
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountZipCode">Pin Code</label>
                                            <input type="text" class="form-control account-zip-code" id="accountZipCode" name="pincode" placeholder="Code" maxlength="6" value="{{$company->pincode}}"/>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="company-column">Adress</label>
                                                <input type="text" id="company-column" class="form-control" name="address" placeholder="Enter Your Address" value="{{$company->address}}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="email-id-column">Website</label>
                                                <input type="url" id="email-id-column" class="form-control" placeholder="Enter Website" name="website" value="{{$company->website}}" />
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="mb-1">
                                                <input type="file"  id="manufacture-images" class="file" data-preview-file-type="text" placeholder="" name="image" />
                                                <span class="form-text text-muted">Image width should be 500px x 500px</span>
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

<script>
    $(function(){
        $("#manufacture-images").fileinput({
                theme: "fas",
                maxFileCount: 1,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,
                initialPreview: [
                    @if($company->logo != '')
                    "{{ asset('assets/product_categories/' . $company->logo) }}",
                    @endif
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                initialPreviewConfig: [
                    @if($company->logo != '')
                    {
                        caption: "{{ $company->logo }}",
                        size: '1111',
                        width: "120px",
                        url: "{{ route('supplier.company.remove_image', ['company_id' => $company->id, '_token' => csrf_token()]) }}",
                        key: {{ $company->id }}
                    }
                    @endif
                ]
            });
    });
</script>
@endpush

