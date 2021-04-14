@extends('admin.kernel')

@section('content')
<div class="container py-4">
    @include('admin.inc.message')

    <form method="POST" action="/admin/food_type">
        @csrf
        <div class="form-group">
            <label for="foodTypeName">Food type name</label>
            <input type="text" class="form-control" id="foodTypeName" placeholder="Enter name" name="name">
        </div>
        <div class="form-group">
            <label for="foodTypeDescription">Food Type Description</label>
            <textarea class="form-control" id="foodTypeDescription" rows="3" placeholder="Enter description" name="description"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Submit</button>
        <button type="reset" class="btn btn-danger">Reset</button>
    </form>
</div>
@endsection
