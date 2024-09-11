@extends('layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Product Gallery ({{ $product->name }})</h1>
        </div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="card card-primary">
            <div class="card-header">
                <h4>All Images</h4>
            </div>

            <div>
                <a href="{{ route('product.index') }}" class="btn btn-primary my-3 ml-5">Go Back</a>
            </div>

            <div class="card-body">
                <div class="col-md-8">
                    <form action="{{ route('product-gallery.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="file" class="form-control" name="image">
                            <input type="hidden" value="{{ $product->id }}" name="product_id">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card card-primary">

            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($images as $image)
                        <tr>
                            <td><img width="150px" src="{{ asset($image->image) }}" alt=""></td>
                            <td>
                                <a href='{{ route('product-gallery.destroy', $image->id) }}' class='btn btn-danger delete-item mx-2'><i class='fas fa-trash'></i></a>
                            </td>
                        </tr>
                        @endforeach
                       @if (count($images) === 0)
                        <tr >
                            <td colspan='2' class="text-center">No data found!</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
