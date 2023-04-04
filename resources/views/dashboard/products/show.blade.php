@extends('dashboard.layouts.dashboard')

@section('title','Show Product')


@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/spinner/jquery.bootstrap-touchspin.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/swiper.min.css') }}">
@endpush

@section('content')

<div class="app-content content ecommerce-application">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">Product Details</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a>
                                </li>
                                <li class="breadcrumb-item active">Details
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
            <!-- app e-commerce details start -->
            <section class="app-ecommerce-details">
                <div class="card">
                    <!-- Product Details starts -->
                    <div class="card-body">
                        <div class="row my-2">
                            <div class="col-12 col-md-5 d-flex align-items-center justify-content-center mb-2 mb-md-0">
                                <div class="d-flex align-items-center justify-content-center">
                                    <img src="{{$product->image_url}}" class="img-fluid product-img" alt="product image" />
                                </div>
                            </div>
                            <div class="col-12 col-md-7">
                                <h4>{{$product->name}}</h4>
                                <span class="card-text item-company">By <a href="#" class="company-name">{{$product->company->company_name}}</a></span>
                                <div class="ecommerce-details-price d-flex flex-wrap mt-1">
                                    <h4 class="item-price me-1">${{$product->price}}</h4>

                                    <ul class="unstyled-list list-inline ps-1 border-start">

                                    </ul>
                                    <h4 class="item-price me-1">${{$product->selling_price}}</h4>
                                </div>
                                <p class="card-text">Available - @if ($product->quantity == 0)
                                    <span class="text-warning"> {{ $product->quantity }} </span></p>
                                    @else
                                    <span class="text-success"> {{ $product->quantity }} </span>
                                    @endif
                                </p>
                                <p class="card-text">
                                    {!!$product->description!!}
                                </p>
                                <ul class="product-features list-unstyled">
                                </ul>
                                <hr />
                                @forelse ($product->variants as $variant)
                                    @forelse ($variant->attributes as $attribute)
                                        <div class="product-color-options">
                                            <ul class="list-unstyled mb-0">
                                                <li class="d-inline-block selected">
                                                    <div class="color-option ">
                                                        <div class="filloption ">{{$attribute->name}} : {{$attribute->option->value}}</div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    @empty
                                    @endforelse
                                @empty
                                @endforelse
                                <hr />
                            </div>
                        </div>
                    </div>
                    <!-- Product Details ends -->

                    <!-- Related Products starts -->
                    <div class="card-body">
                        <div class="mt-4 mb-2 text-center">
                            <h4>Product Images</h4>
                            <p class="card-text"></p>
                        </div>
                        <div class="swiper-responsive-breakpoints swiper-container px-4 py-2">
                            <div class="swiper-wrapper">
                                @forelse ($product->images as $image)
                                <div class="swiper-slide">
                                    <a href="#">
                                        <div class="img-container w-50 mx-auto py-75">
                                            <img src="{{asset('assets/product_images/'.$image->name)}}" class="img-fluid" alt="image" />
                                        </div>
                                    </a>
                                </div>
                                @empty

                                @endforelse

                            </div>
                            <!-- Add Arrows -->
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                    <!-- Related Products ends -->
                </div>
            </section>
            <!-- app e-commerce details end -->

        </div>
    </div>
</div>


@endsection



@push('script')
<script src="{{ asset('app-assets/vendors/js/forms/spinner/jquery.bootstrap-touchspin.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/extensions/swiper.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/pages/app-ecommerce-details.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/forms/form-number-input.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/forms/form-select2.js') }}"></script>
@endpush
