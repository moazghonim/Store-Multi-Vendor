@extends('layouts.dashboard')

@section('title',$category->name)

@section('breadcrumb')

<li class="breadcrumb-item active">{{$category->name}}</li>
@parent

@endsection

@section('content')

<table class="table">
    <thead>
        <tr>

            <th>Name</th>
            <th>store</th>
            <th>Status</th>
            <th>Created At</th>

        </tr>
    </thead>
    <tbody>
        @php
        $products = $category->products()->with('store')->paginate(5);
        @endphp
        @forelse ($products as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->store->name }}</td>
            <td>{{ $product->status}}</td>
            <td>{{ $product->created_at }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="7">No Products Defined</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{$products->links()}}

@endsection