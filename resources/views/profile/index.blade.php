@extends('app')
@section('content')
<div id="wrapper--">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
            @include('pages.partials.side-nav-two')
        </div>
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
            <div class="container-fluid">
                <div class="col-md-10 col-md-offset-1">
                    <h4 class="text-center">{{config('label')->your_order}}</h4><br>
                    <div class="menu">
                        <div class="accordion">
                            @if ($orders->count() == 0)
                            {{config('label')->you_have_no_order}}
                            @else
                            @foreach($orders as $order)
                            <div class="accordion-group">
                                <div class="accordion-heading" id="accordion-group">
                                    <a class="accordion-toggle" data-toggle="collapse" href="#order{{$order->id}}">#{{$order->kode_transaksi}} - {{prettyDate($order->created_at)}}
                                        @if ($order->status == "unpaid")
                                            <span class="pull-right red-text">
                                        @else
                                            <span class="pull-right green-text">
                                        @endif
                                        <strong>{{strtoupper($order->status)}}</strong></span>
                                    </a>
                                </div>
                                <div id="order{{$order->id}}" class="accordion-body collapse">
                                    <div class="accordion-inner">
                                        <table class="table table-striped table-condensed">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        {{config('label')->products}}
                                                    </th>
                                                    <th>
                                                        {{config('label')->quantity}}
                                                    </th>
                                                    <th>
                                                        {{config('label')->product_price}}
                                                    </th>
                                                    <th>
                                                        {{config('label')->total}}
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($order->orderItems as $orderitem)
                                                <tr>
                                                    <td><a href="{{ route('show.product', $orderitem->product_name) }}">{{$orderitem->product_name}}</a></td>
                                                    <td>{{$orderitem->pivot->qty}}</td>
                                                    <td>
                                                        @if($orderitem->pivot->reduced_price == 0)
                                                        {{ xformatMoney($orderitem->pivot->price) }}
                                                        @else
                                                        {{ xformatMoney($orderitem->pivot->reduced_price) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($orderitem->pivot->total_reduced == 0)
                                                        {{xformatMoney($orderitem->pivot->total)}}
                                                        @else
                                                        {{xformatMoney($orderitem->pivot->total_reduced)}}
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                                <tr>
                                                    <td><b>{{config('label')->shipping_cost}}</b></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>{{xformatMoney($order->total_ongkir)}}</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td><b>{{config('label')->total}}</b></td>
                                                    <td><b>{{xformatMoney($order->total)}}</b></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                        <div class="col-sm-12 col-md-6">
                                                            <table class="table">
                                                                <caption><b>{{config('label')->shipping_address}}</b></caption>
                                                                <tbody>
                                                                    <tr><td>{{config('label')->to}} </td><td>: {{ $order->address['name'] }}</td></tr>
                                                                    <tr><td>{{config('label')->email}} </td><td>: {{ $order->address['email'] }}</td></tr>
                                                                    <tr><td>{{config('label')->phone}} </td><td>: {{ $order->address['phone'] }}</td></tr>
                                                                    <tr><td>{{config('label')->address}} </td><td>: {{ $order->address['address'] }}</td></tr>
                                                                    <tr><td></td><td>: {{ $order->address['provinsi'] }} / {{ $order->address['kabupaten'] }} / {{ $order->address['kecamatan'] }}</td></tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="col-sm-12 col-md-6">
                                                            <table class="table">
                                                                <caption><b>{{config('label')->shipping_detail}}</b></caption>
                                                                <tbody>
                                <tr><td>{{config('label')->delivery_date}} </td><td>: {{ prettyDate($order->delivery_date) }}</td></tr>
                                                                    <tr><td>{{config('label')->courier}} </td><td>: {{ $order->kurir }}</td></tr>
                                                                    <tr><td>{{config('label')->tracking_number}} </td><td>: {{ $order->no_resi }}</td></tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        
                                                    </td>
                                                </tr>
                                                @if ($order->status == "unpaid")
                                                <tr>
                                                <td colspan="4">
                                                <form action="{{ url('order/confirmation') }}" method="POST" role="form">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="order_id" value="{{$order->id}}">
                                                    <input type="hidden" name="cod" value="cod">
                                                <a href="{{ url('order/confirmation') }}/{{$order->id}}" class="btn btn-primary pull-right" title="">{{config('label')->payment_confirmation}}</a>
                                                <button type="submit" class="btn btn-warning pull-right">{{config('label')->cod}}</button>
                                                </td>
                                                </tr>
                                                @endif
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('pages.partials.footer')
    @endsection