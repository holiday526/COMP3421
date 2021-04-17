@extends('admin.kernel')

@section('content')
    <div class="container py-4">
        @include('admin.inc.message')

        <h4>Add Food</h4>
        <form action="/admin/food" method="post" enctype="multipart/form-data">
            @csrf
            <food-create-form
                :food-types="{{$food_types}}"
                :food-categories="{{$food_categories}}"
            >
            </food-create-form>
        </form>
    </div>
@endsection
