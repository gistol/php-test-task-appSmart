@extends('base')
@section('main')
    <div class="row">
        <div class="col-sm-12">
            @if(session()->get('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
        </div>
        <div>
            <a style="margin: 19px;" href="{{ url('/')}}" class="btn btn-primary">Home</a>
        </div>
        <div class="col-sm-12">
            <h1 class="display-3">Product search</h1>
            <form action="{{ route('products.search') }}" method="POST" role="search">
                {{ csrf_field() }}
                <div class="input-group">
                    <input type="text" class="form-control" name="query" placeholder="Search products" value="{{ $query }}">
                    <button type="submit" class="btn btn-success">Search</button>
                </div>
            </form>
            <div class="container">
                @if($query)
                    <p>The Search results for your query <b> {{ $query }} </b> are :</p>
                    <h2>Products</h2>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <td>ID</td>
                            <td>Image</td>
                            <td>Name</td>
                            <td>Category</td>
                        </tr>
                        </thead>
                        <tbody>
                            @if($products->count() > 0)
                                @foreach($products as $product)
                                    <tr>
                                        <td>{{$product->id}}</td>
                                        <td>{{$product->image}}</td>
                                        <td>{{$product->name}}</td>
                                        <td>{{$product->category}}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4"><p class="bg-danger text-white p-1">no product found</p></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
@endsection
