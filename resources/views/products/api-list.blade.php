@extends('base')
@section('main')
    <div class="row">
        <div class="col-sm-12">
            @if(session()->get('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div><br/>
            @endif
        </div>
        <div>
            <a style="margin: 19px;" href="{{ url('/')}}" class="btn btn-primary">Home</a>
        </div>
        <div>
            <a style="margin: 19px;" href="{{ route('products.create')}}" class="btn btn-primary">New product</a>
        </div>
        <div class="col-sm-12">
            <h1 class="display-3">Products</h1>
            <table class="table table-striped">
                <thead>
                <tr>
                    <td>Image</td>
                    <td>Name</td>
                    <td>Category</td>
                    <td>Action</td>
                </tr>
                </thead>
                <tbody>

                @foreach($products as $product)
                    <tr>
                        <td>{{$product->image_url ?? '-'}}</td>
                        <td>{{$product->product_name ?? '-'}}</td>
                        <td>{{$product->categories ?? '-'}}</td>
                        <td>
                            <form method="post" action="{{ route('products.store') }}">
                                @csrf
                                <input type="hidden" class="form-control" name="image"
                                       value="{{$product->image_url ?? ''}}"/>
                                <input type="hidden" class="form-control" name="name"
                                       value="{{$product->product_name ?? ''}}"/>
                                <input type="hidden" class="form-control" name="category"
                                       value="{{$product->categories ?? ''}}"/>
                                <input type="hidden" class="form-control" name="api_id" value="{{$product->_id}}"/>
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
@endsection
