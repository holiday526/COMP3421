@extends('kernel')

@section('content')
<div class="container py-4">

    {{-- {{ dd($foods) }} --}}
    
    <food-list
        @auth
        :logged-in="true"
        @else
        :logged-in="false"
        @endauth
        :total-number="{{ $foods->total() }}"
        :foods="{{ json_encode($foods->items()) }}"
        :pages="{{ $foods->lastPage() }}"
        :current-page="{{ $foods->currentPage() }}"
        :per-page="{{ $foods->perPage() }}"
        :food-types="{{ $food_types }}"
    >
    </food-list>
</div>
@endsection
