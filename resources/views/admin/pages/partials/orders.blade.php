<div class="dropdown">
    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Status
    <span class="caret"></span></button>
    <ul class="dropdown-menu">
        @foreach ($status as $element)
        <li><a href="{{ route('admin.pages.status', $element->status) }}">{{strtoupper($element->status)}}</a></li>
        @endforeach
    </ul>
</div>
<h6>There are {{$count}} orders</h6>
<div class="menu">
    <div class="accordion">
        @if ($orders->count() == 0)
        No orders
        @else
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th class="text-center blue white-text">Order No.</th>
                    <th class="text-center blue white-text">Created</th>
                    <th class="text-center blue white-text">Updated</th>
                    <th class="text-center blue white-text">Username</th>
                    <th class="text-center blue white-text">To</th>
                    <th class="text-center blue white-text">Phone</th>
                    <th class="text-center blue white-text">Shipping Address</th>
                    <th class="text-center blue white-text">Status</th>
                    <th class="text-center blue white-text">Modified By</th>
                    <th class="text-center blue white-text">Cancel</th>
                </tr>
            </thead>
            
            @foreach($orders as $order)
            <!-- <div class="accordion-group"> -->
            <!-- <div class="accordion-heading" id="accordion-group"> -->
            
            <!-- </div> -->
            <!-- <thead> -->
            <tbody>
                <tr>
                    <td class="col-md-1"><a class="accordion-toggle" data-toggle="collapse" href="#order{{$order->id}}">#{{$order->kode_transaksi}}</a></td>
                    <td>{{prettyDate($order->created_at)}}</td>
                    <td>{{prettyDate($order->updated_at)}}</td>
                    <td>{{$order->user->username}}</td>
                    <td>{{$order->address['name']}}</td>
                    <td>{{$order->address['phone']}}</td>
                    <td>{{$order->address['location']}}</td>
                    <td>{{strtoupper($order->status)}}</td>
                    <td>{{$order->modified_by}}</td>
                    <td class="text-center">
                    <a data-toggle="modal" href='#modal-delete-order-{{$order->id}}'><i class="fa fa-trash red-text" aria-hidden="true"></i></a>
                    <div class="modal fade" id="modal-delete-order-{{$order->id}}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title">Cancel Order?</h4>
                                </div>
                                <div class="modal-footer">
                                    <form method="post" action="{{ route('admin.order.cancel') }}">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        {{csrf_field()}}
                                        <input type="hidden" name="_method" value="put">
                                        <input type="hidden" name="id" value="{{$order->id}}">
                                        <button type="submit" class="btn btn-danger">Cancel Order</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    </td>
                </tr>
                
                <!-- </thead> -->
                
                <tr><td colspan="10">
                    <div id="order{{$order->id}}" class="accordion-body collapse">
                        <div class="accordion-inner">
                            <table class="table table-striped table-condensed">
                                <thead>
                                    <tr>
                                        <th>
                                            Product
                                        </th>
                                        <th>
                                            Quantity
                                        </th>
                                        <th>
                                            Product Price
                                        </th>
                                        <th>
                                            Total
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
                                            {{ $orderitem->pivot->reduced_price }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($orderitem->pivot->total_reduced == 0)
                                            {{ xformatMoney($orderitem->pivot->total)}}
                                            @else
                                            {{xformatMoney($orderitem->pivot->total_reduced)}}
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td><b>Shipping Cost</b></td>
                                        <td></td>
                                        <td></td>
                                        <td>{{xformatMoney($order->total_ongkir)}}</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td><b>Total</b></td>
                                        <td><b>{{xformatMoney($order->total)}}</b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <div class="col-sm-12 col-md-6">
                                                <table class="table">
                                                    <caption><b>Shipping Address</b></caption>
                                                    <tbody>
                                                        <tr><td>To </td><td>: {{ $order->address['name'] }}</td></tr>
                                                        <tr><td>Email </td><td>: {{ $order->address['email'] }}</td></tr>
                                                        <tr><td>Phone </td><td>: {{ $order->address['phone'] }}</td></tr>
                                                        <tr><td>Address </td><td>: {{ $order->address['address'] }}</td></tr>
                                                        <tr><td></td><td>: {{ $order->address['provinsi'] }} / {{ $order->address['kabupaten'] }} / {{ $order->address['kecamatan'] }}</td></tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                <table class="table">
                                                    <caption><b>Shipping Detail</b></caption>
                                                    <tbody>
                                                        <tr><td>Delivery Date </td><td>: {{ prettyDate($order->delivery_date) }}</td></tr>
                                                        <tr><td>Courier </td><td>: {{ $order->kurir }}</td></tr>
                                                        <tr><td>Tracking Number </td><td>: {{ $order->no_resi }}</td></tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                        </td>
                                    </tr>
                                </tbody>
                                <tr>
                                    <td colspan="4" class="text-right">
                                        @if ($order->status == "waiting")
                                        <a href="{{ url('admin/verify') }}/{{$order->id}}" class="btn btn-primary pull-right">Verify Payment</a>
                                        @elseif ($order->status == "paid - waiting for delivery" || $order->status == "cod")
                                        <a href="{{ url('admin/delivery') }}/{{$order->id}}" class="btn btn-primary pull-right">Delivery</a>
                                        @elseif ($order->status == "delivery")
                                        <form action="{{ url('admin/finish') }}" class="finish_transaction_form" method="POST" role="form">
                                            {{csrf_field()}}
                                            <input type="hidden" name="order_id" value="{{$order->id}}">
                                            <button id="finish-transaction-btn" class="btn btn-primary">Finish Transaction</button>
                                        </form>
                                        @elseif ($order->status == "")
                                        {{-- true expr --}}
                                        @elseif ($order->status == "")
                                        {{-- true expr --}}
                                        @else
                                        {{-- false expr --}}
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
        @endforeach
    </table>
    @endif
</div>
</div>
@section('header')
<link rel="stylesheet" type="text/css" href="{{ url('/') }}/src/public/bower_components/bootstrap/dist/css/jasny-bootstrap.min.css">
@endsection
@section('footer')
<script src="{{ url('/') }}/src/public/bower_components/bootstrap/dist/js/jasny-bootstrap.min.js" type="text/javascript" charset="utf-8" async defer></script>
@endsection