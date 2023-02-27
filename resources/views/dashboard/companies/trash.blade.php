@extends('dashboard.layouts.dashboard')

@section('title','Trash Companies')


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
                        <h2 class="content-header-title float-start mb-0">Company</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Companies
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
                        <a href="{{route('admin.companies.index')}}" class="btn btn-sm btn-primary btn-rounded btn-fw">Back</a>
                    </div>
                    <form action="{{URL::current()}}" method="GET" class="d-flex justify-content-between mb-4">
                        <input type="text" name="name"  placeholder="Name" class="form-control mx-2" value="{{request('name')}}">
                        {{-- <x-form.input name="name" placeholder="Name" class="mx-2" value="{{request('name')}}" /> --}}
                        <select name="status" class="form-control mx-2">
                            <option value="">All</option>
                            <option value="active" @selected(request('status') == 'active')>Active</option>
                            <option value="unactive" @selected(request('status') == 'unactive')>Inactive</option>
                        </select>
                        <button class="btn  btn-dark mx-2" > <i data-feather='search'></i></button>
                    </form>
                    <div class="card">

                        <div class="table-responsive">

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th colspan="2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($companies as $company)
                                        <tr>
                                            <td><img src="{{$company->image_url}}" height="100" width="100" ></td>
                                            <td>{{$company->id}}</td>
                                            <th>{{$company->company_name}}</th>
                                            <td>{{$company->is_active}}</td>
                                            <td>{{$company->created_at}}</td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                <form action="{{route('admin.companies.restore',$company->id)}}" method="POST">
                                                    @csrf
                                                    @method('put')
                                                    <button type="submit" class="btn btn-outline-info btn-min-width box-shadow-3 mr-1 mb-1 waves-effect">Restore</button>
                                                </form>
                                                <form action="{{route('admin.companies.force-delete',$company->id)}}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1 waves-effect">Delete</button>
                                                </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7">No companies defined.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div>
                                {{$companies->withQueryString()->links()}}
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

@endpush


