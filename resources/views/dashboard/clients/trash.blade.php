@extends('dashboard.layouts.dashboard')

@section('title','Trash Clients')


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
                        <h2 class="content-header-title float-start mb-0">Clients</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Clients
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
                        <a href="{{route('admin.clients.index')}}" class="btn btn-sm btn-primary btn-rounded btn-fw">Back</a>
                    </div>
                    {{-- <form action="{{URL::current()}}" method="GET" class="d-flex justify-content-between mb-4">
                        <input type="text" name="name"  placeholder="Name" class="form-control mx-2" value="{{request('name')}}">
                        <input type="text" name="email"  placeholder="email" class="form-control mx-2" value="{{request('email')}}">
                        <button class="btn  btn-dark mx-2" > <i data-feather='search'></i></button>
                    </form> --}}


                    <div class="card">
                        @include('dashboard.clients.filter.filter')
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Company</th>
                                        <th>Created At</th>
                                        <th colspan="2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $client)
                                        <tr>
                                            <td>{{$client->id}}</td>
                                            <td>{{$client->name}}</td>
                                            <td>{{$client->email}}</td>
                                            <td ><a href="{{route('admin.clients.show',$client->id)}}"> {{$client->store->store_name ?? '__'}} </a></td>
                                            <td>{{$client->created_at}}</td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                <form action="{{route('admin.clients.restore',$client->id)}}" method="POST">
                                                    @csrf
                                                    @method('put')
                                                    <button type="submit" class="btn btn-outline-info btn-min-width box-shadow-3 mr-1 mb-1 waves-effect">Restore</button>
                                                </form>
                                                <form action="{{route('admin.clients.force-delete',$client->id)}}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1 waves-effect">Delete</button>
                                                </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7">No clients defined.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="12">
                                            <div class="float-right">
                                                {{$users->withQueryString()->links()}}
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


