@extends('user.layouts.user')

@section('title','Product Variants')


@push('style')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
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
                        <h2 class="content-header-title float-start mb-0">Products Edit</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Home</a>
                                </li>
                                <li class="breadcrumb-item active"><a
                                        href="{{ route('user.products.index') }}">Products</a>
                                </li>
                                <li class="breadcrumb-item active"><a
                                        href="{{ route('user.products.pushtostore', $product->slug) }}">Edit</a>
                                </li>
                                <li class="breadcrumb-item active">Edit Variants
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">

            </div>
        </div>
        @include('user.layouts.alerts.flash')
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
        <div class="content-body">
            <div class="row" id="table-responsive">
                <div class="col-12">
                    <form action="{{ route('user.products.pushvariant') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="card">
                            <div class="table-responsive">
                                <table id="varients" class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-nowrap">#</th>
                                            <th scope="col" class="text-nowrap">Options</th>
                                            <th scope="col" class="text-nowrap">Image</th>
                                            <th scope="col" class="text-nowrap">Sku</th>
                                            <th scope="col" class="text-nowrap">Ships From</th>
                                            <th scope="col" class="text-nowrap">Cost</th>
                                            <th scope="col" class="text-nowrap">Shipping</th>
                                            <th scope="col" class="text-nowrap">Price</th>
                                            <th scope="col" class="text-nowrap">Profit</th>
                                            <th scope="col" class="text-nowrap">Compared At Price</th>
                                            <th scope="col" class="text-nowrap">Inventory</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($variants as $variant)
                                            <tr>
                                                <td class="text-nowrap"><input class="form-control"  type="checkbox" name="id[]" value="{{ $variant->id }}" id="chek" onchange="disableRow(this)" checked></td>
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
                                                <td><input type="text" class="form-control" name="sku[]" value="{{ $variant->sku }}" id="sku"></td>
                                                <td class="text-nowrap">Turkey</td>
                                                <td class="text-nowrap">${{$variant->selling_price}}</td>
                                                <td class="text-nowrap">__</td>
                                                <td class="text-nowrap">
                                                    <div class="input-group mb-2 mb-1 col-md-6">
                                                        <span class="input-group-text">$</span>
                                                        <input type="text" class="form-control" name="price[]" value="{{$variant->selling_price}}" id="price">
                                                    </div>
                                                </td>
                                                <td class="text-nowrap">${{($variant->selling_price)-($variant->product->compare_price)}}</td>
                                                <td class="text-nowrap">${{$variant->product->compare_price}}</td>
                                                <td class="text-nowrap"><input type="text" class="form-control" name="quantity[]" value="{{$variant->quantity}}" id="quantity"></td>
                                            </tr>
                                        @empty
                                            <td colspan="7">No variants defined.</td>
                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success me-1">Submit</button>
                            <button type="reset" onclick="history.back()"
                                class="btn btn-outline-secondary">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection



@push('script')
<script>
    function disableRow(data) {

        tddata = data.parentElement;
        trow = tddata.parentElement;
        checkboxdata = $(trow).find("[type=checkbox]");

        if ($(checkboxdata).is(':checked')) {
        $(trow).find("input").not("[type=checkbox]").attr('disabled',false);

        }
        else {
            $(trow).find("input").not("[type=checkbox]").attr('disabled', "disabled");

        }
    }

</script>
@endpush

