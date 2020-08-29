@extends('base')
@section('main')
    <div class="row">
        <div>
            <a style="margin: 19px;" href="{{ url('/')}}" class="btn btn-primary">Home</a>
        </div>
        <div class="col-sm-8 offset-sm-2">
            <h1 class="display-3">Update a product</h1>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <br />
            @endif
            <form method="post" action="{{ route('products.update', $product->id) }}">
                @method('PATCH')
                @csrf
                <div class="form-group">
                    <label for="first_name">Image:</label>
                    <input type="text" class="form-control" name="image" value="{{ $product->image }}" />
                </div>
                <div class="form-group">
                    <label for="last_name">Name:</label>
                    <input type="text" class="form-control" name="name" value="{{ $product->name }}" />
                </div>
                <div class="form-group">
                    <label for="email">Category:</label>
                    <input type="text" class="form-control" name="category" value="{{ $product->category }}" />
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
