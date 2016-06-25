<div class="yellow-line"></div>
<div class="title-yellow">
    <span class="product-heading text-center"><strong>{{config('label')->featured_product}}</strong></span>
</div>
<div class="text-center">
    <div class="container-fluid" id="Index-Main-Container">
        <div id="featured-products-sub-container">
            <div class="row">
                @foreach($products as $product)
                <div class="col-sm-3 col-md-2" id="featured-container">
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
                <div class="col-sm-6 col-md-3" id="featured-container-m">
                    <a href="{{ route('show.product', $product->product_name) }}">
                        <div class="col-xs-12">
                            <div id="featured-product-name-container">
                                <h5 class="center-on-small-only" id="featured-product-name">{{ substr($product->product_name,0,20) }}...</h5>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            @if ($product->photos->count() === 0)
                            <img src="{{url('/')}}/src/public/images/no-image-found.jpg" alt="No Image Found Tag" style="width: 200px; height: 200px;" id="image-m">
                            @else
                            @if ($product->featuredPhoto)
                            <img src="{{url('/')}}/{{ $product->featuredPhoto->thumbnail_path }}" alt="Photo ID: {{ $product->featuredPhoto->id }}" class="img-responsive img-thumbnail" id="image-m" />
                            @elseif(!$product->featuredPhoto)
                            <img src="{{url('/')}}/{{ $product->photos->first()->thumbnail_path}}" alt="Photo" class="img-responsive img-thumbnail" id="image-m"  />
                            @else
                            N/A
                            @endif
                            @endif
                        </div>
                        <div class="col-xs-6">
                            @if($product->reduced_price == 0)
                            <div class="light-300 black-text medium-500" id="Product_Reduced-Price">{{  $product->price }}</div>
                            @else
                            <div class="green-text medium-500" id="Product_Reduced-Price">{{ $product->reduced_price }}</div>
                            @endif
                        </div>
                    </a>
                    <form action="{{url('/')}}/cart/add" method="post" name="add_to_cart">
                        {!! csrf_field() !!}
                        <input type="hidden" name="product" value="{{$product->id}}" />
                        <input type="hidden" name="weight" value="{{$product->weight}}" />
                        <input type="hidden" name="qty" value="1" />
                        <button class="btn btn-default waves-effect waves-light">ADD TO CART</button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>