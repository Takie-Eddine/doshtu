@extends('dashboard.layouts.dashboard')

@section('title','Products Variant Edit')


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
                        <h2 class="content-header-title float-start mb-0">Variant</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{route('admin.products.index')}}">Products</a>
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
                                <h4 class="card-title">Edit Variant</h4>
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
                                <form action="{{route('admin.products.update_variant',$variant->id)}}" method="POST" enctype="multipart/form-data" >
                                    @csrf
                                    <div >
                                        <div data-repeater-list="values">
                                            <div data-repeater-item>
                                                <div class="row d-flex align-items-end">
                                                    @forelse ($variant->attributes as $attribute)
                                                        <div class="col-md-3 col-12">
                                                            <input type="hidden" name="attribute_id[]" id="attribute_id-{{$attribute->id}}" value="{{$attribute->option->attribute_id}}">
                                                            <div class="mb-1">
                                                                <label class="form-label" for="itemquantity">Variant</label>
                                                                <input type="text" class="form-control"  value="{{$attribute->option->value}}" id="value-{{$attribute->id}}" name="value[]"  />
                                                            </div>
                                                        </div>
                                                    @empty
                                                    @endforelse
                                                </div>
                                                <hr />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invoice-repeater">
                                        <div data-repeater-list="variants">
                                            <div data-repeater-item>
                                                <div class="row d-flex align-items-end">
                                                    <div class="col-md-5 col-12">
                                                        <div class="mb-1">
                                                            <label class="form-label" for="itemname">Attribute</label>
                                                            <select name="attributes" id="" class="form-control">
                                                                <option value="">Select Attribute</option>
                                                                @forelse ($attributes as $attribute)
                                                                    <option value="{{$attribute->id}}">{{$attribute->name}}</option>
                                                                @empty
                                                                @endforelse
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5 col-12">
                                                        <div class="mb-1">
                                                            <label class="form-label" for="itemcost">Varriant</label>
                                                            <input type="text" class="form-control" id="itemcost" aria-describedby="itemcost" name="variant" placeholder="Add Variant" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 col-12 mb-50">
                                                        <div class="mb-1">
                                                            <button class="btn btn-outline-danger text-nowrap px-1" data-repeater-delete type="button">
                                                                <i data-feather="x" class="me-25"></i>
                                                                <span>Delete</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <button class="btn btn-icon btn-primary" type="button" data-repeater-create>
                                                    <i data-feather="plus" class="me-25"></i>
                                                    <span>Add New</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <br>
                                    <div >
                                        <div data-repeater-list="values">
                                            <div data-repeater-item>
                                                <div class="row d-flex align-items-end">
                                                    <div class="col-md-3 col-12">
                                                        <div class="mb-1">
                                                            <label class="form-label" for="itemquantity">Quantity</label>
                                                            <input type="number" class="form-control" id="itemquantity" value="{{$variant->quantity}}" aria-describedby="itemquantity" name="quantity" placeholder="1" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-12">
                                                        <div class="mb-1">
                                                            <label class="form-label" for="itemquantity">SKU</label>
                                                            <input type="text" class="form-control" id="itemquantity" aria-describedby="itemquantity" name="sku" placeholder="" value="{{$variant->sku}}" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-12">
                                                        <div class="mb-1">
                                                            <label class="form-label" for="staticprice">Price</label>
                                                            <input type="number"  class="form-control" id="staticprice" name="price" value="{{$variant->price}}" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-12">
                                                        <div class="mb-1">
                                                            <label class="form-label" for="staticprice">Image</label>
                                                            <input type="file"  class="form-control" id="staticprice" name="image" value="" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr />
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                        <button class="btn btn-icon btn-primary" type="submit">
                                            save
                                        </button>
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
<script src="{{asset('app-assets/vendors/js/forms/repeater/jquery.repeater.min.js')}}"></script>
<script src="{{asset('app-assets/js/scripts/forms/form-repeater.js')}}"></script>
@endpush
