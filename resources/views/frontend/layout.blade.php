<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    @if(isset($current_page->meta_title))<title>{{{$current_page->meta_title}}}</title>@endif
    @if(isset($current_page->meta_keywords))<meta name="keywords" content="{{{$current_page->meta_keywords}}}">@endif
    @if(isset($current_page->meta_description))<meta name="description" content="{{{$current_page->meta_description}}}">@endif
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{url('/frontend/css/style.css')}}">  <!--основные стили-->
    <link rel="stylesheet" href="{{url('/plagins/hamburgers-master/hamburgers.css')}}">
    @stack('styles')
</head>
<body>
<!------------------form search -----BEGIN--------------------->
<div class="search-box-div">
    <span class="glyphicon glyphicon-remove close-btn" onClick="closeFormSearch()"></span>
    <form action="/search">
        <input type="text" name="search" placeholder="Search" id="search_input">
    </form>
</div>
<!------------------form search -----BEGIN--------------------->

<!--header info box-->
<div class="header-info-box">
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-sm-2 col-xs-4">
                <div class="social-icons-box">
                    <a href="#">
                        <i class="fa fa-facebook"></i>
                    </a>
                    <a href="#">
                        <i class="fa fa-twitter"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-10 col-sm-10 col-xs-8 control-panel">
                <div class="control-box pull-right">
                    <div class="header-block">
                        <a href="#" class="toggle-btn phone visible-xs">
                            <i class="fa fa-phone"></i>
                        </a>
                        <div class="box">
                            <a href="tel:0969916281">(096) 991 62 81</a>
                            <a href="tel:0969916281">(767) 655 86 85</a>
                        </div>
                    </div>
                    <div class="header-block">
                        <a href="#" class="toggle-btn user visible-xs">
                            <i class="fa fa-user"></i>
                        </a>
                        <div class="box">
                            <div class="hidden-xs">
                                <a href="#">Войти</a>
                                <a href="#">Регистрация</a>
                            </div>
                            <div class="visible-xs">
                                <form action="/">
                                    <input type="text">
                                    <input type="submit" value="submit">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="menu-top-box">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-4 col-xs-5 logotype-box">
                <a href="/">
                    <img src="/frontend/img/logo1.jpg" alt="logotype">
                </a>
            </div>
            <div class="col-md-7 top-menu-box">
                <ul class="main-ul">
                    <li class="main-li">
                        <a href="/">
                            <span>Главная</span>
                        </a>
                    </li>
                    <li class="main-li has-child">
                        <a href="/catalog">
                            <span>Каталог</span>
                        </a>
                        <div class="child-ul">
                            <div class="column">
                                <span class="title">ЖЕНЩИНАМ</span>
                                <ul>
                                    <li><a href="shop-list.html">rings</a></li>
                                    <li><a href="shop-left-sidebar.html">diamond ring</a></li>
                                    <li><a href="shop-right-sidebar.html">gold ring</a></li>
                                    <li><a href="shop-list.html">sliver ring</a></li>
                                    <li><a href="shop-left-sidebar.html">Platdfd eff dfdf df inum ring</a></li>
                                    <li><a href="shop-right-sidebar.html">gold ring</a></li>
                                    <li><a href="shop-list.html">sliver ring</a></li>
                                    <li><a href="shop-left-sidebar.html">Platinum ring</a></li>
                                </ul>
                            </div>
                            <div class="column">
                                <span class="title">МУЖЧИНАМ</span>
                                <ul>
                                    <li><a href="shop-list.html">Bracelets</a></li>
                                    <li><a href="shop-left-sidebar.html">diamond Bracelets</a></li>
                                    <li><a href="shop-right-sidebar.html">gold Bracelets</a></li>
                                    <li><a href="shop-left-sidebar.html">sliver Bracelets</a></li>
                                    <li><a href="shop-right-sidebar.html">Platinum Bracelets</a></li>
                                </ul>
                            </div>
                            <div class="column">
                                <span class="title">ДЕТЯМ</span>
                                <ul>
                                    <li><a href="shop-list.html">lecklaces</a></li>
                                    <li><a href="shop-right-sidebar.html">diamond lecklaces</a></li>
                                    <li><a href="shop-left-sidebar.html">gold lecklaces</a></li>
                                    <li><a href="shop-right-sidebar.html">sliver lecklaces</a></li>
                                    <li><a href="shop-left-sidebar.html">Platinum lecklaces</a></li>
                                </ul>
                            </div>
                            <div class="column image">
                                <a href="#">
                                    <img src="/frontend/img/cat1.jpg" alt="">
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="main-li">
                        <a href="#">
                            <span>Акции</span>
                        </a>
                    </li>
                    <li class="main-li">
                        <a href="#">
                            <span>ДОСТАВКА И ОПЛАТА</span>
                        </a>
                    </li>
                    <li class="main-li">
                        <a href="#">
                            <span>Контакты</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-2 col-sm-7 col-xs-5 basket-boxes">
                <ul class="navbar_user">
                    <li>
                        <a href="javascript:openFormSearch()" class="open-search-form">
                            <i class="fa fa-search"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-heart"></i>
                        </a>
                    </li>
                    <li class="checkout">
                        <a href="#">
                            <i class="fa fa-shopping-basket"></i>
                            <span id="checkout_items" class="checkout_items">2</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="hidden-md col-sm-1 col-xs-2 menu-burger-box">
                <div class="hamburger hamburger--arrow-r hamburger-btn-menu">
                    <div class="hamburger-box">
                        <div class="hamburger-inner"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@yield('main')
<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-12 logotype-box">
                <a href="/">
                    <img src="/frontend/img/logo1.jpg" alt="logotype">
                </a>
                <span class="slogan">Слоган к названию сайта</span>
                <div class="social-icons-box">
                    <a href="#">
                        <i class="fa fa-facebook"></i>
                    </a>
                    <a href="#">
                        <i class="fa fa-twitter"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 category-box">
                <ul>
                    <li>
                        <a href="/">Главная</a>
                    </li>
                    <li>
                        <a href="/catalog">Каталог</a>
                    </li>
                    <li>
                        <a href="#">Акции</a>
                    </li>
                    <li>
                        <a href="#">Доставка и оплата</a>
                    </li>
                    <li>
                        <a href="#">Контакты</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 contacts-box">
                <ul>
                    <li>
                        <a href="tel:0969916281">(096) 991 62 81</a>
                    </li>
                    <li>
                        <a href="tel:0969916281">(767) 655 86 85</a>
                    </li>
                    <li>
                        <a href="mailto:imden10@gmail.com">imden10@gmail.com</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 facebook-box">
                <img src="/frontend/img/facebook.jpg" alt="">
            </div>
        </div>
    </div>
    <div class="line"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 ol-sm-12 col-xs-12">
                <span class="copyright">
                    © 2018 mysite.com. Все права защищены.
                </span>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="{{url('/frontend/js/layout.js')}}"></script>
@stack('scripts')
</body>
</html>