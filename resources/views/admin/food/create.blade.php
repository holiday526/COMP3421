@extends('admin.kernel')

@section('content')
    <div class="container py-4">
        <h4>Add Food</h4>
        <form action="/admin/food" method="post">
            @csrf
            <food-create-form
                :food-types="{{$food_types}}"
                :food-categories="{{$food_categories}}"
            >
            </food-create-form>
        </form>
    </div>
@endsection
