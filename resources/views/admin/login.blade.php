<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>Ifmr.uz - Панель администратора</title>
        <link rel="shortcut icon" href="assets/images/favicon.ico">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
<meta name="csrf-token" content="{{ csrf_token() }}">

        <link href="{{asset('administrators/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('administrators/assets/css/metismenu.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('administrators/assets/css/icons.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('administrators/assets/css/style.css')}}" rel="stylesheet" type="text/css">
    </head>

    <body class="">
        <div class="home-btn d-none d-sm-block">
            <a href="index.html" class="text-black"><i class="fas fa-home h2"></i></a>
        </div>

        <div class="account-pages my-5 pt-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">

                      @if ($errors->any())
                        @foreach ($errors->all() as $error)
                          <div class="alert alert-danger alert-dismissible fade show" role="alert">
                              {{ $error }}
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                        @endforeach
                      @endif
                        <div class="card bg-pattern shadow-none">
                            <div class="card-body">
                                <div class="text-center mt-4">
                                    <div class="mb-3">
                                        <a href="index.html" class="logo"><img src="/administrators/assets/images/logo-dark.png" height="50" alt="logo"></a>
                                    </div>
                                </div>
                                <div class="p-3">
                                    <h4 class="font-18 text-center">Панель администратора</h4>
                                    <!-- <p class="text-muted text-center mb-4">Sign in to continue to Veltrix.</p> -->
                                    <form class="form-horizontal" action="{{ route('admin.login') }}" method="post">
                                      @csrf
                                        <div class="form-group">
                                            <label for="username">Email</label>
                                            <input type="text" class="form-control" id="username" placeholder="Email" name="email">
                                        </div>

                                        <div class="form-group">
                                            <label for="userpassword">Пароль</label>
                                            <input type="password" class="form-control" id="userpassword" placeholder="Пароль" name="password">
                                        </div>



                                        <div class="mt-3">
                                            <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Войти</button>
                                        </div>

                                    </form>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery  -->
        <script src="{{asset('administrators/assets/js/jquery.min.js')}}"></script>
        <script src="{{asset('administrators/assets/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('administrators/assets/js/metismenu.min.js')}}"></script>
        <script src="{{asset('administrators/assets/js/jquery.slimscroll.js')}}"></script>
        <script src="{{asset('administrators/assets/js/waves.min.js')}}"></script>

        <!-- App js -->
        <script src="{{asset('administrators/assets/js/app.js')}}"></script>

    </body>

</html>
