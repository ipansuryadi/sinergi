<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="{!! asset('/src/public/images/slider/fav-icon.png') !!}" />

    <title>Store Dashboard</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="{{ url('/') }}/src/public/css/bootstrap.min.css">
    <!-- Bootstrap core mdb.css -->
    <link rel="stylesheet" href="{{ url('/') }}/src/public/css/mdb.css">
    <!-- Include admin.less file -->
    <link rel="stylesheet" href="{{ url('/') }}/src/public/less/admin.css">
    <link rel="stylesheet" href="{{ url('/') }}/src/public/less/app.css">
    <!-- Include app.scss file -->
    <link rel="stylesheet" href="{{ url('/') }}/src/public/sass/app-sass.css">
    <!-- Include sweet alert file -->
    <link rel="stylesheet" href="{{ url('/') }}/src/public/css/sweetalert.css">
    <!-- Include typeahead file -->
        <link rel="stylesheet" href="{{ url('/') }}/src/public/css/typeahead.css">
    <!-- Include lity light-tbox file -->
    <link rel="stylesheet" href="{{ url('/') }}/src/public/css/lity.css">
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/src/public/css/custom-admin.css">
    <!-- Include drop-zone file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/dropzone.css">
    <!-- Include Froala Editor style. -->
    <link href="{{ url('/') }}/src/public/css/froala_editor.min.css" rel="stylesheet" type="text/css" />
    <!-- Material Design Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <!-- Font Awesome -->
    <link href="{{ url('/') }}/src/public/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" >
    @yield('header')

</head>
<body>

@include('admin.pages.partials.nav')
@include('admin.pages.partials.side-nav')

@yield('content')

<!-- jQuery -->
<script type="application/javascript" src="{{ url('/') }}/src/public/js/libs/jquery.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="application/javascript" src="{{ url('/') }}/src/public/js/libs/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="application/javascript" src="{{ url('/') }}/src/public/js/libs/mdb.js"></script>
<!-- Include sweet-alert.js file -->
{{-- <script type="application/javascript" src="{{ url('/') }}/src/public/js/libs/sweetalert.js"></script> --}}
<!-- Include typeahead.js file -->
    <script type="application/javascript" src="{{ url('/') }}/src/public/js/libs/typeahead.js"></script>
<!-- Include main app.js file -->
<script type="application/javascript" src="{{ url('/') }}/src/public/js/app.js"></script>
<!-- Include lity light-box js file -->
<script type="application/javascript" src="{{ url('/') }}/src/public/js/libs/lity.js"></script>
<!-- Include moment.js for chart.js -->
<script type="application/javascript" src="{{ url('/') }}/src/public/js/libs/moment.js"></script>
<!-- Chart.js plugin -->
<script type="application/javascript" src="{{ url('/') }}/src/public/js/libs/Chart.js"></script>

@yield('footer')


@include('partials.flash')

</body>
</html>
