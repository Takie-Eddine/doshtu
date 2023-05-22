@extends('dashboard.layouts.dashboard')

@section('title','Products')


@push('style')

@endpush

@section('content')


<div>
    <table>
        <thead>
            <tr>

                <td>id</td>
                <td>Name</td>
                <td>Category</td>
                <td>price</td>
            </tr>
        </thead>
        <tbody>
            @forelse ($products1->Urunler as $item)
                @forelse ($item as $item1)
                    <tr>
                        {{-- <td><img src="{{$item1->Resimler->Resim[0]}}" alt=""></td> --}}
                        <td>{{$item1->UrunKartiID}}</td>
                        <td>{{$item1->UrunAdi}}</td>
                        <td>{{$item1->Kategori}}</td>
                        <td></td>
                    </tr>
                @empty
                @endforelse
            @empty
            @endforelse
        </tbody>
    </table>
</div>


@push('script')


@endpush
