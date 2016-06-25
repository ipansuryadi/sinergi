@extends('admin.dash')

@section('content')

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <a href="#menu-toggle" class="btn btn-default visible-xs" id="menu-toggle"><i class="fa fa-bars fa-5x"></i></a>
        <div class="container-fluid" id="Admin_Dashboard_Container">
            <div class="row" id="Admin_Dashboard_Row">

                <div class="col-lg-12" id="Admin_Dashboard-col-md-12">

                    <div class="col-sm-12 col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading danger-color-dark white-text"><i class="fa fa-archive" aria-hidden="true"></i> &nbsp;Product Stock Alerts</div>
                            <div class="panel-body">
                                <div style="overflow: auto; height: 275px;">
                                    @include('admin.pages.partials.product_quantity_alert')
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- close col-lg-12 -->



            </div>  <!-- close row -->
        </div>  <!-- close container-fluid -->
    </div>  <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->

<script>
    var barChartData = {
        labels : [
            @foreach($orders as $order)
                    "#{{ $order->id }}",
            @endforeach
        ],
        datasets : [
            {
                fillColor : "rgba(220,220,220,0.5)",
                strokeColor : "rgba(220,220,220,0.8)",
                highlightFill: "#33b5e5",
                highlightStroke: "rgba(220,220,220,1)",
                data : [
                    @foreach($orders as $order)
                    {{ $order->total }},
                    @endforeach
                ]
            }
        ]
    };

    window.onload = function(){
        var ctx = document.getElementById("myChart").getContext("2d");
        window.myBar = new Chart(ctx).Bar(barChartData, {
            responsive: true,
            maintainAspectRatio: true,
            scaleOverride: true,
            scaleSteps: 10,
            scaleStepWidth: 5000000,
            scaleStartValue: 0,
            animationSteps: 60,
            animationEasing: "easeOutBounce"
        });
    };
</script>


@endsection
