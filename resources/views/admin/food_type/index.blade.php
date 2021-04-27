@extends('admin.kernel')

@section('content')
    <div class="container-fluid my-4">
        @include('admin.inc.message')
        <h4>Food Types:</h4>
        <food-type-edit-table></food-type-edit-table>
    </div>
@endsection
