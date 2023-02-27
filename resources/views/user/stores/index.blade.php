@extends('user.layouts.user')

@section('title', 'User')

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
                        <h2 class="content-header-title float-start mb-0">User</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Users
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
            @include('user.layouts.alerts.flash')
            <!-- Basic Tables start -->
            <div class="card-body">
                <a href="{{route('user.stores.create')}}" class="btn btn-sm btn-primary btn-rounded btn-fw mr-2">Create</a>
            </div>
            <div class="card">

                <div class="card-header border-bottom">
                    <h4 class="card-title"> Stores</h4>
                </div>
                <form action="" method="POST">
                    @csrf
                    <div class="card-body pt-2">
                        <p>Chose default store</p>

                        <!-- Connections -->
                        @forelse ($stores as $store)
                        <div class="d-flex mt-2">
                            <div class="flex-shrink-0">
                                <img src="{{$store->image_url}}" alt="" class="me-1" height="38" width="38" />
                            </div>
                            <div class="d-flex align-item-center justify-content-between flex-grow-1">
                                <div class="me-1">
                                    <p class="fw-bolder mb-0">{{$store->store_name}}</p>
                                    <span>Calendar and contacts</span>
                                </div>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{route('user.stores.edit',$store->id)}}"
                                        class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">edit</a>

                                        @if ($store->default == 0)
                                            <a href="{{route('user.stores.default',$store->id)}}"
                                                class="btn btn-outline-info btn-min-width box-shadow-3 mr-1 mb-1">Default</a>
                                        @endif

                                        <form action="{{route('user.stores.delete',$store->id)}}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">delete</button>
                                        </form>
                                    </div>
                            </div>
                        </div>
                        @empty
                            <div>
                                <span>No stores defined.</span>
                            </div>
                        @endforelse ()

                        <!-- /Connections -->
                    </div>
                </form>
            </div>


        </div>
    </div>
</div>


@endsection
