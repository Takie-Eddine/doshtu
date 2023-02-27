@extends('dashboard.layouts.dashboard')

@section('title','Edit')


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
                                <li class="breadcrumb-item active"><a >Edit</a>
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
            <!-- Basic multiple Column Form section start -->
            <section id="multiple-column-form">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            @include('dashboard.layouts.alerts.flash')
                            <div class="card-header">
                                <h4 class="card-title">Edit {{$category->name}}</h4>
                            </div>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <h5>Error Occured!</h5>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{$error}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            <div class="card-body">
                                <form class="form" action="{{route('admin.categories.update',$category->id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="first-name-column">Arabic Name</label>
                                                <input type="text" id="first-name-column" class="form-control" placeholder="Arabic Name" name="name_ar" value="{{$category->getTranslation('name','ar')}}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="last-name-column">English Name</label>
                                                <input type="text" id="last-name-column" class="form-control" placeholder="English Name" name="name_en" value="{{$category->getTranslation('name','en')}}" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" class="d-block">Category Parent</label>
                                                <select name="parent_id" class="form-control" id="">
                                                    <option value="">Primary Category</option>
                                                    @foreach ($categories as $parent)
                                                        <option value="{{$parent->id }}" @selected($category->parent_id == $parent->id)>{{$parent->name }}</option>
                                                    @endforeach
                                                </select>
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" class="d-block">Status</label>
                                                <select name="status" class="form-control" id="">
                                                    <option value="active" {{$category->status == 'active' ? 'selected' : null}} >Active</option>
                                                    <option value="archived" {{$category->status == 'archived' ? 'selected' : null}} >Archived</option>
                                                </select>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="first-name-column">Description</label>
                                                <textarea name="description" id="textarea-counter" class="form-control char-textarea" cols="30" rows="2">{{$category->description}}</textarea>
                                            </div>
                                            <small class="textarea-counter-value float-end"><span class="char-count">0</span> / 10 </small>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="mb-1">
                                                <input type="file" id="last-name-column" id="category-images" class="file" data-preview-file-type="text" placeholder="" name="image" />
                                                <span class="form-text text-muted">Image width should be 500px x 500px</span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary me-1">Submit</button>
                                            <button type="reset" class="btn btn-outline-secondary">Reset</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Basic Floating Label Form section end -->

        </div>
    </div>
</div>

@endsection


@push('script')

@endpush
