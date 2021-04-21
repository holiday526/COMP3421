@extends('kernel')

@section('content')
    <div class="container py-4">
        <h4><i class="fas fa-shopping-cart"></i> Cart</h4>
        @if(count($cart) === 0))

        @else
            <cart-list
            >
            </cart-list>
        @endif
    </div>
@endsection
