@extends('user.layouts.user')

@section('title','Product')


@push('style')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/wizard/bs-stepper.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/select/select2.min.css') }}">
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
                        <h2 class="content-header-title float-start mb-0">Product</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Products
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="content-detached content-right">
            <div class="content-body">
                @include('user.layouts.alerts.flash')
                <!-- E-commerce Content Section Starts -->
                <section id="ecommerce-header">
                    {{-- <div class="row">
                        <div class="col-sm-12">
                            <div class="ecommerce-header-items">
                                <div class="result-toggler">
                                    <button class="navbar-toggler shop-sidebar-toggler" type="button" data-bs-toggle="collapse">
                                        <span class="navbar-toggler-icon d-block d-lg-none"><i data-feather="menu"></i></span>
                                    </button>
                                    <div class="search-results">16285 results found</div>
                                </div>
                                <div class="view-options d-flex">
                                    <div class="btn-group dropdown-sort">
                                        <button type="button" class="btn btn-outline-primary dropdown-toggle me-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="active-sorting">Featured</span>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#">Featured</a>
                                            <a class="dropdown-item" href="#">Lowest</a>
                                            <a class="dropdown-item" href="#">Highest</a>
                                        </div>
                                    </div>
                                    <div class="btn-group" role="group">
                                        <input type="radio" class="btn-check" name="radio_options" id="radio_option1" autocomplete="off" checked />
                                        <label class="btn btn-icon btn-outline-primary view-btn grid-view-btn" for="radio_option1"><i data-feather="grid" class="font-medium-3"></i></label>
                                        <input type="radio" class="btn-check" name="radio_options" id="radio_option2" autocomplete="off" />
                                        <label class="btn btn-icon btn-outline-primary view-btn list-view-btn" for="radio_option2"><i data-feather="list" class="font-medium-3"></i></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </section>
                <!-- E-commerce Content Section Starts -->

                <!-- background Overlay when sidebar is shown  starts-->
                <div class="body-content-overlay"></div>
                <!-- background Overlay when sidebar is shown  ends-->

                <!-- E-commerce Search Bar Starts -->
                <section id="ecommerce-searchbar" class="ecommerce-searchbar">

                    <form action="{{URL::current()}}" method="GET">
                        <div class="row mt-1">
                            <div class="col-sm-12">
                                <div class="input-group input-group-merge">
                                    <input type="text" class="form-control search-product" id="shop-search" name="name" value="{{request('name')}}" placeholder="Search Product" aria-label="Search..." aria-describedby="shop-search" />
                                    <span class="input-group-text"><i data-feather="search" class="text-muted"></i></span>
                                </div>
                            </div>
                        </div>
                    </form>

                </section>
                <!-- E-commerce Search Bar Ends -->

                <!-- E-commerce Products Starts -->
                <section id="ecommerce-products" class="grid-view">
                    @forelse ($products as $product)
                        <div class="card ecommerce-card">
                            <div class="item-img text-center">
                                <a href="{{route('user.products.details',$product->slug)}}">
                                    <img class="img-fluid card-img-top" src="{{$product->image_url}}" alt="img-placeholder" /></a>
                            </div>
                            <div class="card-body">
                                <div class="item-wrapper">
                                    {{-- <div class="item-rating">
                                        <ul class="unstyled-list list-inline">
                                            <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
                                            <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
                                            <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
                                            <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
                                            <li class="ratings-list-item"><i data-feather="star" class="unfilled-star"></i></li>
                                        </ul>
                                    </div> --}}
                                    <div>
                                        <h6 class="item-price">${{$product->selling_price}}</h6>
                                    </div>
                                </div>
                                <h6 class="item-name">
                                    <a class="text-body" href="{{route('user.products.details',$product->slug)}}">{{$product->name}}</a>
                                    {{-- <span class="card-text item-company">By <a href="#" class="company-name">Apple</a></span> --}}
                                </h6>
                                <p class="card-text item-description">
                                    {!!($product->description)!!}
                                </p>
                            </div>
                            <div class="item-options text-center">
                                {{-- <div class="item-wrapper">
                                    <div class="item-cost">
                                        <h4 class="item-price">$339.99</h4>
                                    </div>
                                </div> --}}
                                <form action="{{route('user.products.importlist.store',$product->slug)}}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-light btn-wishlist">
                                        <i data-feather="heart"></i>
                                        <span>Import list</span>
                                    </button>
                                </form>
                                <a href="{{route('user.products.details',$product->slug)}}" class="btn btn-primary btn-cart">
                                    <i data-feather="shopping-cart"></i>
                                    <span class="add-to-cart">Push to store</span>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div>
                            <span>No Products defined.</span>
                        </div>
                    @endforelse

                </section>
                <!-- E-commerce Products Ends -->

                <!-- E-commerce Pagination Starts -->
                <section id="ecommerce-pagination">
                    <div class="row">
                        <div class="col-sm-12">
                            <nav aria-label="Page navigation example">
                                {{$products->withQueryString()->links()}}
                            </nav>
                        </div>
                    </div>
                </section>
                <!-- E-commerce Pagination Ends -->

            </div>
        </div>
        <div class="sidebar-detached sidebar-left">
            <div class="sidebar">
                <!-- Ecommerce Sidebar Starts -->
                <form action="{{URL::current()}}" method="GET">
                    <div class="sidebar-shop">
                        <div class="row">
                            <div class="col-sm-12">
                                <h6 class="filter-heading d-none d-lg-block">Filters</h6>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <!-- Price Filter starts -->
                                <div class="multi-range-price">
                                    <h6 class="filter-title mt-0">Multi Range</h6>
                                    <ul class="list-unstyled price-range" id="price-range">
                                        <li>
                                            <div class="form-check">
                                                <input type="radio" id="priceAll" name="price-range" class="form-check-input" checked />
                                                <label class="form-check-label" for="priceAll">All</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check">
                                                <input type="radio" id="priceRange1" name="price-range" class="form-check-input" />
                                                <label class="form-check-label" for="priceRange1">&lt;=$10</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check">
                                                <input type="radio" id="priceRange2" name="price-range" class="form-check-input" />
                                                <label class="form-check-label" for="priceRange2">$10 - $100</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check">
                                                <input type="radio" id="priceARange3" name="price-range" class="form-check-input" />
                                                <label class="form-check-label" for="priceARange3">$100 - $500</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check">
                                                <input type="radio" id="priceRange4" name="price-range" class="form-check-input" />
                                                <label class="form-check-label" for="priceRange4">&gt;= $500</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div id="product-categories">
                                    <h6 class="filter-title">Categories</h6>
                                    <ul class="list-unstyled categories-list">
                                        <li>
                                            <div class="form-check">
                                                <input type="radio" id="" name="category" class="form-check-input" value="" checked />
                                                <label class="form-check-label" for="category1">All</label>
                                            </div>
                                        </li>
                                        @forelse ($categories as $category)
                                            <li>
                                                <div class="form-check">
                                                    <input type="radio" id="category1" name="category" value="{{$category->id}}" class="form-check-input" />
                                                    <label class="form-check-label" for="category1">{{$category->name}}</label>
                                                </div>
                                            </li>
                                        @empty

                                        @endforelse
                                    </ul>
                                </div>
                                <div id="clear-filters">
                                    <button type="submit" class="btn w-100 btn-primary">Filter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Ecommerce Sidebar Ends -->

            </div>
        </div>
    </div>
</div>

@endsection



@push('script')
<script src="{{ asset('app-assets/vendors/js/forms/wizard/bs-stepper.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/forms/form-wizard.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/forms/form-select2.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/extensions/wNumb.min.js')}}"></script>
<script src="{{ asset('app-assets/vendors/js/extensions/nouislider.min.js')}}"></script>
<script src="{{ asset('app-assets/vendors/js/extensions/toastr.min.js')}}"></script>


@endpush

