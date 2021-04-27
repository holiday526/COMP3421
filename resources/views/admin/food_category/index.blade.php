@extends('admin.kernel')

@section('content')
    <div class="container-fluid my-4">
        @include('admin.inc.message')
        <h4>Food category:</h4>
        <food-category-edit-table></food-category-edit-table>
    </div>
@endsection
