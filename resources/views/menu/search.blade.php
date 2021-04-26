@extends('kernel')

@section('content')
    <div class="container py-4">
        <search-list
            @auth
            :logged-in="true"
            @else
            :logged-in="false"
            @endauth
            :search-result="{{ json_encode($result) }}"
        ></search-list>
    </div>
@endsection
