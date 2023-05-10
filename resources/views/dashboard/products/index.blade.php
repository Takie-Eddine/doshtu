@extends('dashboard.layouts.dashboard')

@section('title','Products')


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
                        <h2 class="content-header-title float-start mb-0">Product</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Products
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
                    <div class="mb-5">
                        <a href="{{route('admin.products.create')}}" class="btn btn-sm btn-primary btn-rounded btn-fw mr-2">Create</a>
                        <a href="{{route('admin.products.trash')}}" class="btn btn-sm btn-dark btn-rounded btn-fw">Trash</a>
                    </div>
                    {{-- <form action="{{URL::current()}}" method="GET" class="d-flex justify-content-between mb-4">
                        <input type="text" name="name"  placeholder="Name" class="form-control mx-2" value="{{request('name')}}">
                        <select name="status" class="form-control mx-2">
                            <option value="">All</option>
                            <option value="active" @selected(request('status') == 'active')>Active</option>
                            <option value="inactive" @selected(request('status') == 'inactive')>Inactive</option>
                        </select>
                        <button class="btn  btn-dark mx-2" > <i data-feather='search'></i></button>
                    </form> --}}

                    <div class="card">
                        @include('dashboard.products.filter.filter')
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="col-sm">
                                                <div class="form-check mt-3">
                                                    <input class="form-check-input" type="checkbox" name="id[]" value="" id="defaultCheck" />
                                                </div>
                                            </div>
                                        </th>
                                        <th></th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Company</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th colspan="2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($products as $product)
                                        <tr>
                                            <td>
                                                <div class="col-sm">
                                                    <div class="form-check mt-3">
                                                        <input class="form-check-input" type="checkbox" value="{{$product->id}}" id="defaultCheck" />
                                                    </div>
                                                </div>
                                            </td>
                                            <td><img src="{{$product->image_url}}" height="100" width="100" ></td>
                                            <td>{{$product->id}}</td>
                                            <td ><a href="{{route('admin.products.show',$product->id)}}"> {{$product->name}} </a></td>
                                            <td>
                                                @forelse ($product->categories as $item)
                                                    {{$item->name}},
                                                @empty
                                                @endforelse
                                            </td>
                                            <td>{{$product->company->company_name }}</td>
                                            <td >
                                                @if ($product->status == 'active' )
                                                    <span class="badge rounded-pill badge-light-success me-1">{{$product->status}}</span>
                                                @endif
                                                @if ($product->status === 'inactive')
                                                    <span class="badge rounded-pill badge-light-warning me-1">{{$product->status}}</span>
                                                @endif
                                                @if ($product->status === 'archived')
                                                    <span class="badge rounded-pill badge-light-danger me-1">{{$product->status}}</span>
                                                @endif

                                            </td>
                                            <td>{{$product->created_at}}</td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a href="{{route('admin.products.edit',$product->id)}}" class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">edit</a>
                                                    <a href="{{route('admin.products.add_variant',$product->id)}}" class="btn btn-outline-secondary btn-min-width box-shadow-3 mr-1 mb-1">variant</a>
                                                    <form action="{{route('admin.products.activate',$product->id)}}" method="POST">
                                                        @csrf
                                                        @if ($product->status == 'active')
                                                            <button class="btn btn-outline-warning btn-min-width box-shadow-3 mr-1 mb-1">unactivate</button>
                                                        @endif
                                                        @if ($product->status == 'inactive')
                                                            <button class="btn btn-outline-success btn-min-width box-shadow-3 mr-1 mb-1">activate</button>
                                                        @endif
                                                    </form>
                                                    <form action="{{route('admin.products.destroy',$product->id)}}" method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">delete</button>
                                                    </form>
                                                </div>
                                            </td>
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
    </div>
</div>

@endsection



@push('script')

<script>

</script>

@endpush


