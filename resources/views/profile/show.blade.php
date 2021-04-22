@extends('kernel')

@section('content')
    <div class="container my-4">
        <h4 class="my-4"><i class="far fa-user"></i> User Profile</h4>
        <b-table
            stacked
            :items="{{ json_encode($user, true) }}"
        >
        </b-table>
    </div>
@endsection
