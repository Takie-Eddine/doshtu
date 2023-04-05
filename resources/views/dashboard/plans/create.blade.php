@extends('dashboard.layouts.dashboard')

@section('title','Create Plan')


@push('style')

<!-- END: Vendor CSS-->
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
                        <h2 class="content-header-title float-start mb-0">Plan</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{route('admin.plans.index')}}">Plans</a>
                                </li>
                                <li class="breadcrumb-item"><a >Create</a>
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
            <!-- Blog Edit -->
            <div class="blog-edit-wrapper">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            @include('dashboard.layouts.alerts.flash')
                            <div class="card-body">
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

                                <form action="{{route('admin.plans.store')}}" method="POST" class="mt-2" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="mb-2">
                                                <label class="form-label" for="blog-edit-title">Arabic Title</label>
                                                <input type="text" id="blog-edit-title" class="form-control" name="name_ar" value="{{old('name_ar')}}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-2">
                                                <label class="form-label" for="blog-edit-title">English Title</label>
                                                <input type="text" id="blog-edit-title" class="form-control" name="name_en" value="{{old('name_en')}}" />
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="mb-2">
                                                <label class="form-label" for="blog-edit-title">Monthly Price</label>
                                                <input type="text" id="blog-edit-title" class="form-control" name="monthly_price" value="{{old('monthly_price')}}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-2">
                                                <label class="form-label" for="blog-edit-title">Annually Price</label>
                                                <input type="text" id="blog-edit-title" class="form-control" name="annualy_price" value="{{old('annualy_price')}}" />
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-2">
                                                <label class="form-label">Arabic Description</label>
                                                <textarea name="description_ar" class="form-control summernote" >{!!old('description_ar')!!}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-2">
                                                <label class="form-label">English Description</label>
                                                <textarea name="description_en" class="form-control summernote" >{!!old('description_en')!!}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="mb-1">
                                                <input type="file" id="last-name-column" id="category-images" class="file" data-preview-file-type="text" placeholder="" name="image" value="{{old('image')}}"/>
                                                <span class="form-text text-muted">Image width should be 500px x 500px</span>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-50">
                                            <button type="submit" class="btn btn-primary me-1">Save </button>
                                            <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                                <!--/ Form -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Blog Edit -->

        </div>
    </div>
</div>


@endsection


@push('script')
<script>
    $(function(){

        $('.summernote').summernote({
                tabSize: 2,
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
        })

    });
</script>
@endpush
