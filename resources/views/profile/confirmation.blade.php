@extends('app')
@section('content')
<div id="wrapper--">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
            @include('pages.partials.side-nav-two')
        </div>
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
            <div class="container-fluid">
                <div class="col-md-12">
                    <h4 class="text-center">{{config('label')->confirm_payment}}</h4>
                    <div class="col-sm-12 col-md-12">
                        @foreach($orders as $order)
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading warning-color white-text">Order No : {{$order->id}} - {{prettyDate($order->created_at)}}</div>
                                    <div class="panel-body">
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
                                                    <td colspan="3">{{config('label')->shipping_cost}}</td>
                                                    <td>{{xformatMoney($order->total_ongkir)}}</td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                            <tr><th colspan="3">Total</th><th>{{xformatMoney($order->total)}}</th></tr>
                                            </tfoot>
                                        </table>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">{{config('label')->shipping_information}}</div>
                                            <div class="panel-body">
                                                <div class="col-md-4">{{config('label')->name}}:</div><div class="col-md-8"> {{$order->address->name}}</div>
                                                <div class="col-md-4">{{config('label')->email}}:</div><div class="col-md-8"> {{$order->address->email}}</div>
                                                <div class="col-md-4">{{config('label')->phone}}:</div><div class="col-md-8"> {{$order->address->phone}}</div>
                                                <div class="col-md-4">Provinsi:</div><div class="col-md-8"> {{$order->address->provinsi}}</div>
                                                <div class="col-md-4">Kabupaten / Kota:</div><div class="col-md-8"> {{$order->address->kabupaten}}</div>
                                                <div class="col-md-4">Kecamatan:</div><div class="col-md-8"> {{$order->address->kecamatan}}</div>
                                                <div class="col-md-12">{{config('label')->cod}}:</div><div class="col-md-12"> {{$order->address->address}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                @if ($order->status == "unpaid")
                                <form action="{{ url('order/confirmation') }}" method="POST" role="form">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="order_id" value="{{$order->id}}">
                                    <legend>{{config('label')->form_confirmation}}</legend>
                                    
                                    <div class="form-group{{ $errors->has('bank_name') ? ' has-error' : '' }}">
                                        <label for="">{{config('label')->bank_name}}</label>
                                        <select name="bank_name" id="inputBank_name" class="form-control" required="required">
                                            @foreach (config('bank_name') as $bank_name)
                                            <option value="{{$bank_name}}">{{$bank_name}}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('bank_name'))
                                            <span class="help-block">{{ $errors->first('bank_name') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('account_name') ? ' has-error' : '' }}">
                                        <label for="">{{config('label')->bank_account_name}}</label>
                                        <input type="text" name="account_name" class="form-control" id="" placeholder="Input field">
                                        @if($errors->has('account_name'))
                                            <span class="help-block">{{ $errors->first('account_name') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('account_no') ? ' has-error' : '' }}">
                                        <label for="">{{config('label')->bank_account_number}}</label>
                                        <input type="text" name="account_no" class="form-control" id="" placeholder="Input field">

                                        @if($errors->has('account_no'))
                                            <span class="help-block">{{ $errors->first('account_no') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="">{{config('label')->select_bank}}</label>
                                        
                                        @foreach ($banks as $element)
                                        <div class="radio">
                                            <label class="col-md-6">
                                                <input type="radio" name="bank_id" value="{{$element->id}}" checked="checked">{{$element->bank_name}}, {{$element->account_name}}, {{$element->account_no}}
                                            </label>
                                        </div>
                                        @endforeach
                                        <br>
                                        <br>
                                        
                                    </div>
                                    <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                        <label for=""><h4>{{config('label')->amount}} : <span id="amount" style="display:none;">{{$order->total}}</span>{{xformatMoney($order->total)}}</h4></label>
                                        <input id="currency" type="text" name="amount" class="form-control" placeholder="Input payment">

                                        @if($errors->has('amount'))
                                            <span class="help-block">{{ $errors->first('amount') }}</span>
                                        @endif
                                    </div>
                                    <input type="hidden" id="refresh" value="no">
                                    <button type="submit" class="btn btn-primary pull-right">{{config('label')->submit}}</button>
                                </form>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('header')
    <link rel="stylesheet" href="{{ url('/') }}/src/public/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
    @endsection
    @section('footer')
    <script type="text/javascript">
    $(document).ready(function(e) {
    var $input = $('#refresh');
    $input.val() == 'yes' ? location.reload(true) : $input.val('yes');
    });
    </script>
    <script type="text/javascript" src="{{ url('/') }}/src/public/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript">
    var format = function(num){
    var str = num.toString().replace("$", ""), parts = false, output = [], i = 1, formatted = null;
    if(str.indexOf(".") > 0) {
    parts = str.split(".");
    str = parts[0];
    }
    str = str.split("").reverse();
    for(var j = 0, len = str.length; j < len; j++) {
    if(str[j] != ",") {
    output.push(str[j]);
    if(i%3 == 0 && j < (len - 1)) {
    output.push(",");
    }
    i++;
    }
    }
    formatted = output.reverse().join("");
    return(formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
    };
    $(function(){
        $("#currency").keyup(function(e){
            $(this).css('color', 'red');
            $(this).val(format($(this).val()));
            if (format($("#amount").text()) === $("#currency").val()) {
                $("#currency").css('color', 'black');
            }
        });
        console.log(format($("#amount").text()));
        
    });
    </script>
    <script type="text/javascript">
    $(function () {
    $('#tanggal_pembayaran').datetimepicker(
    {
    locale: 'id',
    format: 'dddd, DD/MM/YYYY'
    });
    });
    </script>
    @include('pages.partials.footer')
    @endsection