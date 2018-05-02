<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left image">
            <img src="/uploads/users/{{Auth::user()->photo}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
            <p>{{Auth::user()->name}}</p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
        @permission('navigate_dashboard')
            <li @if( in_array( Request::segment(2), [''] )) class="active" @endif><a href="/master"><i class="fa fa-dashboard"></i> <span>Панель состояния</span></a></li>
        @endpermission
        @permission('navigate_catalog')
        <li @if( in_array( Request::segment(2), ['pages','categories','features','products'] )) class="active treeview" @else class="treeview" @endif>
            <a href="#">
                <i class="fa fa-list-ul"></i>
                <span>Каталог</span>
                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                <li @if(Request::is('master/categories*')) class="active" @endif><a href="/master/categories"><i class="fa fa-circle-o"></i> Категории</a></li>
                <li @if(Request::is('master/products*')) class="active" @endif><a href="/master/products"><i class="fa fa-circle-o"></i> Товары</a></li>
                <li @if(Request::is('master/pages/*')) class="active treeview" @else class="treeview" @endif>
                    <a href="#">
                        <i class="fa fa-circle-o"></i> Страницы
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                        <ul class="treeview-menu">
                            <li @if(Request::is('master/pages/main*')) class="active" @endif><a href="/master/pages/main"><i class="fa fa-circle-o"></i> Основные</a></li>
                            <li @if(Request::is('master/pages/other*')) class="active" @endif><a href="/master/pages/other"><i class="fa fa-circle-o"></i> Дополнительные</a></li>
                        </ul>
                    </a>
                </li>
                <li @if(Request::is('master/features*')) class="active" @endif><a href="/master/features"><i class="fa fa-circle-o"></i> Фильтры</a></li>
            </ul>
        </li>
        @endpermission
        @permission('navigate_design')
        <li class="treeview">
            <a href="#">
                <i class="fa fa-television fw"></i>
                <span>Дизайн</span>
                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                <li><a href=#><i class="fa fa-circle-o"></i> Банеры</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Слайдеры</a></li>
            </ul>
        </li>
        @endpermission
        @permission('navigate_additions')
        <li class="treeview">
            <a href="#">
                <i class="fa fa-puzzle-piece"></i>
                <span>Дополнения</span>
                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Доставка</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Оплата</a></li>
            </ul>
        </li>
        @endpermission
        @permission('navigate_orders')
        <li class="treeview">
            <a href="#">
                <i class="fa fa-shopping-cart"></i> <span>Заказы</span>
                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a href="pages/forms/general.html">
                        <i class="fa fa-circle-o"></i> Новые
                        <span class="pull-right-container">
                                <small class="label pull-right bg-blue">3</small>
                            </span>
                    </a>
                </li>
                <li>
                    <a href="pages/forms/advanced.html">
                        <i class="fa fa-circle-o"></i> Принятые
                        <span class="pull-right-container">
                                <small class="label pull-right bg-yellow">3</small>
                            </span>
                    </a>
                </li>
                <li>
                    <a href="pages/forms/editors.html">
                        <i class="fa fa-circle-o"></i> Выполненные
                        <span class="pull-right-container">
                                <small class="label pull-right bg-green">123</small>
                            </span>
                    </a>
                </li>
                <li>
                    <a href="pages/forms/editors.html">
                        <i class="fa fa-circle-o"></i> Отмененные
                        <span class="pull-right-container">
                                <small class="label pull-right bg-red">0</small>
                            </span>
                    </a>
                </li>
            </ul>
        </li>
        @endpermission
        @permission('navigate_feedback')
        <li>
            <a href="#">
                <i class="fa fa-volume-control-phone"></i>
                <span>Обратная связь</span>
                <span class="pull-right-container">
                        <small class="label pull-right bg-green">4</small>
                    </span>
            </a>
        </li>
        @endpermission
        @permission('navigate_users')
        <li @if(Request::is('master/users/*')) class="active treeview" @else class="treeview" @endif>
            <a href="#">
                <i class="fa fa-users"></i> <span>Пользователи</span>
                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                <li @if(Request::is('master/users/users')||Request::is('master/users/users/*')) class="active" @endif>
                    <a href="/master/users/users">
                        <i class="fa fa-circle-o"></i> Пользователи
                    </a>
                </li>
                <li @if(Request::is('master/users/users-permissions*')) class="active" @endif>
                    <a href="/master/users/users-permissions">
                        <i class="fa fa-circle-o"></i> Группы пользователей
                    </a>
                </li>
            </ul>
        </li>
        @endpermission
        @permission('navigate_settings')
        <li @if(Request::is('master/settings/*')) class="active treeview" @else class="treeview" @endif>
            <a href="#">
                <i class="fa fa-cog"></i> <span>Настройки</span>
                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                <li @if(Request::is('master/settings/main')) class="active" @endif><a href="/master/settings/main"><i class="fa fa-circle-o"></i> Общие настройки</a></li>
                <li @if(Request::is('master/settings/languages')) class="active" @endif><a href="/master/settings/languages"><i class="fa fa-circle-o"></i> Локализация</a></li>
            </ul>
        </li>
        @endpermission
    </ul>
</section>