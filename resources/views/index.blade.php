@extends('kernel')

@section('content')
    <div class="container">

        <div class="row">

            <div class="col-lg">

                <div class="moving-banner mt-2 my-1">
                    <h3 style="color: #92abba">Welcome to {{ \Illuminate\Support\Facades\Config::get('constants.APP_NAME') }} <i class="fas fa-hamburger"></i></h3>
                </div>
                @if (count($feature_foods) > 0)
                <div>
                    <b-carousel
                        class="mb-4"
                        id="carousel-food"
                        style="text-shadow: 0px 0px 2px #000"
                        fade
                        indicators
                        img-width="1200"
                        img-height="500"
                    >
                        @foreach($feature_foods as $food)
                        <b-carousel-slide
                            caption="{{$food->food_name}}"
                            img-src="{{$food->food_image_location}}"
                            img-height="500"
                            img-width="1200"
                        >
                        </b-carousel-slide>
                        @endforeach
                    </b-carousel>
                </div>
                <h4 class="my-4 ml-2"><i class="fas fa-star"></i> Featured Food</h4>
                <b-row class="my-4">
                    @foreach($feature_foods as $food)
                        <b-col class="mx-auto">
                            <food-card
                                class="mx-auto"
                                @auth
                                :logged-in="true"
                                @else
                                :logged-in="false"
                                @endauth
                                food-id="{{$food->food_id}}"
                                food-name="{{$food->food_name}}"
                                food-description="{{$food->food_description}}"
                                food-price="{{$food->food_price}}"
                                food-type="{{$food->food_type_name}}"
                                food-category="{{$food->food_category_name}}"
                                food-image="{{$food->food_image_location}}"
                            >
                            </food-card>
                        </b-col>
                    @endforeach
                </b-row>
                @else
                    <h4>Wait for food menu update</h4>
                @endif


            </div>
            <!-- /.col-lg-9 -->

        </div>
        <!-- /.row -->

    </div>
@endsection
