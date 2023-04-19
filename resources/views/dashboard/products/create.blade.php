@extends('dashboard.layouts.dashboard')

@section('title','Create Product')


@push('style')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/select/select2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/file-uploaders/dropzone.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/form-file-uploader.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/katex.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/monokai-sublime.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/quill.snow.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/quill.bubble.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/form-quill-editor.css') }}">
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
                        <h2 class="content-header-title float-start mb-0">Product</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{route('admin.products.index')}}">Products</a>
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
            <div class="blog-edit-wrapper">
                @include('dashboard.layouts.alerts.flash')


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

                <form action="{{route('admin.products.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-7">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-start">

                                        <div class="author-info">
                                            <h4 class="mb-25">Create Product</h4>

                                        </div>
                                    </div>
                                    <!-- Form -->
                                            <div class="col-12">
                                                <div class="col-md-12 col-12">
                                                    <div class="mb-2">
                                                        <label class="form-label" for="blog-edit-title">Arabic Title</label>
                                                        <input type="text" id="blog-edit-title" class="form-control" value="{{old('name_ar')}}" name="name_ar" />
                                                    </div>
                                                    @error('name')
                                                        <span class="text-danger"> {{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12 col-12">
                                                    <div class="mb-2">
                                                        <label class="form-label" for="blog-edit-title">English Title</label>
                                                        <input type="text" id="blog-edit-title" class="form-control" value="{{old('name_en')}}" name="name_en" />
                                                    </div>
                                                    @error('name')
                                                        <span class="text-danger"> {{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="col-12">
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
                                            </div>
                                            <div class="col-12 mb-2">
                                                <div class="col-md-12 col-12">
                                                    <div class="mb-2">
                                                        <label class="form-label" for="default-select-multi">Tags</label>
                                                        <select id="default-select-multi{{rand(00,99)}}" class="select2 form-select opts" name="tags[]" multiple>
                                                            <option value="">Select Tag</option>
                                                            @forelse ($tags as $tag)
                                                                <option value="{{$tag->name}}" {{ (collect(old('tags'))->contains($tag->name)) ? 'selected':'' }} >{{$tag->name}}</option>
                                                            @empty
                                                            @endforelse
                                                            </select>
                                                            @error('tags.0')
                                                                <span class="text-danger"> {{ $message }}</span>
                                                            @enderror
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-12">
                                                    <div class="mb-2">
                                                        <label class="form-label" for="default-select-multi">Categories</label>
                                                        <select id="default-select-multi{{rand(00,99)}}" class="select2 form-select" name="category[]" multiple>
                                                            <option value="">Select Category</option>
                                                            @forelse ($categories as $category)
                                                                <option value="{{$category->id}}" {{ (collect(old('category'))->contains($category->id)) ? 'selected':'' }}> <b> {{$category->name}} </b></option>
                                                                @forelse ($category->children as $children)
                                                                    <option value="{{$children->id}}" {{ (collect(old('category'))->contains($children->id)) ? 'selected':'' }}>-{{$children->name}}</option>
                                                                    @forelse ($children->children as $child)
                                                                        <option value="{{$child->id}}" {{ (collect(old('category'))->contains($child->id)) ? 'selected':'' }}>--{{$child->name}}</option>
                                                                        @forelse ($child->children as $item)
                                                                            <option value="{{$item->id}}" {{ (collect(old('category'))->contains($item->id)) ? 'selected':'' }}>---{{$item->name}}</option>
                                                                            @forelse ($child->children as $item)
                                                                                <option value="{{$item->id}}" {{ (collect(old('category'))->contains($item->id)) ? 'selected':'' }}>---{{$item->name}}</option>
                                                                                @forelse ($item->children as $value)
                                                                                    <option value="{{$value->id}}" {{ (collect(old('category'))->contains($value->id)) ? 'selected':'' }}>----{{$value->name}}</option>
                                                                                @empty
                                                                                @endforelse
                                                                            @empty
                                                                            @endforelse
                                                                        @empty
                                                                        @endforelse
                                                                    @empty
                                                                    @endforelse
                                                                @empty
                                                                @endforelse
                                                            @empty
                                                            @endforelse
                                                            </select>
                                                            @error('category.0')
                                                                <span class="text-danger"> {{ $message }}</span>
                                                            @enderror
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    <!--/ Form -->
                                </div>
                            </div>


                        <div class="col-5">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 mb-2">
                                            <div class="border rounded p-2">
                                                <h4 class="mb-1">Thumbnail  Image</h4>
                                                        <div class="form-group files color">
                                                            <input type="file"  id="" class="file" data-preview-file-type="text" placeholder="" name="photo" />
                                                <span class="form-text text-muted">Image width should be 500px x 500px</span>
                                                        </div>
                                            </div>
                                            <div class="border rounded p-2">
                                                <h4 class="mb-1">Details</h4>
                                                <div class="d-flex flex-column flex-md-row">
                                                    <div class="row">
                                                        {{-- <div class="mb-1 col-md-6">
                                                            <label class="form-label" for="default_price"> Price</label>
                                                            <input type="text" id="default_price" name="price" value="{{old('price')}}" class="form-control"  />
                                                            @error('price')
                                                                <span class="text-danger"> {{ $message }}</span>
                                                            @enderror
                                                        </div> --}}
                                                        <div class="row">
                                                            <div class="input-group input-group-merge mb-2">
                                                                <label class="input-group-text" for="default_price">Price</label>
                                                                <span class="input-group-text">$</span>
                                                                <input type="text" class="form-control" name="price" id="price" value="{{old('price')}}"  aria-label="Amount (to the nearest dollar)" />
                                                                {{-- <span class="input-group-text">.00</span> --}}
                                                            </div>
                                                            @error('price')
                                                                <span class="text-danger"> {{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="row">
                                                            <div class="input-group input-group-merge mb-2">
                                                                <label class="input-group-text" for="default_price">Selling Price</label>
                                                                <span class="input-group-text">$</span>
                                                                <input type="text" class="form-control" name="selling_price" id="selling_price" value="{{old('selling_price')}}"  aria-label="Amount (to the nearest dollar)" />
                                                                {{-- <span class="input-group-text">.00</span> --}}
                                                            </div>
                                                            @error('selling_price')
                                                                <span class="text-danger"> {{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        {{-- <div class=" mb-1 col-md-6">
                                                            <label class="form-label" for="default_price">Selling Price</label>
                                                            <span class="input-group-text">$</span>
                                                            <input type="number" class="form-control" id="default_price" name="selling_price" value="{{old('selling_price')}}" class="form-control"  />
                                                            @error('selling_price')
                                                                <span class="text-danger"> {{ $message }}</span>
                                                            @enderror
                                                        </div> --}}
                                                        {{-- <label for="">profit margin:</label> --}}
                                                    </div>
                                                </div>
                                                    <div class="d-flex flex-column flex-md-row">
                                                        <div class="row">
                                                            <div class="row">
                                                                <div class="input-group input-group-merge mb-2">
                                                                    <label class="input-group-text" for="default_price">Global Price</label>
                                                                    <span class="input-group-text">$</span>
                                                                    <input type="text" class="form-control" name="global_price" value="{{old('global_price')}}"  aria-label="Amount (to the nearest dollar)" />
                                                                    {{-- <span class="input-group-text">.00</span> --}}
                                                                </div>
                                                                @error('global_price')
                                                                    <span class="text-danger"> {{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            {{-- <div class="mb-1 col-md-6">
                                                                <label class="form-label" for="default_price">Global Price</label>
                                                                <input type="number" id="default_price" name="global_price" value="{{old('global_price')}}" class="form-control"  />
                                                                @error('global_price')
                                                                    <span class="text-danger"> {{ $message }}</span>
                                                                @enderror
                                                            </div> --}}
                                                            <div class="row">
                                                                <div class="input-group input-group-merge mb-2">
                                                                    <label class="input-group-text" for="default_price">Compare Price</label>
                                                                    <span class="input-group-text">$</span>
                                                                    <input type="text" class="form-control" name="compare_price" value="{{old('compare_price')}}"  aria-label="Amount (to the nearest dollar)" />
                                                                    {{-- <span class="input-group-text">.00</span> --}}
                                                                </div>
                                                                @error('compare_price')
                                                                    <span class="text-danger"> {{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            {{-- <div class="mb-1 col-md-6">
                                                                <label class="form-label" for="default_price">Compare Price</label>
                                                                <input type="number" id="default_price" name="compare_price" value="{{old('compare_price')}}" class="form-control"  />
                                                                @error('compare_price')
                                                                    <span class="text-danger"> {{ $message }}</span>
                                                                @enderror
                                                            </div> --}}
                                                            {{-- <label for="">profit margin:</label> --}}
                                                        </div>
                                                </div>
                                                <hr>
                                                <div>
                                                    <div class="row">
                                                        <div class="mb-1 col-md-6">
                                                            <label class="form-label" for="default_price"> SKU </label>
                                                            <input type="text" id="default_price" name="sku" value="{{old('sku')}}" class="form-control"  />
                                                            @error('sku')
                                                                <span class="text-danger"> {{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-1 col-md-6">
                                                            <label class="form-label" for="default_price"> Quantity </label>
                                                            <input type="number" id="quantity" name="quantity" value="{{old('quantity')}}" class="form-control"  />
                                                            @error('quantity')
                                                                <span class="text-danger"> {{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row">

                                                        <div class="mb-1 col-md-6">
                                                            <label class="form-label" for="company"> Company</label>
                                                            <select id="default-select-multi{{rand(00,99)}}" class="select2 form-select" name="company" >
                                                                <option value="">Select Company</option>
                                                                @forelse ($companies as $company)
                                                                    <option value="{{$company->id}}" {{ (collect(old('company'))->contains($company->id)) ? 'selected':'' }}>{{$company->company_name}}</option>

                                                                @empty
                                                                @endforelse
                                                                </select>
                                                            @error('company')
                                                                <span class="text-danger"> {{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-1 col-md-6">
                                                            <label class="form-label" for="default_price"> Shipping Time(d)</label>
                                                            <input type="number" id="default_price" name="shipping_time" value="{{old('shipping_time')}}" class="form-control"  />
                                                            @error('shipping_time')
                                                                <span class="text-danger"> {{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    {{-- <a href="" class="btn btn-light btn-wishlist">
                                                        <i data-feather="edit"></i>
                                                        <span>Add Variants</span>
                                                    </a> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 mb-2">
                                            <div class="border rounded p-2">
                                                <h4 class="mb-1">Gallery</h4>
                                                        <div class="form-group files color">
                                                            <input type="file"  id="images" class="file" data-preview-file-type="text" placeholder="" name="image[]" multiple/>
                                                <span class="form-text text-muted">Image width should be 500px x 500px</span>
                                                        </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                        <button type="submit" class="btn btn-primary me-1">Save</button>
                        <button type="reset" onclick="history.back()" class="btn btn-outline-secondary">Cancel</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection


@push('script')
<script src="{{ asset('app-assets/vendors/js/file-uploaders/dropzone.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/forms/form-select2.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/forms/form-file-uploader.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/editors/quill/katex.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/editors/quill/highlight.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/editors/quill/quill.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/forms/form-quill-editor.js') }}"></script>
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
<script>
    $(".opts").select2({
    tags: true,
    tokenSeparators: [',', ' ']
    })
</script>
<script>
    $(function(){

        $("#image").fileinput({

            theme:'fas',
            maxFilesize: 5,
            maxFileCount: 10,
            allowedFileTypes:['image'],
            showCancel :true ,
            showRemove: false,
            showUpload: false,
            overwriteInitial:false,

        });


    });
</script>

<script>
    $('#selling_price, #price').mouseenter(function(){
        var number = parseFloat($('#price').val());

        $('#selling_price').val( (((number * 20)/100 + number)) );
    });
</script>
@endpush
