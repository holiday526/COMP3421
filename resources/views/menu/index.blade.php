@extends('kernel')

@section('content')
<div class="container py-4">

    {{-- {{ dd($foods) }} --}}
    <b-form-group
        id="category-listgroup"
        label-cols-sm="3"
        label-cols-lg="3"
        label="Food Category"
        label-align="center"
        content-cols-sm
        content-cols-lg="9"
        class="mt-auto"
    >
        <template #label><div class="w-100 h-100 m-auto p-3">Food Type</div></template>
        <b-list-group id="category-listgroup" horizontal class="w-100 my-2">
            @foreach($food_types as $food_type)
            <b-list-group-item href="/food_menu?foodType={{$food_type->name}}" class="w-100">{{ $food_type->name }}</b-list-group-item>
            @endforeach
        </b-list-group>
    </b-form-group>

    
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
    >
    </food-list>
</div>
@endsection
