@extends('user.layouts.user')

@section('title', 'Subscribe')

@push('style')
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/core/menu/menu-types/vertical-menu.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/pages/page-pricing.css')}}">
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
                        <h2 class="content-header-title float-start mb-0">Subscribe </h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a>Subscribe</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">

            </div>
    </div>

        <div class="content-header row">
        </div>
        <div class="content-body">
            <section id="pricing-plan">
                <!-- title text and switch button -->
                <div class="text-center">
                    <h1 class="mt-5">Payment</h1>
                    <p class="mb-2 pb-75">
                        {{-- All plans include 40+ advanced tools and features to boost your product. Choose the best plan to fit your needs. --}}
                    </p>
                    <div class="d-flex align-items-center justify-content-center mb-5 pb-50">
                    </div>
                </div>
                <!--/ title text and switch button -->

                <!-- pricing plan cards -->
                @include('user.layouts.alerts.flash')
                <div class="card">
                    <div class="card-header border-bottom">
                        <h4 class="card-title">Payment Methods</h4>
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
                    <div class="card-body my-1 py-25">
                        <div class="row gx-4">
                            <div class="col-lg-6">
                                <form id="creditCardForm" class="row gx-2 gy-1 validate-form" method="POST" action="{{route('user.subscribe.payment.store')}}" >
                                    @csrf
                                    {{-- onsubmit="return false" --}}
                                    <div class="col-12">
                                        <div class="form-check form-check-inline mb-1">
                                            <input name="collapsible-payment" class="form-check-input" type="radio" id="collapsible-payment-cc" checked />
                                            <label class="form-check-label" for="collapsible-payment-cc">Credit/Debit/ATM Card</label>
                                        </div>
                                        {{-- <div class="form-check form-check-inline mb-1">
                                            <input name="collapsible-payment" class="form-check-input" type="radio" value="" id="collapsible-payment-cash" />
                                            <label class="form-check-label" for="collapsible-payment-cash">PayPal account</label>
                                        </div> --}}
                                    </div>
                                    <div class="row gx-2">
                                        <div class="col-12 mb-1">
                                            <label class="form-label" for="addCardNumber">Card
                                                Number</label>
                                            <div class="input-group input-group-merge">
                                                <input id="addCardNumber" name="addCard"
                                                    class="form-control credit-card-mask" type="text"
                                                    placeholder="1356 3215 6548 7898"
                                                    aria-describedby="addCard"
                                                    data-msg="Please enter your credit card number" value="{{old('addCard')}}" />
                                                <span class="input-group-text cursor-pointer p-25"
                                                    id="addCard">
                                                    <span class="card-type"></span>
                                                </span>
                                                @error('addCard')
                                                <span class="text-danger"> {{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-1">
                                            <label class="form-label" for="addCardName">Name On
                                                Card</label>
                                            <input type="text" id="addCardName" name="card_name" class="form-control"
                                                placeholder="John Doe" value="{{old('card_name')}}" />
                                                @error('card_name')
                                                <span class="text-danger"> {{ $message }}</span>
                                                @enderror
                                        </div>

                                        <div class="col-6 col-md-3 mb-1">
                                            <label class="form-label" for="addCardExpiryDate">Exp.
                                                Date</label>
                                            <input type="text" id="addCardExpiryDate" name="card_exp"
                                                class="form-control expiry-date-mask"
                                                placeholder="MM/YY" value="{{old('card_exp')}}"/>
                                                @error('card_exp')
                                                <span class="text-danger"> {{ $message }}</span>
                                                @enderror
                                        </div>

                                        <div class="col-6 col-md-3 mb-1">
                                            <label class="form-label" for="addCardCvv">CSV</label>
                                            <input type="text" id="addCardCvv" name="csv"
                                                class="form-control cvv-code-mask" maxlength="3"
                                                placeholder="654" value="{{old('csv')}}"/>
                                                @error('csv')
                                                <span class="text-danger"> {{ $message }}</span>
                                                @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="d-flex align-items-center">
                                            <div class="form-check form-switch form-check-primary me-25">
                                                <input type="checkbox" class="form-check-input" id="addSaveCard" name="save" checked />
                                                <label class="form-check-label" for="addSaveCard">
                                                    <span class="switch-icon-left"><i data-feather="check"></i></span>
                                                    <span class="switch-icon-right"><i data-feather="x"></i></span>
                                                </label>
                                            </div>
                                            <label class="form-check-label fw-bolder" for="addSaveCard"> Save Card for future billing? </label>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2 pt-1">
                                        <button type="submit" class="btn btn-primary me-1">Save Changes</button>
                                        <button type="reset" class="btn btn-outline-secondary">Discard</button>
                                    </div>
                                    <div></div>
                                    <input type="hidden" />
                                </form>
                            </div>
                            {{-- <div class="col-lg-6 mt-2 mt-lg-0">
                                <h6 class="fw-bolder mb-2">My Cards</h6>
                                <div class="added-cards">
                                    <div class="cardMaster rounded border p-2 mb-1">
                                        <div class="d-flex justify-content-between flex-sm-row flex-column">
                                            <div class="card-information">
                                                <img class="mb-1 img-fluid" src="../../../app-assets/images/icons/payments/mastercard.png" alt="Master Card" />
                                                <div class="d-flex align-items-center mb-50">
                                                    <h6 class="mb-0">Tom McBride</h6>
                                                    <span class="badge badge-light-primary ms-50">Primary</span>
                                                </div>
                                                <span class="card-number">∗∗∗∗ ∗∗∗∗ 9856</span>
                                            </div>
                                            <div class="d-flex flex-column text-start text-lg-end">
                                                <div class="d-flex order-sm-0 order-1 mt-1 mt-sm-0">
                                                    <button class="btn btn-outline-primary me-75" data-bs-toggle="modal" data-bs-target="#editCard">
                                                        Edit
                                                    </button>
                                                    <button class="btn btn-outline-secondary">Delete</button>
                                                </div>
                                                <span class="mt-2">Card expires at 12/24</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cardMaster border rounded p-2">
                                        <div class="d-flex justify-content-between flex-sm-row flex-column">
                                            <div class="card-information">
                                                <img class="mb-1 img-fluid" src="../../../app-assets/images/icons/payments/visa.png" alt="Visa Card" />
                                                <h6>Mildred Wagner</h6>
                                                <span class="card-number">∗∗∗∗ ∗∗∗∗ 5896</span>
                                            </div>
                                            <div class="d-flex flex-column text-start text-lg-end">
                                                <div class="d-flex order-sm-0 order-1 mt-1 mt-sm-0">
                                                    <button class="btn btn-outline-primary me-75" data-bs-toggle="modal" data-bs-target="#editCard">
                                                        Edit
                                                    </button>
                                                    <button class="btn btn-outline-secondary">Delete</button>
                                                </div>
                                                <span class="mt-2">Card expires at 02/24</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>



@endsection




@push('script')

    <script src="{{ asset('/app-assets/vendors/js/forms/wizard/bs-stepper.min.js') }}"></script>
    <script src="{{ asset('/app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
    <script src="{{ asset('/app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('/app-assets/vendors/js/forms/cleave/cleave.min.js') }}"></script>
    <script src="{{ asset('/app-assets/vendors/js/forms/cleave/addons/cleave-phone.us.js') }}"></script>

    <script src="{{ asset('/app-assets/js/scripts/pages/auth-register.js') }}"></script>


@endpush
