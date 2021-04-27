@extends('admin.kernel')

@section('content')
    <div class="container my-4">
        @include('admin.inc.message')
        <h4>Edit Food Type ID: <span class="text-info">{{ $food_type_id }}</span></h4>
        <form action="/admin/food_type/update" method="post">
            @csrf
            <food-type-edit-form food-type-id="{{$food_type_id}}"></food-type-edit-form>
        </form>
    </div>
@endsection
