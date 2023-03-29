@extends('dashboard.layouts.dashboard')

@section('title','Categories')


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
                        <h2 class="content-header-title float-start mb-0">Manufactory</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Manufactories
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
            @include('dashboard.layouts.alerts.flash')
            <!-- Basic Tables start -->
            <div class="row" id="basic-table">
                <div class="col-12">
                    <div class="card">

                        <div class="table-responsive">

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $suppliers = $company->suppliers()->with('role','profile')->paginate();
                                    @endphp
                                    @forelse ($suppliers as $supplier)
                                        <tr>
                                            <td><img src="{{$supplier->profile->image_url}}" height="100" width="100" ></td>
                                            <td>{{$supplier->id}}</td>
                                            <td>{{$supplier->name}}</td>
                                            <td>{{$supplier->email}}</td>
                                            <td>{{$supplier->role->name}}</td>
                                            <td>{{$supplier->created_at}}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7">No companies defined.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div>
                                {{$suppliers->withQueryString()->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

{{-- <div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{$category->name}}</h4>
                        <br>
                        <div  class="table-responsive">
                            <div class="mb-5">
                                <a href="{{route('dashboard.categories.index')}}" class="btn btn-sm btn-primary btn-rounded btn-fw">Back</a>
                            </div>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Store</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        @php
                                            $products = $category->products()->with('store')->paginate(5);
                                        @endphp
                                        @forelse ($products as $product)
                                            <tr>
                                                <td><img src="{{$product->image_url}}" height="100" width="100" ></td>
                                                <td >{{$product->name}}</td>
                                                <td>{{$product->store->name }}</td>
                                                <td>{{$product->status}}</td>
                                                <td>{{$product->created_at}}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5">No categories defined.</td>
                                            </tr>
                                        @endforelse
                                </tbody>
                            </table>
                            <div>
                                {{$products->withQueryString()->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer')
</div> --}}


@endsection



@push('script')

@endpush
