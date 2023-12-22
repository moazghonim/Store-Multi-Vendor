@extends('layouts.dashboard')

@section('title','Proucts')

@section('breadcrumb')

<li class="breadcrumb-item active">products</li>
@parent

@endsection

@section('content')


<div class="mb-5">
    <a href="{{ route('products.create') }}" class="btn-btn-sm btn-outline-primary">Create</a>

</div>

<x-alert type="success" />

<form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between mb-4">
    <x-form.input name="name" placeholder="type here" class="mx-2" :value="request('name')" />
    <select name="status" class="form-control" class="mx-2">
        <option value="">All</option>
        <option value="active" @selected(request('status')=='active' )>Active</option>
        <option value="archived" @selected(request('status')=='archived' )>Archived</option>
    </select>
    <button class="btn btn-dark mx-2">Search</button>
</form>


<table class="table">
    <thead>
        <tr>
            <th></th>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Store</th>
            <th>Status</th>
            <th>Created At</th>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($products as $product)
        <tr>
            <td> <img src="{{ asset('storage/'.$product->image) }}" alt="" height="50"></td>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->category->name }}</td>
            <td>{{ $product->store->name}}</td>
            <td>{{ $product->created_at }}</td>
            <td>
                <a href="{{route('products.edit',$product->id)}}" class="btn-btn-sm btn-outline-success">Edit</a>
            </td>
            <td>
                <form action="{{route('products.destroy',$product->id)}}" method="POST">
                    @csrf
                    <input type="hidden" name="-method" value="delete">
                    @method('delete')
                    <button type="submit" class="btn-btn-sm btn-outline-danger">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7">No products Defined</td>
        </tr>
        @endforelse
    </tbody>
</table>


{{$products->withQueryString()->links()}}

@endsection