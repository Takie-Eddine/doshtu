@extends('dashboard.layouts.dashboard')

@section('title', 'Tag')

@section('style')


@endsection



@section('content')


<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">Tag</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Tags
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
                    <div class="card-body">
                        <a href="{{route('admin.tags.create')}}" class="btn btn-sm btn-primary btn-rounded btn-fw mr-2">Create</a>
                    </div>
                    <div class="card">

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th colspan="2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($tags as $tag)
                                        <tr>
                                            <td>
                                                <span class="fw-bold">{{$tag->id}}</span>
                                            </td>
                                            <td>
                                                <span class="fw-bold">{{$tag->name}}</span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a href="{{route('admin.tags.edit',$tag->id)}}" class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">edit</a>
                                                    <form action="{{route('admin.tags.destroy',$tag->id)}}" method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7">No tags defined.</td>
                                        </tr>
                                    @endforelse
                                    <div>
                                        {{$tags->withQueryString()->links()}}
                                    </div>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>


@endsection
