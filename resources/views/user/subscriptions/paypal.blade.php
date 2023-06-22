@extends('user.layouts.user')

@section('title', 'Subscription')

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
                        <h2 class="content-header-title float-start mb-0">Subscription</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item active"><a
                                        href="{{route('user.subscribe.create')}}">Subscription</a>
                                </li>
                                <li class="breadcrumb-item"><a>payment</a>
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
                            <div class="card-header">
                                <h4 class="card-title">Plan</h4>
                            </div>
                            <div class="card-body">
                                <div class="mb-2 pb-50">
                                    <h5>
                                        You have chosen
                                        <strong> {{$plan->name}} </strong>
                                        plan
                                    </h5>
                                </div>
                                <form class="form" action="{{route('user.subscribe.post')}}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <input class="custom-option-item-check" type="radio" name="plans"
                                                id="basicPlan" value="annual" checked />
                                            <label class="custom-option-item text-center p-1" for="basicPlan">
                                                <span class="custom-option-item-title h5 fw-bolder">Annual</span>
                                            </label>
                                            <input class="custom-option-item-check" type="radio" name="plans"
                                                id="standardPlan" value="month" />
                                            <label class="custom-option-item text-center p-1" for="standardPlan">
                                                <span class="custom-option-item-title h5 fw-bolder">Monthly</span>
                                            </label>
                                        </div>

                                        <div class="col-md-6 col-12">
                                        </div>

                                        <div class="col-md-6 col-12 mt-2">
                                            <div id="paypal-button-container"></div>
                                        </div>


                                        {{-- <div class="col-12">
                                            <button type="submit" class="btn btn-primary me-1">Submit</button>
                                            <button type="reset" class="btn btn-outline-secondary">Reset</button>
                                        </div> --}}
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
<script src="{{asset('app-assets/js/scripts/pages/page-pricing.js')}}"></script>
<script src="{{asset('app-assets/js/scripts/pages/page-account-settings-billing.js')}}"></script>
<script data-sdk-integration-source="integrationbuilder_sc"></script>
<script
    src="https://www.paypal.com/sdk/js?client-id=AbyorskkCd14rgLBa4xd-lDvS68shzowwh2zs687C4rCrGEQTFule6JmPDzdC4A71SPlUfrLrWAzzT2B&components=buttons&vault=true&intent=subscription">
</script>
<script>
    const FUNDING_SOURCES = [
      // // EDIT FUNDING SOURCES
        paypal.FUNDING.PAYPAL,
        paypal.FUNDING.CARD
    ];
    var plan = @json($plan);
    FUNDING_SOURCES.forEach(fundingSource => {
        paypal.Buttons({
            fundingSource,

            style: {
                layout: 'vertical',
                shape: 'rect',
                color: (fundingSource == paypal.FUNDING.PAYLATER) ? 'gold' : '',
            },

            // createOrder: async (data, actions) => {
            //   try {
            //     const response = await fetch("http://localhost:9597/orders", {
            //       method: "POST"
            //     });

            //     const details = await response.json();
            //     return details.id;
            //   } catch (error) {
            //     console.error(error);
            //     // Handle the error or display an appropriate error message to the user
            //   }
            // },



            createSubscription: (data, actions) => {
                return actions.subscription.create({
                    plan_id: "{{$plan->paypal_id_annual}}",
                });
            },



            onApprove: async (data, actions) => {
                try {
                    const response = await fetch(`http://localhost:9597/orders/${data.orderID}/capture`, {
                        method: "POST"
                    });

                    const details = await response.json();
                    // Three cases to handle:
                    //   (1) Recoverable INSTRUMENT_DECLINED -> call actions.restart()
                    //   (2) Other non-recoverable errors -> Show a failure message
                    //   (3) Successful transaction -> Show confirmation or thank you message

                    // This example reads a v2/checkout/orders capture response, propagated from the server
                    // You could use a different API or structure for your 'orderData'
                    const errorDetail = Array.isArray(details.details) && details.details[0];

                    if (errorDetail && errorDetail.issue === 'INSTRUMENT_DECLINED') {
                        return actions.restart();
                        // https://developer.paypal.com/docs/checkout/integration-features/funding-failure/
                    }

                    if (errorDetail) {
                        let msg = 'Sorry, your transaction could not be processed.';
                        msg += errorDetail.description ? ' ' + errorDetail.description : '';
                        msg += details.debug_id ? ' (' + details.debug_id + ')' : '';
                        alert(msg);
                    }

                    // Successful capture! For demo purposes:
                    console.log('Capture result', details, JSON.stringify(details, null, 2));
                    const transaction = details.purchase_units[0].payments.captures[0];
                    alert('Transaction ' + transaction.status + ': ' + transaction.id + 'See console for all available details');
                } catch (error) {
                        console.error(error);
                    // Handle the error or display an appropriate error message to the user
                }
            },
        }).render("#paypal-button-container");
    })
</script>
@endpush
