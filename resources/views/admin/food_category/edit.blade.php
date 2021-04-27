@extends('admin.kernel')

@section('content')
    <div class="container my-4">
        @include("admin.inc.message")
        <h4>Burger Category Edit ID: <span class="text-info">{{ $food_category_id }}</span></h4>
        <form action="/admin/food_category/update" method="post">
            @csrf
            <food-category-edit-form food-category-id="{{$food_category_id}}"></food-category-edit-form>
        </form>
    </div>
@endsection
