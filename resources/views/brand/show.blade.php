@extends('app')
@section('content')
<div id="wrapper--">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 visible-md visible-lg">
            @include('pages.partials.side-nav-two')
        </div>
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
            <div class="container-fluid">
                <h3 class="text-center">
                @foreach($brand as $brand)
                {{ $brand->brand_name }}
                @endforeach
                </h3>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">{{config('label')->sort_by}}
                    <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('brand.newest', $brand->id) }}">{{config('label')->newest}}</a></li>
                        <li><a href="{{ route('brand.lowest', $brand->id) }}">{{config('label')->price_lowest}}</a></li>
                        <li><a href="{{ route('brand.highest', $brand->id) }}">{{config('label')->price_highest}}</a></li>
                        <li><a href="{{ route('brand.alpha.lowest', $brand->id) }}">{{config('label')->product_a_z}}</a></li>
                        <li><a href="{{ route('brand.alpha.highest', $brand->id) }}">{{config('label')->product_z_a}}</a></li>
                    </ul>
                </div>
                <br>
                <p>{{ $count }} {{ str_plural('product', $count) }}</p>
                <div class="row">
                   @foreach($products as $product)
            <div class="col-xs-6 col-sm-3 col-md-2 visible-md visible-lg" style="margin: 15px;">
                <a href="{{ route('show.product', $product->product_name) }}">
                    @if ($product->photos->count() === 0)
                    <img src="{{url('/')}}/src/public/images/no-image-found.jpg" alt="No Image Found Tag" id="Product-similar-Image" style="width: 200px; height: 200px;">
                    @else
                    @if ($product->featuredPhoto)
                    <img src="{{url('/')}}/{{ $product->featuredPhoto->thumbnail_path }}" alt="Photo ID: {{ $product->featuredPhoto->id }}" />
                    @elseif(!$product->featuredPhoto)
                    <img src="{{url('/')}}/{{ $product->photos->first()->thumbnail_path}}" alt="Photo" />
                    @else
                    N/A
                    @endif
                    @endif
                    <div id="featured-product-name-container">
                        <h6 class="center-on-small-only" id="featured-product-name"><br>{{ substr($product->product_name,0,30) }}...</h6>
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
            <!-- ---------------------------------------------- For Mobile ------------------------------------------------------------------------- -->
            <div class="col-xs-6 visible-xs visible-sm">
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
                        <div class="caption">
                            <span>{{ substr($product->product_name,0,20) }}</span>
                            @if($product->reduced_price == 0)
                            <div class="light-300 black-text light-300">{{  xformatMoney($product->price) }}</div>
                            @else
                            <div class="light-300 black-text light-300"><s>{{  xformatMoney($product->price) }}</s></div>
                            <div class="green-text medium-500">{{ xformatMoney($product->reduced_price) }}</div>
                            @endif
                            <form action="{{url('/')}}/cart/add" method="post" name="add_to_cart">
                                {!! csrf_field() !!}
                                <input type="hidden" name="product" value="{{$product->id}}" />
                                <input type="hidden" name="weight" value="{{$product->weight}}" />
                                <input type="hidden" name="qty" value="1" />
                                <button class="btn btn-sm btn-info" style="position:absolute; bottom: 0; left: 5%; width:80%;">{{config('label')->add_to_cart}}</button>
                            </form>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 visible-xs visible-sm">
            @include('pages.partials.side-nav-two')
        </div>
    </div>
    @include('pages.partials.footer')
    @endsection
    