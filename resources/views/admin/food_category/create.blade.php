@extends('admin.kernel')

@section('content')
    <div class="container py-4">
        @include('admin.inc.message')

        <h4>Add food category</h4>
        <form method="POST" action="/admin/food_category">
            @csrf
            <div class="form-group">
                <label for="foodCategoryName">Food category name</label>
                <input type="text" class="form-control" id="foodCategoryName" placeholder="Enter name" name="name">
            </div>
            <div class="form-group">
                <label for="foodCategoryDescription">Food Type Description</label>
                <textarea class="form-control" id="foodCategoryDescription" rows="3" placeholder="Enter description" name="description"></textarea>
            </div>
            <button type="submit" class="btn btn-success mr-2">Submit</button>
            <button type="reset" class="btn btn-danger">Reset</button>
        </form>
    </div>
@endsection
