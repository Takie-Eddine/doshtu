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
                                <li class="breadcrumb-item active"> Subscription
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
            <div class="row">
                <div class="col-12">

                    <!-- profile -->
                    @include('user.layouts.alerts.flash')
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Current plan</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-2 pb-50">
                                        <h5>Your Current Plan is <strong>{{$subscription->plan->name}}</strong></h5>
                                        <span></span>
                                    </div>
                                    <div class="mb-2 pb-50">
                                        <h5>Active until {{$subscription->ended_date}}</h5>
                                        <span>We will send you a notification upon Subscription expiration</span>
                                    </div>
                                    {{-- <div class="mb-2 mb-md-1">
                                        <h5>$ Per Month <span class="badge badge-light-primary ms-50">Popular</span></h5>
                                        <span></span>
                                    </div> --}}
                                </div>
                                <div class="col-md-6">
                                    @php
                                        $srt1 = Illuminate\Support\Carbon::parse($subscription->started_date);
                                        $start = Illuminate\Support\Carbon::now();
                                        $end = Illuminate\Support\Carbon::parse($subscription->ended_date);
                                        $diffe = $start->diffInDays($end);
                                        $days = $srt1->diffInDays($end);
                                    @endphp
                                    @if ($diffe<15 && $diffe>2)
                                        <div class="alert alert-warning mb-2" role="alert">
                                            <h6 class="alert-heading">We need your attention!</h6>
                                            <div class="alert-body fw-normal">your plan requires update</div>
                                        </div>
                                    @endif

                                    @if ($diffe>15)
                                        <div class="alert alert-success mb-2" role="alert">
                                            <h6 class="alert-heading">We need your attention!</h6>
                                            <div class="alert-body fw-normal">your plan is up to date </div>
                                        </div>
                                    @endif

                                    @if ($diffe<=2)
                                        <div class="alert alert-danger mb-2" role="alert">
                                            <h6 class="alert-heading">We need your attention!</h6>
                                            <div class="alert-body fw-normal">your plan requires update</div>
                                        </div>
                                    @endif

                                    <div class="plan-statistics pt-1">
                                        <div class="d-flex justify-content-between">
                                            <h5 class="fw-bolder">Days</h5>
                                            <h5 class="fw-bolder">{{$diffe}} of {{$days}} Days</h5>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar " style="width: {{($diffe/$days)*100}}%" role="progressbar" aria-valuenow="75" aria-valuemin="75" aria-valuemax="100"></div>
                                        </div>
                                        <p class="mt-50">{{$diffe}} days remaining until your plan requires update</p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <a href="{{route('user.subscription.upgrade',$subscription->id)}}" class="btn btn-primary me-1 mt-1" > Upgrade Plan </a>
                                    <a href="{{route('user.subscription.cancel',$subscription->id)}}" class="btn btn-outline-danger cancel-subscription mt-1">Cancel Subscription</a>
                                </div>
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
<script src="{{asset('app-assets/js/scripts/pages/page-pricing.js')}}"></script>
<script src="{{asset('app-assets/js/scripts/pages/page-account-settings-billing.js')}}"></script>
@endpush



