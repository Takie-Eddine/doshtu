@extends('user.layouts.user')

@section('title','Product')


@push('style')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/select/select2.min.css') }}">
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
                        <h2 class="content-header-title float-start mb-0">Product Edit</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{route('user.products.index')}}">Products</a>
                                </li>

                                <li class="breadcrumb-item active">Edit
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
                @include('user.layouts.alerts.flash')
                <form action="{{route('user.products.push')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="{{$product->id}}" id="">
                    <div class="row">
                        <div class="col-7">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-start">

                                        <div class="author-info">
                                            <h4 class="mb-25">Content</h4>

                                        </div>
                                    </div>
                                    <!-- Form -->
                                            <div class="col-md-12 col-12">
                                                <div class="mb-2">
                                                    <label class="form-label" for="blog-edit-title">Title</label>
                                                    <input type="text" id="blog-edit-title" class="form-control" value="{{$product->name}}" name="name" />
                                                </div>
                                                @error('name')
                                                    <span class="text-danger"> {{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-12">
                                                <div class="mb-2">
                                                    <label class="form-label">Description</label>
                                                    <div id="blog-editor-wrapper">
                                                        <div id="blog-editor-container">
                                                            <div class="editor">
                                                                <textarea name="description" class="form-control summernote" id="description">{!!($product->description)!!}</textarea>
                                                            </div>
                                                        </div>
                                                        @error('description')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-2">
                                                <div class="col-md-12 col-12">
                                                    <div class="mb-2">
                                                        <label class="form-label" for="default-select-multi">Tags</label>
                                                        @if ($tags && $tags->count() > 0 && $product-> tags && count($product-> tags)>0)

                                                            <select id="default-select-multi{{rand(00,99)}}" class="select2 form-select" name="tags[]" multiple>
                                                                @foreach ($tags as $tag)
                                                                <option value="{{$tag->id}}" {{in_array($tag->id,$product->tags->pluck('id')->toArray())? 'selected' : null }}>{{$tag->name}}</option>
                                                                @endforeach
                                                            </select>

                                                        @endif
                                                            @error('tags')
                                                                <span class="text-danger"> {{ $message }}</span>
                                                            @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-12">
                                                    <div class="mb-2">
                                                        <label class="form-label" for="default-select-multi">Categories</label>
                                                        @if ($categories && $categories->count() > 0 && $product-> categories && count($product-> categories)>0)

                                                            <select id="default-select-multi{{rand(00,99)}}" class="select2 form-select" name="categories[]" multiple>
                                                                @foreach ($categories as $category)
                                                                <option value="{{$category->id}}" {{in_array($category->id,$product->categories->pluck('id')->toArray())? 'selected' : null }}>{{$category->name}}</option>
                                                                @endforeach
                                                            </select>

                                                        @endif
                                                            @error('categories')
                                                                <span class="text-danger"> {{ $message }}</span>
                                                            @enderror
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
                                                <h4 class="mb-1">Images</h4>
                                                <div class="d-flex flex-column flex-md-row">
                                                    <div class="featured-info">
                                                        <div class="row">
                                                            @forelse ($product->images as $item)
                                                                <div class="item thumb-container col-md-3 col-xs-12 pt-30">
                                                                    <img src="{{$item->image_url}}" class="img-fluid thumb js-thumb  selected" >
                                                                </div>
                                                            @empty
                                                            @endforelse
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="border rounded p-2">
                                                {{-- <h4 class="mb-1">Details</h4> --}}
                                                <div class="d-flex flex-column flex-md-row">
                                                    <div class="row">
                                                        <label class="form-label" for="default_price">Default Price</label>
                                                        <div class="input-group mb-2 mb-1 col-md-6">
                                                            <span class="input-group-text">$</span>
                                                            <input type="number" id="default_price" name="selling_price" value="{{$product->selling_price}}" class="form-control" />
                                                            @error('selling_price')
                                                                <span class="text-danger"> {{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        {{-- <label for="">profit margin:</label> --}}

                                                    </div>

                                                </div>
                                                <div class="d-flex flex-column flex-md-row">
                                                    <div class="row">
                                                        <label class="form-label" for="sku">Sku</label>
                                                        <div class="input-group mb-2 mb-1 col-md-6">
                                                            <input type="text" id="default_price" name="sku" value="{{$product->sku}}" class="form-control" />
                                                            @error('sku')
                                                                <span class="text-danger"> {{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        {{-- <label for="">profit margin:</label> --}}

                                                    </div>

                                                </div>
                                                <hr>
                                                <div>
                                                    <a href="{{route('user.products.variant',$product->slug)}}" class="btn btn-light btn-wishlist">
                                                        <i data-feather="edit"></i>
                                                        <span>Edit Variants</span>
                                                    </a>
                                                    <a href="" class="btn btn-light btn-wishlist">
                                                        <i data-feather='truck'></i>
                                                        <span>Shipping Options</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                        <button type="submit" class="btn btn-primary me-1">Push to store</button>
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
<script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/forms/form-select2.js') }}"></script>
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

