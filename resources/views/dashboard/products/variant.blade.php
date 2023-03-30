@extends('dashboard.layouts.dashboard')

@section('title','Products Variants')


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
                                <li class="breadcrumb-item"><a href="{{route('admin.products.index')}}">Products</a>
                                </li>
                                <li class="breadcrumb-item active">Add Variants
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
            <section class="form-control-repeater">
                @include('dashboard.layouts.alerts.flash')
                <div class="row">
                    <!-- Invoice repeater -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Add Variants</h4>
                            </div>
                            <div class="card-body">
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
                                <form action="{{route('admin.products.store_variant')}}" method="POST" enctype="multipart/form-data" >
                                    @csrf
                                    <input type="hidden" name="id" value="{{$product->id}}" id="">
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
                                                            <input type="number" class="form-control" id="itemquantity" aria-describedby="itemquantity" name="quantity" placeholder="1" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-12">
                                                        <div class="mb-1">
                                                            <label class="form-label" for="itemquantity">SKU</label>
                                                            <input type="text" class="form-control" id="itemquantity" aria-describedby="itemquantity" name="sku" placeholder="" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-12">
                                                        <div class="mb-1">
                                                            <label class="form-label" for="staticprice">Price</label>
                                                            <input type="number"  class="form-control" id="staticprice" name="price" value="" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-12">
                                                        <div class="mb-1">
                                                            <label class="form-label" for="staticprice">Image</label>
                                                            <input type="file"  class="form-control" id="staticprice" name="image" value="" />
                                                        </div>
                                                    </div>
                                                    {{-- <div class="col-md-2 col-12 mb-50">
                                                        <div class="mb-1">
                                                            <button class="btn btn-outline-danger text-nowrap px-1" data-repeater-delete type="button">
                                                                <i data-feather="x" class="me-25"></i>
                                                                <span>Delete</span>
                                                            </button>
                                                        </div>
                                                    </div> --}}
                                                </div>
                                                <hr />
                                            </div>
                                        </div>
                                        {{-- <div class="row">
                                            <div class="col-12">
                                                <button class="btn btn-icon btn-primary" type="button" data-repeater-create>
                                                    <i data-feather="plus" class="me-25"></i>
                                                    <span>Add New</span>
                                                </button>
                                            </div>
                                        </div> --}}
                                    </div>
                                    <br>
                                        <button class="btn btn-icon btn-primary" type="submit">
                                            save
                                        </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /Invoice repeater -->
                </div>
            </section>

        </div>

        <div class="content-body">
            <div class="row" id="table-responsive">
                <div class="col-12">
                        <div class="card">
                            <div class="table-responsive">
                                <table id="varients" class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-nowrap">#</th>
                                            <th scope="col" class="text-nowrap">Options</th>
                                            <th scope="col" class="text-nowrap">Image</th>
                                            <th scope="col" class="text-nowrap">Sku</th>
                                            <th scope="col" class="text-nowrap">Price</th>
                                            <th scope="col" class="text-nowrap">Quantity</th>
                                            <th scope="col" class="text-nowrap">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($variants as $variant)
                                            <tr>
                                                <td class="text-nowrap">{{$variant->id}}</td>
                                                <td class="text-nowrap">
                                                    @forelse ($variant->attributes as $name)
                                                        {{$name->option->value}}/
                                                    @empty

                                                    @endforelse
                                                </td>
                                                <td class="text-nowrap"><div class="avatar">
                                                    <div data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                        data-bs-placement="top" class="avatar pull-up my-0"
                                                        title="{{ $product->name }}">
                                                        <img src="{{ asset('assets/product_images/' . $variant->image) }}"
                                                            alt="Avatar" height="50" width="50" />
                                                    </div>
                                                </div></td>
                                                <td class="text-nowrap">{{$variant->sku}}</td>
                                                <td class="text-nowrap">{{$variant->price}}</td>
                                                <td class="text-nowrap">{{$variant->quantity}}</td>
                                                <td class="text-nowrap">
                                                    <form action="{{route('admin.products.delete_variant',$variant->id)}}" method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <td colspan="7">No variants defined.</td>
                                        @endforelse

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



@push('script')
<script src="{{asset('app-assets/vendors/js/forms/repeater/jquery.repeater.min.js')}}"></script>
<script src="{{asset('app-assets/js/scripts/forms/form-repeater.js')}}"></script>
@endpush
