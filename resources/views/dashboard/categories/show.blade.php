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
                        <h2 class="content-header-title float-start mb-0">Category</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{route('admin.categories.index')}}">Categories</a>
                                </li>
                                <li class="breadcrumb-item active"><a >Show</a>
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
            <div class="row" id="basic-table">
                <div class="col-12">
                    <div class="mb-5">
                        <a href="{{route('admin.categories.index')}}" class="btn btn-sm btn-primary btn-rounded btn-fw">Back</a>
                    </div>
                    <div class="content-body">
                        <section id="multiple-column-form">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        @include('dashboard.layouts.alerts.flash')
                                        <div class="card-header">
                                            <h4 class="card-title"> {{$category->name}}</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>ID</th>
                                                            <th>Name</th>
                                                            <th>Supplier</th>
                                                            <th>Status</th>
                                                            <th>Created At</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            //$products = $category->products()->with('company')->paginate();
                                                            foreach ($childIds as $childId) {
                                                                $products = $childId->products()->with('company')->paginate();
                                                            }
                                                        @endphp
                                                        @forelse ($products as $product)
                                                            <tr>
                                                                <td><img src="{{$product->image_url}}" height="100" width="100" ></td>
                                                                <td>{{$product->id}}</td>
                                                                <td>{{$product->name }}</td>
                                                                <td><a href="{{route('admin.companies.show',$product->company->id)}}">{{$product->company->company_name }}</a></td>
                                                                <td>{{$product->status}}</td>
                                                                <td>{{$product->created_at}}</td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="7">No products defined.</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="12">
                                                                <div class="float-right">
                                                                    {{$products->withQueryString()->links()}}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection



@push('script')

@endpush
