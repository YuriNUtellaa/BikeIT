@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>Add Brand</h2>
        <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">

            @csrf
            <div class="form-group">
                <label for="brand_name">Brand Name:</label>
                <input type="text" class="form-control" id="brand_name" name="brand_name">
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <input type="text" class="form-control" id="statud" name="status">
            </div>
            <div class="form-group">
                <label for="images">Images:</label>
                <input type="file" class="form-control" id="images" name="images[]" multiple>
            </div>
            <button type="submit" class="btn btn-primary">Add Product</button>
        </form>

        <hr>

        <h2>Products</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Brand Name</th>
                    <th>Status</th>
                    <th>Images</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($brands as $brand)
                    <tr>
                        <td>{{ $brand->brand_name }}</td>
                        <!-- Display the category -->
                        <td>{{ $brand->status }}</td>
                        <td>
                            @foreach ($product->images as $image)
                                <img src="{{ asset('uploads/image' . $image->image) }}" alt="Product Image"
                                    style="max-width: 100px;">
                            @endforeach
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
@endsection
