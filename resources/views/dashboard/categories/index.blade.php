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
                        <a href="{{route('admin.categories.create')}}" class="btn btn-sm btn-primary btn-rounded btn-fw mr-2">Create</a>
                        <a href="{{route('admin.categories.trash')}}" class="btn btn-sm btn-dark btn-rounded btn-fw">Trash</a>
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
                        @include('dashboard.categories.filter.filter')
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
                                            <td><span ><b>{{$category->id}}</b></span></td>
                                            <td ><a href="{{route('admin.categories.show',$category->id)}}"><span ><b>{{$category->name}}</a></td>
                                            <td><span ><b>{{$category->parent->name }}</b></span></td>
                                            {{-- <td>{{$category->products_count }}</td> --}}
                                            <td><span ><b>{{$category->status}}</b></span></td>
                                            <td><span ><b>{{$category->created_at}}</b></span></td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                <a href="{{route('admin.categories.edit',$category->id)}}"
                                                    class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">edit</a>
                                                    <form action="{{route('admin.categories.destroy',$category->id)}}" method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @forelse ($category->children as $children)
                                            <tr>
                                                <td><img src="{{$children->image_url}}" height="100" width="100" ></td>
                                                <td>{{$children->id}}</td>
                                                <td ><a href="{{route('admin.categories.show',$children->id)}}">- {{$children->name}} </a></td>
                                                <td>{{$children->parent->name }}</td>
                                                {{-- <td>{{$category->products_count }}</td> --}}
                                                <td>{{$children->status}}</td>
                                                <td>{{$children->created_at}}</td>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a href="{{route('admin.categories.edit',$children->id)}}"
                                                        class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">edit</a>
                                                        <form action="{{route('admin.categories.destroy',$children->id)}}" method="POST">
                                                            @csrf
                                                            @method('delete')
                                                            <button class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">delete</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                                @forelse ($children->children as $child)
                                                <tr>
                                                    <td><img src="{{$child->image_url}}" height="100" width="100" ></td>
                                                    <td>{{$child->id}}</td>
                                                    <td ><a href="{{route('admin.categories.show',$child->id)}}">--{{$child->name}} </a></td>
                                                    <td>{{$child->parent->name }}</td>
                                                    {{-- <td>{{$category->products_count }}</td> --}}
                                                    <td>{{$child->status}}</td>
                                                    <td>{{$child->created_at}}</td>
                                                    <td>
                                                        <div class="btn-group" role="group" aria-label="Basic example">
                                                        <a href="{{route('admin.categories.edit',$child->id)}}"
                                                            class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">edit</a>
                                                            <form action="{{route('admin.categories.destroy',$child->id)}}" method="POST">
                                                                @csrf
                                                                @method('delete')
                                                                <button class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">delete</button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                                    @forelse ($child->children as $item)
                                                    <tr>
                                                        <td><img src="{{$item->image_url}}" height="100" width="100" ></td>
                                                        <td>{{$item->id}}</td>
                                                        <td ><a href="{{route('admin.categories.show',$item->id)}}">---{{$item->name}} </a></td>
                                                        <td>{{$item->parent->name }}</td>
                                                        {{-- <td>{{$category->products_count }}</td> --}}
                                                        <td>{{$item->status}}</td>
                                                        <td>{{$item->created_at}}</td>
                                                        <td>
                                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                            <a href="{{route('admin.categories.edit',$item->id)}}"
                                                                class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">edit</a>
                                                                <form action="{{route('admin.categories.destroy',$item->id)}}" method="POST">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">delete</button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @forelse ($item->children as $value)
                                                        <tr>
                                                            <td><img src="{{$value->image_url}}" height="100" width="100" ></td>
                                                            <td>{{$value->id}}</td>
                                                            <td ><a href="{{route('admin.categories.show',$value->id)}}">----{{$value->name}} </a></td>
                                                            <td>{{$value->parent->name }}</td>
                                                            {{-- <td>{{$category->products_count }}</td> --}}
                                                            <td>{{$value->status}}</td>
                                                            <td>{{$value->created_at}}</td>
                                                            <td>
                                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                                <a href="{{route('admin.categories.edit',$value->id)}}"
                                                                    class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">edit</a>
                                                                    <form action="{{route('admin.categories.destroy',$value->id)}}" method="POST">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <button class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">delete</button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                    @endforelse
                                                @empty
                                                @endforelse
                                            @empty
                                            @endforelse
                                        @empty
                                        @endforelse
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


