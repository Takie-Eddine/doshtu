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
            <div class="row" id="basic-table">
                <div class="col-12">
                    <div class="card-body">
                        <a href="{{route('user.user.create')}}" class="btn btn-sm btn-primary btn-rounded btn-fw mr-2">Create</a>
                    </div>
                    <div class="card">

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Store</th>
                                        <th>Role</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)
                                        <tr>
                                            <td>
                                                <span class="fw-bold">{{$user->id}}</span>
                                            </td>
                                            <td>
                                                <span class="fw-bold">{{$user->name}}</span>
                                            </td>
                                            <td>
                                                <span class="fw-bold">{{$user->email}}</span>
                                            </td>
                                            <td>
                                            @forelse ($user->stores as $item)
                                                <span class="fw-bold">{{$item->store_name}} ,</span>
                                            @empty
                                            </td>

                                            @endforelse

                                            <td>
                                                <span class="fw-bold">{{$user->role->name}}</span>
                                            </td>
                                            {{-- <td>
                                                <div class="avatar">
                                                    <div data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar pull-up my-0" title="Alberto Glotzbach">
                                                        <img src="{{asset('assets/images/users/' .$user->image)}}" alt="Avatar" height="50" width="50" />
                                                    </div>
                                                </div>
                                            </td> --}}
                                            <td>
                                                <div class="btn-group" role="group"
                                                                    aria-label="Basic example">
                                                                    <a href="{{route('user.user.edit',$user->id)}}"
                                                                    class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">edit</a>


                                                                    <a href="{{route('user.user.view',$user->id)}}"
                                                                    class="btn btn-outline-info btn-min-width box-shadow-3 mr-1 mb-1">view</a>

                                                                    <form action="{{route('user.user.delete',$user->id)}}" method="POST">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <button class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">delete</button>
                                                                    </form>
                                                                    {{-- <a href="{{route('user.user.delete',$user->id)}}"
                                                                        class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">delete</a> --}}

                                                        </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7">No users defined.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>


@endsection
