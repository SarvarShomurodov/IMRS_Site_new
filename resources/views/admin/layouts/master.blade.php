<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>ifmr.uz Админ панель</title>
        <meta content="Responsive admin theme build on top of Bootstrap 4" name="description" />
        <meta content="Themesbrand" name="author" />
        <link rel="shortcut icon" href="{{ asset('administrators/assets/images/favicon.ico') }}">

        <link href="{{ asset('administrators/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('administrators/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
        <link href="{{ asset('administrators/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}" rel="stylesheet">
        <link href="{{ asset('administrators/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" />

        <link href="{{ asset('administrators/plugins/emoji-picker-master/css/emoji.css') }}" rel="stylesheet">

        <!-- jvectormap -->
        <link href="{{ asset('administrators/plugins/jvectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet">

        <link href="{{ asset('administrators/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('administrators/assets/css/metismenu.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('administrators/assets/css/icons.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('administrators/assets/css/style.css') }}" rel="stylesheet" type="text/css">
        @yield('css')
    </head>

    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            @include('admin.layouts.header')
            <!-- Top Bar End -->

            <!-- ========== Left Sidebar Start ========== -->
            @include('admin.layouts.sidebar')
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                @yield('content')
            </div>

            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->


        <!-- jQuery  -->
        <script src="{{ asset('administrators/assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('administrators/assets/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('administrators/assets/js/metismenu.min.js') }}"></script>
        <script src="{{ asset('administrators/assets/js/jquery.slimscroll.js') }}"></script>
        <script src="{{ asset('administrators/assets/js/waves.min.js') }}"></script>
        @yield('script')

        <!-- datepicker -->
        <script src="{{ asset('administrators/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>

        <script src="{{ asset('administrators/plugins/select2/js/select2.min.js') }}"></script>
        <script src="{{ asset('administrators/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
        <script src="{{ asset('administrators/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js') }}"></script>
        <script src="{{ asset('administrators/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
        <script src="{{ asset('administrators/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}"></script>

        <script src="{{ asset('administrators/plugins/emoji-picker-master/js/config.js') }}"></script>
        <script src="{{ asset('administrators/plugins/emoji-picker-master/js/util.js') }}"></script>
        <script src="{{ asset('administrators/plugins/emoji-picker-master/js/jquery.emojiarea.js') }}"></script>
        <script src="{{ asset('administrators/plugins/emoji-picker-master/js/emoji-picker.js') }}"></script>

        <script src="{{ asset('administrators/assets/pages/form-advanced.init.js') }}"></script>
        @yield('multiselect')

        <script src="{{ asset('administrators/assets/pages/dashboard.js') }}"></script>

        <!-- App js -->
        <script src="{{ asset('administrators/assets/js/app.js') }}"></script>

    </body>

</html>
