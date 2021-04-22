@extends('admin.kernel')

@section('content')
    <div class="container my-4">
        @include('admin.inc.message')
        <h4 class="my-4">Edit food ID: {{$food_id}}</h4>
        <form action="/admin/food/update" method="post" enctype="multipart/form-data">
            @csrf
            <food-edit-form
                :food-id="{{$food_id}}"
                :food-types="{{$food_types}}"
                :food-categories="{{$food_categories}}"
            >
            </food-edit-form>
        </form>
    </div>
@endsection
