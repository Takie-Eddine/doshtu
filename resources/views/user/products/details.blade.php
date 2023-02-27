@extends('user.layouts.user')

@section('title','Product Details')


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
                        <h2 class="content-header-title float-start mb-0">Product Statistics</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('user.products.index') }}">Products</a>
                                </li>
                                <li class="breadcrumb-item active">Statistics
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
                                <h4>{{ $product->name }}</h4>
                                {{-- <h6 >{{ $product->title }}</h6> --}}
                                <hr />
                                <div class="card-body statistics-body">
                                    <div class="row">
                                        <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                                            <div class="d-flex flex-row">
                                                <div class="avatar bg-light-primary me-2">
                                                    <div class="avatar-content">
                                                        <i data-feather='list'></i>
                                                    </div>
                                                </div>
                                                <div class="my-auto">
                                                    <h4 class="fw-bolder mb-0">230k</h4>
                                                    <p class="card-text font-small-3 mb-0">Orders</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                                            <div class="d-flex flex-row">
                                                <div class="avatar bg-light-info me-2">
                                                    <div class="avatar-content">
                                                        <i data-feather="box" class="avatar-icon"></i>
                                                    </div>
                                                </div>
                                                <div class="my-auto">
                                                    <h4 class="fw-bolder mb-0">8.549k</h4>
                                                    <p class="card-text font-small-3 mb-0">Product cost</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-sm-0">
                                            <div class="d-flex flex-row">
                                                <div class="avatar bg-light-danger me-2">
                                                    <div class="avatar-content">
                                                        <i data-feather="dollar-sign" class="avatar-icon"></i>
                                                    </div>
                                                </div>
                                                <div class="my-auto">
                                                    <h4 class="fw-bolder mb-0">1.423k</h4>
                                                    <p class="card-text font-small-3 mb-0">Selling price</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-sm-6 col-12">
                                            <div class="d-flex flex-row">
                                                <div class="avatar bg-light-success me-2">
                                                    <div class="avatar-content">
                                                        <i data-feather='trending-up'></i>
                                                    </div>
                                                </div>
                                                <div class="my-auto">
                                                    <h4 class="fw-bolder mb-0">$9745</h4>
                                                    <p class="card-text font-small-3 mb-0">Profit margin</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body statistics-body">
                                    <div class="row">
                                        <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                                            <div class="d-flex flex-row">
                                                <div class="avatar bg-light-success me-2">
                                                    <div class="avatar-content">
                                                        <i data-feather='globe'></i>
                                                    </div>
                                                </div>
                                                <div class="my-auto">
                                                    <h4 class="fw-bolder mb-0">230k</h4>
                                                    <p class="card-text font-small-3 mb-0">Total sales</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                                            <div class="d-flex flex-row">
                                                <div class="avatar bg-light-Secondary me-2">
                                                    <div class="avatar-content">
                                                        <i data-feather='shopping-bag'></i>
                                                    </div>
                                                </div>
                                                <div class="my-auto">
                                                    <h4 class="fw-bolder mb-0">8.549k</h4>
                                                    <p class="card-text font-small-3 mb-0">Supplier</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-sm-0">
                                            <div class="d-flex flex-row">
                                                <div class="avatar bg-light-primary me-2">
                                                    <div class="avatar-content">
                                                        <i data-feather='shopping-cart'></i>
                                                    </div>
                                                </div>
                                                <div class="my-auto">
                                                    <h4 class="fw-bolder mb-0">1.423k</h4>
                                                    <p class="card-text font-small-3 mb-0">Stores selling</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-sm-6 col-12">
                                            <div class="d-flex flex-row">
                                                <div class="avatar bg-light-warning me-2">
                                                    <div class="avatar-content">
                                                        <i data-feather='star'></i>
                                                    </div>
                                                </div>
                                                <div class="my-auto">
                                                    <h4 class="fw-bolder mb-0">$9745</h4>
                                                    <p class="card-text font-small-3 mb-0">Product rating</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr />
                                {{-- <p class="card-text">Available - @if ($product->in_stock == 0)
                                        <span class="text-warning"> {{ $product->getStock() }} </span></p>
                                @else
                                <span class="text-success"> {{ $product->getStock() }} </span></p>
                                @endif --}}
                                <div class="d-flex flex-column flex-sm-row pt-1">
                                    <a href="{{route('user.products.pushtostore',$product->slug)}}" class="btn btn-primary btn-cart me-0 me-sm-1 mb-1 mb-sm-0">
                                        <i data-feather="shopping-cart" class="me-50"></i>
                                        <span class="">Push to Store</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Product Details ends -->

                    <!-- Item features starts -->
                    <div class="item-features">
                        <div class="row text-center">
                            <div class="col-12 col-md-4 mb-4 mb-md-0">
                                <div class="w-75 mx-auto">
                                    <i data-feather="award"></i>
                                    <h4 class="mt-2 mb-1">100% Original</h4>
                                    <p class="card-text">Chocolate bar candy canes ice cream toffee. Croissant pie
                                        cookie halvah.</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-4 mb-md-0">
                                <div class="w-75 mx-auto">
                                    <i data-feather="clock"></i>
                                    <h4 class="mt-2 mb-1">10 Day Replacement</h4>
                                    <p class="card-text">Marshmallow biscuit donut dragée fruitcake. Jujubes wafer
                                        cupcake.</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-4 mb-md-0">
                                <div class="w-75 mx-auto">
                                    <i data-feather="shield"></i>
                                    <h4 class="mt-2 mb-1">1 Year Warranty</h4>
                                    <p class="card-text">Cotton candy gingerbread cake I love sugar plum I love sweet
                                        croissant.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Item features ends -->

                    <!-- Related Products starts -->

                    <div class="card-body">
                        <div class="mt-4 mb-2 text-center">
                            <h4>Related Products</h4>
                            <p class="card-text">People also search for this items</p>
                        </div>
                        <div class="swiper-responsive-breakpoints swiper-container px-4 py-2">
                            <div class="swiper-wrapper">
                                @forelse ($related_products as $_product)
                                <div class="swiper-slide">
                                    <a href="{{route('user.products.details',$_product -> slug)}}">
                                        <div class="item-heading">
                                            <h5 class="text-truncate mb-0">{{$_product -> name}}</h5>
                                            {{-- <small class="text-body">{{$_product -> title}}</small> --}}
                                        </div>
                                        <div class="img-container w-50 mx-auto py-75">
                                            <img src="{{$_product -> image_url}}"
                                                class="img-fluid" alt="image" />
                                        </div>
                                        <div class="item-meta">
                                            {{-- <ul class="unstyled-list list-inline mb-25">
                                                <li class="ratings-list-item"><i data-feather="star"
                                                        class="filled-star"></i></li>
                                                <li class="ratings-list-item"><i data-feather="star"
                                                        class="filled-star"></i></li>
                                                <li class="ratings-list-item"><i data-feather="star"
                                                        class="filled-star"></i></li>
                                                <li class="ratings-list-item"><i data-feather="star"
                                                        class="filled-star"></i></li>
                                                <li class="ratings-list-item"><i data-feather="star"
                                                        class="unfilled-star"></i></li>
                                            </ul> --}}
                                            <p class="card-text text-primary mb-0">${{$_product -> selling_price}}</p>
                                        </div>
                                    </a>
                                </div>
                                @empty
                                <div class="item-meta">
                                    <p class="card-text text-primary mb-0">No related products defined.</p>
                                </div>
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

