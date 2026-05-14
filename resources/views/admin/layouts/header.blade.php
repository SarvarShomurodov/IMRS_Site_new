<div class="topbar">

    <!-- LOGO -->
    <div class="topbar-left">
        <a href="index.html" class="logo">
            <span class="logo-light">
                <img src="{{ asset('administrators/assets/images/logo-light.png') }}" alt="" height="46">
            </span>
            <span class="logo-sm">
                <img src="{{ asset('administrators/assets/images/logo-light.png') }}" alt="" height="15">
            </span>
        </a>
    </div>

    <nav class="navbar-custom">
        <ul class="navbar-right list-inline float-right mb-0">
            <!-- <li class="dropdown notification-list list-inline-item d-none d-md-inline-block">
                <form role="search" class="app-search">
                    <div class="form-group mb-0">
                        <input type="text" class="form-control" placeholder="Search..">
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </form>
            </li> -->

            <!-- full screen -->
            <li class="dropdown notification-list list-inline-item d-none d-md-inline-block">
                <a class="nav-link waves-effect" href="#" id="btn-fullscreen">
                    <i class="ion ion-md-qr-scanner noti-icon"></i>
                </a>
            </li>

            @php $count = \App\Models\Offer::where('status', '0')->count(); @endphp
            <!-- notification -->
            <li class="dropdown notification-list list-inline-item">
                <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="ion ion-md-notifications noti-icon"></i>
                    @if($count>0)<span class="badge badge-pill badge-danger noti-icon-badge">{{$count}}</span>@endif
                </a>
                @if($count>0)
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg">
                      <!-- item-->
                      <h6 class="dropdown-item-text">
                          Уведомления ({{$count}})
                      </h6>
                      <div class="slimscroll notification-item-list">
                          <!-- item-->
                          <a href="/admin/offers" class="dropdown-item notify-item active">
                              <div class="notify-icon bg-success">
                                <i class="mdi mdi-file-document-edit-outline"></i>
                              </div>
                              <p class="notify-details">Предложения</p>
                          </a>
                      </div>
                  </div>
                @endif
            </li>



        </ul>

        <ul class="list-inline menu-left mb-0">
            <li class="float-left">
                <button class="button-menu-mobile open-left waves-effect">
                    <i class="mdi mdi-menu"></i>
                </button>
            </li>
            <!-- <li class="d-none d-sm-block">
                <div class="dropdown pt-3 d-inline-block">
                    <a class="btn btn-light dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Create
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Separated link</a>
                    </div>
                </div>
            </li> -->
        </ul>

    </nav>

</div>
