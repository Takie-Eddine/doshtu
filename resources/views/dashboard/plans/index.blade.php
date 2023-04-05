@extends('dashboard.layouts.dashboard')

@section('title','Plan')


@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/pages/page-pricing.css')}}">
@endpush

@section('content')

<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section id="pricing-plan">
                <!-- title text and switch button -->
                <div class="text-center">

                    <h1 class="mt-5">Pricing Plans</h1>
                    <p class="mb-2 pb-75">
                        <a class="btn btn-primary mt-2 mt-lg-3" href="{{ route('admin.plans.create') }}">Create</a>
                    </p>


                    {{-- <div class="d-flex align-items-center justify-content-center mb-5 pb-50">
                        <h6 class="me-1 mb-0">Monthly</h6>
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="priceSwitch" />
                            <label class="form-check-label" for="priceSwitch"></label>
                        </div>
                        <h6 class="ms-50 mb-0">Annually</h6>
                    </div> --}}
                </div>
                <!--/ title text and switch button -->

                <!-- pricing plan cards -->
                <div class="row pricing-card">
                    @include('dashboard.layouts.alerts.flash')
                    <div class="col-12 col-sm-offset-2 col-sm-10 col-md-12 col-lg-offset-2 col-lg-10 mx-auto">
                        <div class="row">
                            @forelse ($plans as $plan)
                                <div class="col-12 col-md-4">
                                    <div class="card standard-pricing popular text-center">
                                        <div class="card-body">
                                            <img src="{{asset('app-assets/images/illustration/Pot2.svg')}}" class="mb-1" alt="svg img" />
                                            <h1 > <b>{{$plan->name}}</b></h1>
                                            {{-- <p class="card-text">For small to medium businesses</p> --}}
                                            <div class="annual-plan">
                                                <div class="plan-price mt-2">
                                                    <sup class="font-medium-1 fw-bold text-primary">$</sup>
                                                    <span class="pricing-standard-value fw-bolder text-primary">{{$plan->monthly_price}}</span>
                                                    <sub class="pricing-duration text-body font-medium-1 fw-bold">/month</sub>
                                                </div>
                                                <div class="plan-price mt-2">
                                                    <sup class="font-medium-1 fw-bold text-secondary">$</sup>
                                                    <span class="pricing-standard-value fw-bolder text-secondary">{{$plan->annual_price}}</span>
                                                    <sub class="pricing-duration text-body font-medium-1 fw-bold">/year</sub>
                                                </div>
                                                <small class="annual-pricing d-none text-muted"></small>
                                            </div>
                                            <ul class="list-group list-group-circle text-start">

                                                {!! ($plan->description) !!}
                                            </ul>
                                            <a class="btn w-100 btn-primary mt-2" href="{{route('admin.plans.edit',$plan->id)}}">Edit</a>
                                            <form action="{{route('admin.plans.destroy',$plan->id)}}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button class="btn w-100 btn-danger mt-2">delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty

                            @endforelse

                        </div>
                    </div>
                </div>

            </section>
        </div>
    </div>
</div>

@endsection


@push('script')
    <script src="{{asset('app-assets/js/scripts/pages/page-pricing.js')}}"></script>
@endpush
