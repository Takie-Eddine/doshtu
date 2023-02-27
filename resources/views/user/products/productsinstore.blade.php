@extends('user.layouts.user')

@section('title','Products In Store')


@push('style')
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/forms/wizard/bs-stepper.min.css')}}">
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
                        <h2 class="content-header-title float-start mb-0">Product In Store</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{route('user.products.index')}}">Products</a>
                                </li>

                                <li class="breadcrumb-item active">Product In Store
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="content-body">
            <div class="bs-stepper checkout-tab-steps">
                <!-- Wizard starts -->
                <div class="bs-stepper-header">
                    <div class="step" data-target="#step-cart" role="tab" id="step-cart-trigger">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-box">
                                <i data-feather="shopping-cart" class="font-medium-3"></i>
                            </span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Product on store</span>
                                <span class="bs-stepper-subtitle">Your List Items</span>
                            </span>
                        </button>
                    </div>
                </div>


                <div class="bs-stepper-content">

                    <div id="step-cart" class="content" role="tabpanel" aria-labelledby="step-cart-trigger">
                        <div id="place-order" class="list-view product-checkout">
                            <!-- Checkout Place Order Left starts -->
                            <div class="checkout-items">
                                @if ($products && count($products)>0)
                                    @foreach ($products as $product)
                                        <div class="card ecommerce-card">
                                            <div class="item-img">
                                                <a href="{{route('user.products.details',$product->slug)}}">
                                                    <img src="{{$product ->image_url}}" alt="img-placeholder" />
                                                </a>
                                            </div>
                                            <div class="card-body">
                                                <div class="item-name">
                                                    <h6 class="mb-0"><a href="{{route('user.products.details',$product->slug)}}" class="text-body">{{$product->name}}</a></h6>
                                                </div>
                                            </div>
                                            <div class="item-options text-center">
                                                <div class="item-wrapper">
                                                    <div class="item-cost">
                                                        <h4 class="item-price">{{$product->price}}$</h4>
                                                        <p class="card-text shipping">
                                                            {{-- <span class="badge rounded-pill badge-light-success">Free Shipping</span> --}}
                                                        </p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection



@push('script')
<script src="{{asset('app-assets/vendors/js/forms/wizard/bs-stepper.min.js')}}"></script>

<script src="{{asset('app-assets/js/scripts/pages/app-ecommerce-checkout.js')}}"></script>

@endpush

