@extends('app')
@section('content')
<div id="wrapper--">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 visible-lg visible-md">
            @include('pages.partials.side-nav-two')
        </div>
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
            <!-- <a href="#menu-toggle" class="btn btn-default visible-xs" id="menu-toggle"><i class="fa fa-bars fa-5x"></i></a> -->
            <div class="container-fluid">
                <h6>
                {{config('label')->search_results_for}}: <i>{{ $query }}</i>
                </h6><br>
                @if (count($search_result) === 0)
                {{config('label')->no_products_found}}
                @elseif (count($search_result) >= 1)
                @foreach($search_result as $product)
                <!-- <div class="col-sm-6 col-md-3 wow zoomIn" id="product-sub-container"> -->
                <div class="col-md-2 visible-md visible-lg" style="margin:15px;">
                    <a href="{{ route('show.product', $product->product_name) }}">
                        @if ($product->photos->count() === 0)
                        <img src="{{url('/')}}/src/public/images/no-image-found.jpg" alt="No Image Found Tag" id="Product-similar-Image" style="width: 180px; max-height: 100%;">
                        @else
                        @if ($product->featuredPhoto)
                        <img src="{{url('/')}}/{{ $product->featuredPhoto->thumbnail_path }}" alt="Photo ID: {{ $product->featuredPhoto->id }}" style="width: 180px; max-height: 100%;"/>
                        @elseif(!$product->featuredPhoto)
                        <img src="{{url('/')}}/{{ $product->photos->first()->thumbnail_path}}" alt="Photo" style="width: 180px; max-height: 100%;"/>
                        @else
                        {{config('label')->na}}
                        @endif
                        @endif
                        <div id="featured-product-name-container">
                            <h6 class="center-on-small-only" id="featured-product-name"><br>{{ $product->product_name }}</h6>
                        </div>
                        @if($product->reduced_price == 0)
                        <div class="light-300 black-text medium-500" id="Product_Reduced-Price">{{  xformatMoney($product->price) }}</div>
                        @else
                        <div class="green-text medium-500" id="Product_Reduced-Price">{{ xformatMoney($product->reduced_price) }}</div>
                        @endif
                    </a>
                    <form action="{{url('/')}}/cart/add" method="post" name="add_to_cart">
                        {!! csrf_field() !!}
                        <input type="hidden" name="product" value="{{$product->id}}" />
                        <input type="hidden" name="weight" value="{{$product->weight}}" />
                        <input type="hidden" name="qty" value="1" />
                        <button class="btn btn-default waves-effect waves-light">{{config('label')->add_to_cart}}</button>
                    </form>
                </div>
                <div class="col-xs-6 visible-xs">
                    <a href="{{ route('show.product', $product->product_name) }}">
                        <div class="thumbnail">
                            @if ($product->photos->count() === 0)
                            <img src="{{url('/')}}/src/public/images/no-image-found.jpg" alt="No Image Found Tag" id="image-m" style="width: 200px; height: 200px;">
                            @else
                            @if ($product->featuredPhoto)
                            <img src="{{url('/')}}/{{ $product->featuredPhoto->thumbnail_path }}"/>
                            @elseif(!$product->featuredPhoto)
                            <img src="{{url('/')}}/{{ $product->photos->first()->thumbnail_path}}"/>
                            @else
                            N/A
                            @endif
                            @endif
                            <div style="height:60px;">
                                <span>{{ substr($product->product_name,0,20) }}</span>
                                @if($product->reduced_price == 0)
                                <div class="light-300 black-text light-300">{{  xformatMoney($product->price) }}</div>
                                @else
                                <div class="light-300 black-text light-300"><s>{{  xformatMoney($product->price) }}</s></div>
                                <div class="green-text medium-500">{{ xformatMoney($product->reduced_price) }}</div>
                                @endif
                            </div>
                            <form action="{{url('/')}}/cart/add" method="post" name="add_to_cart">
                                {!! csrf_field() !!}
                                <input type="hidden" name="product" value="{{$product->id}}" />
                                <input type="hidden" name="weight" value="{{$product->weight}}" />
                                <input type="hidden" name="qty" value="1" />
                                <button class="btn btn-sm btn-info">{{config('label')->add_to_cart}}</button>
                            </form>
                            </div>
                    </a>
                </div>
                
                @endforeach
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 visible-xs visible-sm">
            @include('pages.partials.side-nav-two')
        </div>
    </div>
    @include('pages.partials.footer')
    @endsection