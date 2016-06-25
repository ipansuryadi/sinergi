@extends('admin.dash')
@section('content')
<!-- Page Content -->
<div id="page-content-wrapper">
    <a href="#menu-toggle" class="btn btn-default visible-xs" id="menu-toggle"><i class="fa fa-bars fa-5x"></i></a>
    <div class="container-fluid" id="Admin_Dashboard_Container">
        <div class="row" id="Admin_Dashboard_Row">
            <div class="col-lg-12" id="Admin_Dashboard-col-md-12">
                <a href="#" onclick="window.history.back();return false;" class="btn btn-danger">Back</a>
                <h4 id="Admin-Heading">Admin Dashboard</h4><br>
                <div class="col-sm-12 col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        @foreach ($orders as $order)
                        {{-- expr --}}
                        <div class="panel-heading info-color-dark white-text"><i class="fa fa-shopping-cart" aria-hidden="true"></i> &nbsp;Order Delivery No : #{{$order->kode_transaksi}}</div>
                        <div class="panel-body">
                            <b>Shipping Address</b><br>
                            Name : {{ $order->address['name'] }}<br>
                            Email : {{ $order->address['email'] }}<br>
                            Phone : {{ $order->address['phone'] }}<br>
                            Provinsi : {{ $order->address['provinsi'] }}<br>
                            Kabupaten : {{ $order->address['kabupaten'] }}<br>
                            Kecamatan : {{ $order->address['kecamatan'] }}<br>
                            Address : {{ $order->address['address'] }}<br>
                            <div class="panel-body">
                                <form action="{{ url('admin/delivery') }}" class="delivery_form" method="POST" role="form">
                                    {{ csrf_field()}}
                                    <input type="hidden" name="order_id" value="{{$order->id}}">
                                    <div class="form-group{{ $errors->has('delivery_date') ? ' has-error' : '' }}">
                                        <label for="">Delivery Date</label>
                                        <input type='text' name="delivery_date" value="{{Request::old('delivery_date')}}" class="form-control" id='datetimepicker1' />
                                        <span class="help-block">{{ $errors->first('delivery_date') }}</span>
                                    </div>
                                    <div class="form-group{{ $errors->has('kurir') ? ' has-error' : '' }}">
                                        <label for="">Courier</label>
                                        <input type="text" name="kurir" value="{{Request::old('kurir')}}"  class="form-control" id="" placeholder="Input field">
                                        <span class="help-block">{{ $errors->first('kurir') }}</span>
                                    </div>
                                    <div class="form-group{{ $errors->has('no_resi') ? ' has-error' : '' }}">
                                        <label for="">Tracking Number</label>
                                        <input type="text" name="no_resi" value="{{Request::old('no_resi')}}"  class="form-control" id="" placeholder="Input field">
                                        <span class="help-block">{{ $errors->first('no_resi') }}</span>
                                    </div>
                                    <div class="form-group{{ $errors->has('ongkir_real') ? ' has-error' : '' }}">
                                        <label for="">Delivery Cost</label>
                                        <input type="text" name="ongkir_real" value="{{Request::old('ongkir_real')}}"  class="form-control" id="" placeholder="Input field">
                                        <span class="help-block">{{ $errors->first('ongkir_real') }}</span>
                                    </div>
                                    <button type="submit" class="btn btn-primary pull-right">Submit</button>
                                </form>
                            </div>
                            
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        </div>  <!-- close row -->
        </div>  <!-- close container-fluid -->
        </div>  <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->
    @endsection
    @section('header')
    <link rel="stylesheet" href="{{ url('/') }}/src/public/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
    @stop
    @section('footer')
    <script type="text/javascript" src="{{ url('/') }}/src/public/bower_components/moment/min/moment.min.js"></script>
    <script type="text/javascript" src="{{ url('/') }}/src/public/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript">
    $(function () {
    $('#datetimepicker1').datetimepicker({
        format: 'DD/MM/YYYY'
    });
    });
    </script>
    @stop