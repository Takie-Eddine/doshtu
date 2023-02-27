@extends('user.layouts.user')

@section('title', 'Complaints')

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
                        <h2 class="content-header-title float-start mb-0">Complaint</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Complaints
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
            <!-- Basic Tables start -->
            <div class="row" id="basic-table">
                <div class="col-12">
                    <div class="card-body">
                        <a href="{{route('user.complaints.newcomplaint')}}" class="btn btn-sm btn-primary btn-rounded btn-fw mr-2">Create</a>
                    </div>
                    <div class="card">

                        @include('user.layouts.alerts.flash')
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        {{-- <th>Store Name</th> --}}
                                        <th>Product Name</th>
                                        <th>Title</th>
                                        <th>Body</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($complaints && $complaints->count()>0)
                                        @foreach ($complaints as $complaint)
                                        <tr>
                                            <td>
                                                <span class="fw-bold">{{$complaint->id}}</span>
                                            </td>
                                            {{-- <td>
                                                <span class="fw-bold">{{$complaint->store->store_name}}</span>
                                            </td> --}}
                                            <td>
                                                <span class="fw-bold">{{$complaint->product->name ?? '--'}}</span>
                                            </td>
                                            <td>
                                                <span class="fw-bold">{{$complaint->title}}</span>
                                            </td>
                                            <td>
                                                <span class="fw-bold">{{\Illuminate\Support\Str::limit(strip_tags($complaint->body), 50)}}
                                                    @if (strlen(strip_tags($complaint->body)) > 50)
                                                    ... <a href="{{route('client.complaint.view',$complaint->id) }}" class="btn btn-info btn-sm">Read More</a>
                                                    @endif</span>
                                            </td>

                                            <td>
                                                <div class="btn-group" role="group"
                                                                    aria-label="Basic example">
                                                                    {{-- <a href="{{route('client.complaint.respond',$complaint->id)}}"
                                                                    class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">respond</a> --}}


                                                                    <a href="{{route('client.complaints.view',$complaint->id)}}"
                                                                        class="btn btn-outline-info btn-min-width box-shadow-3 mr-1 mb-1">view</a>

                                                        </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif
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
