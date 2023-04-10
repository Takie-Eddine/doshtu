@extends('dashboard.layouts.dashboard')

@section('title','Trash Categories')


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
                                <li class="breadcrumb-item active">Categories
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
                        <a href="{{route('admin.categories.index')}}" class="btn btn-sm btn-primary btn-rounded btn-fw">Back</a>
                    </div>
                    {{-- <form action="{{URL::current()}}" method="GET" class="d-flex justify-content-between mb-4">
                        <input type="text" name="name"  placeholder="Name" class="form-control mx-2" value="{{request('name')}}">
                        <select name="status" class="form-control mx-2">
                            <option value="">All</option>
                            <option value="active" @selected(request('status') == 'active')>Active</option>
                            <option value="archived" @selected(request('status') == 'archived')>Archived</option>
                        </select>
                        <button class="btn  btn-dark mx-2" > <i data-feather='search'></i></button>
                    </form> --}}


                    <div class="card">
                        <div class="card-body">
                            <form action="{{URL::current()}}" method="get">
                            <div class="row">
                                <div class="col-2">
                                    <div class="form-group">
                                        <input type="text" name="keyword" value="{{ old('keyword', request()->input('keyword')) }}" class="form-control" placeholder="Search here">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <select name="status" class="form-control">
                                            <option value="">---</option>
                                            <option value="active" {{ old('status', request()->input('status')) == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="archived" {{ old('status', request()->input('status')) == 'archived' ? 'selected' : '' }}>Archived</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <select name="sort_by" class="form-control">
                                            <option value="">---</option>
                                            <option value="id" {{ old('sort_by', request()->input('sort_by')) == 'id' ? 'selected' : '' }}>ID</option>
                                            <option value="name" {{ old('sort_by', request()->input('sort_by')) == 'name' ? 'selected' : '' }}>Name</option>
                                            <option value="created_at" {{ old('sort_by', request()->input('sort_by')) == 'created_at' ? 'selected' : '' }}>Created at</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <select name="order_by" class="form-control">
                                            <option value="">---</option>
                                            <option value="asc" {{ old('order_by', request()->input('order_by')) == 'asc' ? 'selected' : '' }}>Ascending</option>
                                            <option value="desc" {{ old('order_by', request()->input('order_by')) == 'desc' ? 'selected' : '' }}>Descending</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <div class="form-group">
                                        <select name="limit_by" class="form-control">
                                            <option value="">---</option>
                                            <option value="10" {{ old('limit_by', request()->input('limit_by')) == '10' ? 'selected' : '' }}>10</option>
                                            <option value="20" {{ old('limit_by', request()->input('limit_by')) == '20' ? 'selected' : '' }}>20</option>
                                            <option value="50" {{ old('limit_by', request()->input('limit_by')) == '50' ? 'selected' : '' }}>50</option>
                                            <option value="100" {{ old('limit_by', request()->input('limit_by')) == '100' ? 'selected' : '' }}>100</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-2"></div>
                                <div class="col-1">
                                    <div class="form-group">
                                        <button type="submit" name="submit" class="btn btn-link">Search</button>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Parent</th>
                                        {{-- <th>Products</th> --}}
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th colspan="2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($categories as $category)
                                        <tr>
                                            <td><img src="{{$category->image_url}}" height="100" width="100" ></td>
                                            <td>{{$category->id}}</td>
                                            <td>{{$category->name }}</td>
                                            {{-- <td ><a href="{{route('admin.categories.show',$category->id)}}"> {{$category->name}} </a></td> --}}
                                            <td>{{$category->parent->name }}</td>
                                            <td>{{$category->status}}</td>
                                            <td>{{$category->created_at}}</td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                <form action="{{route('admin.categories.restore',$category->id)}}" method="POST">
                                                    @csrf
                                                    @method('put')
                                                    <button type="submit" class="btn btn-outline-info btn-min-width box-shadow-3 mr-1 mb-1 waves-effect">Restore</button>
                                                </form>
                                                <form action="{{route('admin.categories.force-delete',$category->id)}}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1 waves-effect">Delete</button>
                                                </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7">No categories defined.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="12">
                                            <div class="float-right">
                                                {{$categories->withQueryString()->links()}}
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

@endpush


