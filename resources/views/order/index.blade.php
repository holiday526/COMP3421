@extends('kernel')

@section('content')
    <div class="container my-4">
        <h4>Orders<span class="mx-2 h6">(count: <span class="text-info">{{ count($order_ids) }}</span>)</span></h4>
        @foreach($order_ids as $order_id)
            <order-card
                class="my-2"
                :order-id="{{$order_id}}"
            >
            </order-card>
        @endforeach
    </div>
@endsection
