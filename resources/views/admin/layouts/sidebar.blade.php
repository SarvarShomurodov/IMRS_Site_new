<div class="left side-menu">
    <div class="slimscroll-menu" id="remove-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu" id="side-menu">
                <li class="menu-title">Overview</li>
                <li>
                    <a href="{{route('admin.index')}}" class="waves-effect">
                        <i class="ion ion-md-speedometer"></i> <!--<span class="badge badge-success badge-pill float-right">2</span>--> <span> Главная </span>
                    </a>
                </li>

                <!-- <li class="menu-title">Apps</li> -->
                <li>
                    <a href="javascript:void(0);" class="waves-effect {{ request()->is('admin/menus')||request()->is('admin/menus/create') ? 'mm-actice' : '' }}"><i class="mdi mdi-menu"></i><span> Меню <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                    <ul class="submenu">
                        <li class="{{ request()->is('admin/menus')||request()->is('admin/menus/edit/*') ? 'mm-actice' : '' }}"><a href="{{url('/admin/menus')}}">Список </a></li>
                        <li class="{{ request()->is('admin/menus/create') ? 'mm-actice' : '' }}" ><a href="{{url('admin/menus/create')}}">Добавить</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0);"><i class="mdi mdi-folder-multiple-image"></i><span> Слайдер <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                    <ul class="submenu">
                        <li class="{{ request()->is('admin/sliders') ? 'mm-actice' : '' }}"><a href="{{url('/admin/sliders')}}">Список </a></li>
                        <li class="{{ request()->is('admin/sliders/create') ? 'mm-actice' : '' }}" ><a href="{{url('admin/sliders/create')}}">Добавить</a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{url('/admin/page-heroes')}}" class="waves-effect {{ request()->is('admin/page-heroes') ? 'mm-actice' : '' }}"><i class="mdi mdi-image-area"></i><span> Фоны страниц </span></a>
                </li>

                <li>
                    <a href="javascript:void(0);" class="waves-effect {{ request()->is('admin/news')||request()->is('admin/news/create')||request()->is('admin/news/edit/*')||request()->is('admin/archives')||request()->is('admin/archives/create')||request()->is('admin/archives/edit/*') ? 'mm-actice' : '' }}"><i class="ion ion-md-paper"></i><span> Пресс-служба <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                    <ul class="submenu">
                        <li class="{{ request()->is('admin/archives')||request()->is('admin/archives/edit/*') ? 'mm-actice' : '' }}"><a href="{{url('/admin/archives')}}">Архивы (категории)</a></li>
                        <li class="{{ request()->is('admin/archives/create') ? 'mm-actice' : '' }}" ><a href="{{url('admin/archives/create')}}">Добавить архив</a></li>
                        <li class="{{ request()->is('admin/news')||request()->is('admin/news/edit/*') ? 'mm-actice' : '' }}" ><a href="{{url('/admin/news')}}">Новости</a></li>
                        <li class="{{ request()->is('admin/news/create') ? 'mm-actice' : '' }}" ><a href="{{url('/admin/news/create')}}">Добавить новость</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0);" class="waves-effect {{ request()->is('admin/laws-categories')||request()->is('admin/news/laws-categories')||request()->is('admin/laws/edit/*')||request()->is('admin/laws')||request()->is('admin/laws/create')||request()->is('admin/laws/edit/*') ? 'mm-actice' : '' }}"><i class="mdi mdi-security"></i><span> Законы <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                    <ul class="submenu">
                        <li class="{{ request()->is('admin/laws-categories')||request()->is('admin/laws-categories/edit/*') ? 'mm-actice' : '' }}"><a href="{{url('/admin/laws-categories')}}">Разделы </a></li>
                        <li class="{{ request()->is('admin/laws-categories/create') ? 'mm-actice' : '' }}" ><a href="{{url('admin/laws-categories/create')}}">Добавить раздел</a></li>
                        <li class="{{ request()->is('admin/news')||request()->is('admin/laws/edit/*') ? 'mm-actice' : '' }}" ><a href="{{url('/admin/laws')}}">Законы</a></li>
                        <li class="{{ request()->is('admin/laws/create') ? 'mm-actice' : '' }}" ><a href="{{url('/admin/laws/create')}}">Добавить закон</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-animation-play-outline"></i><span> Галерея <!--<span class="badge badge-pill badge-light float-right">New</span>--> <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                    <ul class="submenu">
                      <li class="{{ request()->is('admin/infographics')||request()->is('admin/infographics/create') ? 'mm-actice' : '' }}"><a href="/admin/infographics">Инфографика</a></li>
                      <li class="{{ request()->is('admin/photo-gallery')||request()->is('admin/photo-gallery/create') ? 'mm-actice' : '' }}"><a href="/admin/photo-gallery">Фотогалерея</a></li>
                      <li class="{{ request()->is('admin/video-gallery/create')||request()->is('admin/video-gallery') ? 'mm-actice' : '' }}"><a href="/admin/video-gallery">Видеогалерея </a></li>
                    </ul>
                </li>

                <!-- <li>
                    <a href="calendar.html" class="waves-effect"><i class="ion ion-md-calendar"></i><span> Calendar </span></a>
                </li> -->

                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i class="far fa-file-alt"></i><span> Публикации <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                    <ul class="submenu">
                        <li class="{{ request()->is('admin/publications/categories') ? 'mm-actice' : '' }}" ><a href="/admin/publications/categories">Категории</a></li>
                        <li class="{{ request()->is('admin/publications/categories/create') ? 'mm-actice' : '' }}" ><a href="/admin/publications/categories/create">Добавить категорию</a></li>
                        <li class="{{ request()->is('admin/publications') ? 'mm-actice' : '' }}" ><a href="/admin/publications">Публикации</a></li>
                        <li class="{{ request()->is('admin/publications/create') ? 'mm-actice' : '' }}" ><a href="/admin/publications/create">Добавить публикацию</a></li>
                    </ul>
                </li>


                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-school"></i><span> Наука <!--<span class="badge badge-pill badge-light float-right">New</span>--> <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                    <ul class="submenu">
                        <li class="{{ request()->is('admin/scolars') ? 'mm-actice' : '' }}"><a href="/admin/scolars">Объявления о защите</a></li>
                        <li class="{{ request()->is('admin/scolars/create') ? 'mm-actice' : '' }}"><a href="/admin/scolars/create">Добавить ученого</a></li>
                        <li class="{{ request()->is('admin/scolarwords') ? 'mm-actice' : '' }}"><a href="/admin/scolarwords">Объявления о защите (Word)</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-account-badge-horizontal"></i><span> Администрация <!--<span class="badge badge-pill badge-light float-right">New</span>--> <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                    <ul class="submenu">
                      <li class="{{ request()->is('admin/administrations') ? 'mm-actice' : '' }}"><a href="/admin/administrations">Список</a></li>
                      <li class="{{ request()->is('admin/administrations/create') ? 'mm-actice' : '' }}"><a href="/admin/administrations/create">Добавить </a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-account-group"></i><span> Сотрудники <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                    <ul class="submenu">
                      <li class="{{ request()->is('admin/employees') ? 'mm-actice' : '' }}"><a href="/admin/employees">Список</a></li>
                      <li class="{{ request()->is('admin/employees/create') ? 'mm-actice' : '' }}"><a href="/admin/employees/create">Добавить</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-file-tree"></i><span> Структура <!--<span class="badge badge-pill badge-light float-right">New</span>--> <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                    <ul class="submenu">
                      <li class="{{ request()->is('admin/structure') ? 'mm-actice' : '' }}"><a href="/admin/structure">Список</a></li>
                      <li class="{{ request()->is('admin/structure/create') ? 'mm-actice' : '' }}"><a href="/admin/structure/create">Добавить </a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-newspaper"></i><span> Журнал <!--<span class="badge badge-pill badge-light float-right">New</span>--> <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                    <ul class="submenu">
                      <li class="{{ request()->is('admin/journals') ? 'mm-actice' : '' }}"><a href="/admin/journals">Список</a></li>
                      <li class="{{ request()->is('admin/journals/create') ? 'mm-actice' : '' }}"><a href="/admin/journals/create">Добавить</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-image"></i><span> Страницы <!--<span class="badge badge-pill badge-light float-right">New</span>--> <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                    <ul class="submenu">
                      <li class="{{ request()->is('admin/pages-categories') ? 'mm-actice' : '' }}"><a href="/admin/pages-categories">Список категорий</a></li>
                      <li class="{{ request()->is('admin/pages-categories/create') ? 'mm-actice' : '' }}"><a href="/admin/pages-categories/create">Добавить категорию</a></li>
                      <li class="{{ request()->is('admin/pages') ? 'mm-actice' : '' }}"><a href="/admin/pages">Список страниц</a></li>
                      <li class="{{ request()->is('admin/pages/create') ? 'mm-actice' : '' }}"><a href="/admin/pages/create">Добавить страницу</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-weather-cloudy"></i><span> Погода и Курс $ <!--<span class="badge badge-pill badge-light float-right">New</span>--> <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                    <ul class="submenu">
                      <li class="{{ request()->is('admin/weather') ? 'mm-actice' : '' }}"><a href="/admin/weather">Погода (иконки)</a></li>
                      <li class="{{ request()->is('admin/weathers') ? 'mm-actice' : '' }}"><a href="/admin/weathers">Список</a></li>
                      <li class="{{ request()->is('admin/weathers/create') ? 'mm-actice' : '' }}"><a href="/admin/weathers/create">Добавить</a></li>
                    </ul>
                </li>

                @php $count = \App\Models\Offer::where('status', '0')->count(); @endphp
                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-file-document-edit-outline"></i><span> Предложения &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; @if($count>0)  <span class="badge badge-pill badge-light">{{$count}}</span> @endif <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                    <ul class="submenu">
                      <li class="{{ request()->is('admin/offers') ? 'mm-actice' : '' }}"><a href="/admin/offers">Список</a></li>
                    </ul>
                </li>



            </ul>

        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
