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
                    <h1 class="mt-5">Pricing Plans</h1>
                    <p class="mb-2 pb-75">
                        {{-- All plans include 40+ advanced tools and features to boost your product. Choose the best plan to fit your needs. --}}
                    </p>
                    <div class="d-flex align-items-center justify-content-center mb-5 pb-50">
                    </div>
                </div>
                <!--/ title text and switch button -->

                <!-- pricing plan cards -->
                @include('user.layouts.alerts.flash')
                <div class="row pricing-card">
                    <div class="col-12 col-sm-offset-2 col-sm-10 col-md-12 col-lg-offset-2 col-lg-10 mx-auto">
                        <div class="row">
                            @foreach ($plans as $item)
                                <div class="col-12 col-md-3">
                                    <div class="card standard-pricing popular text-center">

                                        <div class="card-body">
                                            @if ($item->image)
                                                <img src="{{asset('assets/plan_images/'.$item->image)}}" class="mb-1" alt="svg img" />
                                            @else
                                                <img src="{{asset('app-assets/images/illustration/Pot2.svg')}}" class="mb-1" alt="svg img" />
                                            @endif
                                            <h3>{{$item->name}}</h3>
                                            <p class="card-text">For small to medium businesses</p>
                                            <div class="annual-plan">
                                                <div class="plan-price mt-2">
                                                    <sup class="font-medium-1 fw-bold text-primary">$</sup>
                                                    <span class="pricing-standard-value fw-bolder text-primary">{{$item->monthly_price}}</span>
                                                    <sub class="pricing-duration text-body font-medium-1 fw-bold">/month</sub>
                                                </div>
                                                <small class="annual-pricing d-none text-muted"></small>
                                            </div>
                                            <div class="annual-plan">
                                                <div class="plan-price mt-2">
                                                    <sup class="font-medium-1 fw-bold text-primary">$</sup>
                                                    <span class="pricing-standard-value fw-bolder text-primary">{{$item->annual_price}}</span>
                                                    <sub class="pricing-duration text-body font-medium-1 fw-bold">/year</sub>
                                                </div>
                                                <small class="annual-pricing d-none text-muted"></small>
                                            </div>
                                            <ul class="list-group list-group-circle text-start">
                                                {!!($item->description)!!}
                                            </ul>
                                            <a href="{{route('user.subscribe.pay',$item->id)}}" class="btn btn-primary mt-2 mt-lg-3">Choose your plan</a>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                            {{-- <div class="pricing-free-trial">
                                <div class="row">
                                    <div class="col-12 col-lg-10 col-lg-offset-3 mx-auto">
                                        <div class="pricing-trial-content d-flex justify-content-between">
                                            <div class="text-center text-md-start mt-3">
                                                <h3 class="text-primary"></h3>
                                                <h5></h5>
                                                <a href="{{route('user.subscribe.pay')}}" class="btn btn-primary mt-2 mt-lg-3">Choose your plan</a>
                                            </div>

                                            <!-- image -->
                                            <img src="{{asset('app-assets/images/illustration/pricing-Illustration.svg')}}" class="pricing-trial-img img-fluid" alt="svg img" />
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                        {{-- <div class="row custom-options-checkable gx-3 gy-2">
                            @forelse ($plans as $plan)
                                <div class="col-md-4">
                                    <input class="custom-option-item-check" type="radio" name="plans" id="basicPlan" value="" />
                                    <label class="custom-option-item text-center p-1" for="basicPlan">
                                        <span class="custom-option-item-title h3 fw-bolder">{{$plan->name}}</span>
                                        <span class="d-block m-75">{!!$plan->description!!}</span>
                                        <span class="plan-price">
                                            <sup class="font-medium-1 fw-bold text-primary">$</sup>
                                            <span class="pricing-value fw-bolder text-primary">{{$plan->monthly_price}}</span>
                                            <sub class="pricing-duration text-body font-medium-1 fw-bold">/month</sub>
                                        </span>
                                    </label>
                                </div>
                            @empty
                            @endforelse
                        </div> --}}
                    </div>
                </div>


                <div class="pricing-faq">
                    <h3 class="text-center">FAQ's</h3>
                    <p class="text-center">Let us help answer the most common questions.</p>
                    <div class="row my-2">
                        <div class="col-12 col-lg-10 col-lg-offset-2 mx-auto">
                            <!-- faq collapse -->
                            <div class="accordion accordion-margin" id="accordionExample">
                                <div class="card accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button collapsed" data-bs-toggle="collapse" role="button" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                            Does my subscription automatically renew?
                                        </button>
                                    </h2>

                                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            Pastry pudding cookie toffee bonbon jujubes jujubes powder topping. Jelly beans gummi bears sweet roll
                                            bonbon muffin liquorice. Wafer lollipop sesame snaps. Brownie macaroon cookie muffin cupcake candy
                                            caramels tiramisu. Oat cake chocolate cake sweet jelly-o brownie biscuit marzipan. Jujubes donut
                                            marzipan chocolate bar. Jujubes sugar plum jelly beans tiramisu icing cheesecake.
                                        </div>
                                    </div>
                                </div>
                                <div class="card accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" data-bs-toggle="collapse" role="button" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Can I store the item on an intranet so everyone has access?
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            Tiramisu marshmallow dessert halvah bonbon cake gingerbread. Jelly beans chocolate pie powder. Dessert
                                            pudding chocolate cake bonbon bear claw cotton candy cheesecake. Biscuit fruitcake macaroon carrot cake.
                                            Chocolate cake bear claw muffin chupa chups pudding.
                                        </div>
                                    </div>
                                </div>
                                <div class="card accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" data-bs-toggle="collapse" role="button" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            Am I allowed to modify the item that I purchased?
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            Tart gummies dragée lollipop fruitcake pastry oat cake. Cookie jelly jelly macaroon icing jelly beans
                                            soufflé cake sweet. Macaroon sesame snaps cheesecake tart cake sugar plum. Dessert jelly-o sweet muffin
                                            chocolate candy pie tootsie roll marzipan. Carrot cake marshmallow pastry. Bonbon biscuit pastry topping
                                            toffee dessert gummies. Topping apple pie pie croissant cotton candy dessert tiramisu.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>



@endsection




@push('script')
<script data-sdk-integration-source="integrationbuilder_sc"></script>
<script src="{{asset('app-assets/js/scripts/pages/page-pricing.js')}}"></script>
<script src="https://www.paypal.com/sdk/js?client-id=AbyorskkCd14rgLBa4xd-lDvS68shzowwh2zs687C4rCrGEQTFule6JmPDzdC4A71SPlUfrLrWAzzT2B&components=buttons&vault=true&intent=subscription"></script>
<script>
    const FUNDING_SOURCES = [
      // // EDIT FUNDING SOURCES
        paypal.FUNDING.PAYPAL,
        paypal.FUNDING.CARD
    ];
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
            plan_id: "P-3VY541363X5493216MQPMXBQ",
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
