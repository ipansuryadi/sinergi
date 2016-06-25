<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name=description content="{{config('label')->website_description}} />
        <meta name="keywords" content="{{config('label')->website_keyword}}" />
        <meta name="author" content="Ipan Suryadi" />
        <link rel="shortcut icon" href="{!! asset('/src/public/images/icon.png') !!}" />

        <title>{{config('label')->website_title}}</title>

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="{{ url('/') }}/src/public/css/bootstrap.min.css">
        <!-- Bootstrap core mdb.css -->
        <link rel="stylesheet" href="{{ url('/') }}/src/public/css/mdb.css">
        <!-- Include app.less file -->
        <link rel="stylesheet" href="{{ url('/') }}/src/public/less/app.css">
        <!-- Include app.scss file -->
        <link rel="stylesheet" href="{{ url('/') }}/src/public/sass/app-sass.css">
        <!-- Include sweet alert file -->
        {{-- <link rel="stylesheet" href="{{ url('/') }}/src/public/css/sweetalert.css"> --}}
        <!-- Include typeahead file -->
        {{-- <link rel="stylesheet" href="{{ url('/') }}/src/public/css/typeahead.css"> --}}
        <!-- Include lity ligh-tbox file -->
        <link rel="stylesheet" href="{{ url('/') }}/src/public/css/lity.css">
        <!-- Material Design Icons -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <!-- Font Awesome -->
        <link href="{{ url('/') }}/src/public/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" >
        <!-- Optional CSS -->
        <link rel="stylesheet" href="{{ url('/') }}/src/public/bower_components/jquery-typeahead/dist/jquery.typeahead.min.css">
        
        <link rel="stylesheet" href="{{ url('/') }}/src/public/css/custom.css">
        @yield('header')
        

    </head>
<body>

    @include('partials.nav')

    @yield('content')

    <!-- jQuery -->
    <script type="text/javascript" src="{{ url('/') }}/src/public/js/libs/jquery.js"></script>
    <!-- Include main app.js file -->
    <script type="text/javascript" src="{{ url('/') }}/src/public/js/app.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="{{ url('/') }}/src/public/js/libs/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="{{ url('/') }}/src/public/js/libs/mdb.js"></script>
    <!-- Include sweet-alert.js file -->
    {{-- <script type="text/javascript" src="{{ url('/') }}/src/public/js/libs/sweetalert.js"></script> --}}
    <!-- Include typeahead.js file -->
    {{-- <script type="application/javascript" src="{{ url('/') }}/src/public/js/libs/typeahead.js"></script> --}}
    <script src="{{ url('/') }}/src/public/bower_components/jquery-typeahead/dist/jquery.typeahead.min.js"></script>
    <script src="{{ url('/') }}/src/public/bower_components/elevatezoom/jquery.elevatezoom.js"></script>
    <!-- Include lity light-box js file -->
    <script type="application/javascript" src="{{ url('/') }}/src/public/js/libs/lity.js"></script>

    
    @yield('footer')
    <script>
    $(document).ready(function(){
    $('ul.nav li.dropdown').hover(function() {
      $(this).find('.dropdown-menu').stop(true, true).fadeIn(100);
    }, function() {
      $(this).find('.dropdown-menu').stop(true, true).fadeOut(100);
    });  
});
</script>
    <script>
        $.typeahead({
            input: '.js-typeahead-country_v1',
            minLength: 1,
            maxItem: 0,
            source: {
                data: [
                    @foreach($product_list_search as $query)
                         "{{ $query->product_list }}",
                    @endforeach
                ]
            },callback: {
        onInit: function (node) {
            console.log('Typeahead Initiated on ' + node.selector);
        }
    }
        });
    </script>
    <script>
        // new WOW().init();
    </script>

    @include('partials.flash')

    <script type="text/javascript">
        $(document).ready(function(){
            $('#loadProv').change(function() {
                var provinsi = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "{{url('/profile/kabupaten')}}",
                    data: {provinsi: provinsi, _token:'{{ csrf_token() }}'},
                    success: function(html)
                    {
                    $("#loadKab").html(html);
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#loadKab').change(function() {
                var kabupaten = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "{{url('/profile/kecamatan')}}",
                    data: {kabupaten: kabupaten, _token:'{{ csrf_token() }}'},
                    success: function(html)
                    {
                    $("#loadKec").html(html);
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(e) {
            var $input = $('#refresh');
            $input.val() == 'yes' ? location.reload(true) : $input.val('yes');
        });
    </script>
    <script type="text/javascript">
        // Delete Address
        $(document).on('click', '#delete-address-btn', function(e) {
            e.preventDefault();
            var self = $(this);
            swal({
                    title: "{{config('label')->delete_address}}",
                    text: "{{config('label')->are_you_sure_you_want_to_delete_this_address}}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "{{config('label')->yes_delete_it}}",
                    closeOnConfirm: true
                },
                function(isConfirm){
                    if(isConfirm){
                        swal("{{config('label')->deleted}}","{{config('label')->address_deleted}}", "success");
                        setTimeout(function() {
                            self.parents(".delete_form_address").submit();
                        }, 1000);
                    }
                    else{
                        swal("cancelled","{{config('label')->your_address_is_safe}}", "error");
                    }
                });
        });

        // Verify Payment
        $(document).on('click', '#verify-payment-btn', function(e) {
            e.preventDefault();
            var self = $(this);
            swal({
                    title: "{{config('label')->payment_verification}}",
                    text: "{{config('label')->are_you_sure_you_want_to_verify_this_payment}}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "{{config('label')->yes_verify_it}}",
                    closeOnConfirm: true
                },
                function(isConfirm){
                    if(isConfirm){
                        swal("{{config('label')->verify}}","{{config('label')->payment_verified}}", "success");
                        setTimeout(function() {
                            self.parents(".verify_form_payment").submit();
                        }, 1000);
                    }
                    else{
                        swal("cancelled","{{config('label')->your_payment_is_nothing_changed}}", "error");
                    }
                });
        });
    </script>
</body>
</html>
