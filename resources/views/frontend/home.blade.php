@extends('frontend.layout')

@section('main')
    <!--MOD-----Главный слайдер-----BEGIN------------------------------>
    <div class="slider-box top-container">
        <div class="slider">
            <div class="slide">
                <a href="#">
                    <img  src="/frontend/img/slide1.jpg" alt="slide1">
                </a>
            </div>
            <div class="slide">
                <a href="#">
                    <img  src="/frontend/img/slide2.jpg" alt="slide1">
                </a>
            </div>
            <div class="slide">
                <a href="#">
                    <img  src="/frontend/img/slide3.jpg" alt="slide1">
                </a>
            </div>
        </div>
        <i class="fa fa-angle-left main-slider-btn-left arrow-btn"></i>
        <i class="fa fa-angle-right main-slider-btn-right arrow-btn"></i>
    </div>
    <!--MOD-----END------------------------------------------------------>

    <!--MOD-----Любимые категории-----BEGIN------------------------------>
    <div class="container module-category-box">
        <div class="row">
            <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12 cat-boxes">
                        <a href="#" style="background-image: url('/frontend/img/cat-img-1.jpg')">
                            <div class="caption">
                                <span class="title">Юбки</span>
                                <p>Какое то описание  категории длиное бывает иногда</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 cat-boxes">
                        <a href="#" style="background-image: url('/frontend/img/cat-img-2.jpg')">
                            <div class="caption">
                                <span class="title">Сумки</span>
                                <p>Какое то описание  категории</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 cat-boxes bottom">
                        <a href="#" style="background-image: url('/frontend/img/cat-img-4.jpg')">
                            <div class="caption">
                                <span class="title">Платья</span>
                                <p>Какое то описание  категории</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12 cat-boxes right">
                <a href="#" style="background-image: url('/frontend/img/cat-img-3.jpg')">
                    <div class="caption">
                        <span class="title">Кардиганы</span>
                        <p>Какое то описание  категории длиное бывает иногда</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!--MOD-----END------------------------------------------------------------->

    <!--MOD-----MIXITUP-----BEGIN----------------------------------------------->
    <div class="mixitup-box">
        <div class="container mixitup">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="controls">
                        <button type="button" class="control mixitup-control-active" data-filter="all" data-sort="random">Все</button>
                        <button type="button" class="control" data-filter=".new">Новинки</button>
                        <button type="button" class="control" data-filter=".shares">Акции</button>
                        <button type="button" class="control" data-filter=".popular">Популярные</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="mix new col-md-3 col-sm-4 col-xs-12">
                    <div class="product">
                        <a href="#">
                            <div class="img" style="background-image: url('/frontend/img/shop/kardigan1.jpg')"></div>
                        </a>
                        <div class="info">
                            <a href="#" class="name">Кардиган</a>
                            <span class="price">156 грн.</span>
                        </div>
                        <div class="btns-box">
                            <div class="to-cart-btn"></div>
                            <div class="to-favorite in-favorite">
                                <span class="fa fa-heart"></span>
                            </div>
                        </div>
                        <div class="stickers">
                            <div class="sticker new"><span>Новинка</span></div>
                            <div class="sticker hit"><span>Хит<br> продаж</span></div>
                        </div>
                    </div>
                </div>
                <div class="mix new col-md-3 col-sm-4 col-xs-12">
                    <div class="product">
                        <a href="#">
                            <div class="img" style="background-image: url('/frontend/img/shop/dress2.jpg')"></div>
                        </a>
                        <div class="info">
                            <a href="#" class="name">Юбка</a>
                            <span class="price">130 грн.</span>
                        </div>
                        <div class="btns-box">
                            <div class="to-cart-btn in-cart"></div>
                            <div class="to-favorite">
                                <span class="fa fa-heart"></span>
                            </div>
                        </div>
                        <div class="stickers">
                            <div class="sticker new"><span>Новинка</span></div>
                        </div>
                    </div>
                </div>
                <div class="mix new col-md-3 col-sm-4 col-xs-12">
                    <div class="product">
                        <a href="#">
                            <div class="img" style="background-image: url('/frontend/img/shop/dress3.jpg')"></div>
                        </a>
                        <div class="info">
                            <a href="#" class="name">Платье</a>
                            <span class="price">140 грн.</span>
                        </div>
                        <div class="btns-box">
                            <div class="to-cart-btn"></div>
                            <div class="to-favorite">
                                <span class="fa fa-heart"></span>
                            </div>
                        </div>
                        <div class="stickers">
                            <div class="sticker new"><span>Новинка</span></div>
                        </div>
                    </div>
                </div>
                <div class="mix new col-md-3 col-sm-4 col-xs-12">
                    <div class="product">
                        <a href="#">
                            <div class="img" style="background-image: url('/frontend/img/shop/dress1.jpg')"></div>
                        </a>
                        <div class="info">
                            <a href="#" class="name">Платье</a>
                            <span class="price">140 грн.</span>
                        </div>
                        <div class="btns-box">
                            <div class="to-cart-btn"></div>
                            <div class="to-favorite">
                                <span class="fa fa-heart"></span>
                            </div>
                        </div>
                        <div class="stickers">
                            <div class="sticker new"><span>Новинка</span></div>
                        </div>
                    </div>
                </div>
                <div class="mix shares col-md-3 col-sm-4 col-xs-12">
                    <div class="product">
                        <a href="#">
                            <div class="img" style="background-image: url('/frontend/img/shop/shorty1.jpg')"></div>
                        </a>
                        <div class="info">
                            <a href="#" class="name">Шорты</a>
                            <span class="price">156 грн.</span>
                        </div>
                        <div class="btns-box">
                            <div class="to-cart-btn"></div>
                            <div class="to-favorite in-favorite">
                                <span class="fa fa-heart"></span>
                            </div>
                        </div>
                        <div class="stickers">
                            <div class="sticker sale"><span>Акция</span></div>
                        </div>
                    </div>
                </div>
                <div class="mix shares col-md-3 col-sm-4 col-xs-12">
                    <div class="product">
                        <a href="#">
                            <div class="img" style="background-image: url('/frontend/img/shop/shorty2.jpg')"></div>
                        </a>
                        <div class="info">
                            <a href="#" class="name">Шорты</a>
                            <span class="price">130 грн.</span>
                        </div>
                        <div class="btns-box">
                            <div class="to-cart-btn in-cart"></div>
                            <div class="to-favorite">
                                <span class="fa fa-heart"></span>
                            </div>
                        </div>
                        <div class="stickers">
                            <div class="sticker sale"><span>Акция</span></div>
                        </div>
                    </div>
                </div>
                <div class="mix shares col-md-3 col-sm-4 col-xs-12">
                    <div class="product">
                        <a href="#">
                            <div class="img" style="background-image: url('/frontend/img/shop/komplect1.jpeg')"></div>
                        </a>
                        <div class="info">
                            <a href="#" class="name">Комплект</a>
                            <span class="price">140 грн.</span>
                        </div>
                        <div class="btns-box">
                            <div class="to-cart-btn"></div>
                            <div class="to-favorite">
                                <span class="fa fa-heart"></span>
                            </div>
                        </div>
                        <div class="stickers">
                            <div class="sticker sale"><span>Акция</span></div>
                        </div>
                    </div>
                </div>
                <div class="mix shares col-md-3 col-sm-4 col-xs-12">
                    <div class="product">
                        <a href="#">
                            <div class="img" style="background-image: url('/frontend/img/shop/komplect2.jpeg')"></div>
                        </a>
                        <div class="info">
                            <a href="#" class="name">Комплект</a>
                            <span class="price">140 грн.</span>
                        </div>
                        <div class="btns-box">
                            <div class="to-cart-btn"></div>
                            <div class="to-favorite">
                                <span class="fa fa-heart"></span>
                            </div>
                        </div>
                        <div class="stickers">
                            <div class="sticker sale"><span>Акция</span></div>
                        </div>
                    </div>
                </div>
                <div class="mix popular col-md-3 col-sm-4 col-xs-12">
                    <div class="product">
                        <a href="#">
                            <div class="img" style="background-image: url('/frontend/img/shop/shorty1.jpg')"></div>
                        </a>
                        <div class="info">
                            <a href="#" class="name">Шорты</a>
                            <span class="price">156 грн.</span>
                        </div>
                        <div class="btns-box">
                            <div class="to-cart-btn"></div>
                            <div class="to-favorite in-favorite">
                                <span class="fa fa-heart"></span>
                            </div>
                        </div>
                        <div class="stickers">
                            <div class="sticker hit"><span>Хит<br> продаж</span></div>
                        </div>
                    </div>
                </div>
                <div class="mix popular col-md-3 col-sm-4 col-xs-12">
                    <div class="product">
                        <a href="#">
                            <div class="img" style="background-image: url('/frontend/img/shop/shorty2.jpg')"></div>
                        </a>
                        <div class="info">
                            <a href="#" class="name">Шорты</a>
                            <span class="price">130 грн.</span>
                        </div>
                        <div class="btns-box">
                            <div class="to-cart-btn in-cart"></div>
                            <div class="to-favorite">
                                <span class="fa fa-heart"></span>
                            </div>
                        </div>
                        <div class="stickers">
                            <div class="sticker hit"><span>Хит<br> продаж</span></div>
                        </div>
                    </div>
                </div>
                <div class="mix popular col-md-3 col-sm-4 col-xs-12">
                    <div class="product">
                        <a href="#">
                            <div class="img" style="background-image: url('/frontend/img/shop/komplect1.jpeg')"></div>
                        </a>
                        <div class="info">
                            <a href="#" class="name">Комплект</a>
                            <span class="price">140 грн.</span>
                        </div>
                        <div class="btns-box">
                            <div class="to-cart-btn"></div>
                            <div class="to-favorite">
                                <span class="fa fa-heart"></span>
                            </div>
                        </div>
                        <div class="stickers">
                            <div class="sticker hit"><span>Хит<br> продаж</span></div>
                        </div>
                    </div>
                </div>
                <div class="mix popular col-md-3 col-sm-4 col-xs-12">
                    <div class="product">
                        <a href="#">
                            <div class="img" style="background-image: url('/frontend/img/shop/komplect2.jpeg')"></div>
                        </a>
                        <div class="info">
                            <a href="#" class="name">Комплект</a>
                            <span class="price">140 грн.</span>
                        </div>
                        <div class="btns-box">
                            <div class="to-cart-btn"></div>
                            <div class="to-favorite">
                                <span class="fa fa-heart"></span>
                            </div>
                        </div>
                        <div class="stickers">
                            <div class="sticker hit"><span>Хит<br> продаж</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--MOD-----END------------------------------------------------------------------------>

    <div class="container body-box">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <p>
                    description
                </p>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{url('/plagins/slick-carousel/slick/slick.css')}}"/>
<link rel="stylesheet" href="{{url('/plagins/slick-carousel/slick/slick-theme.css')}}"/>
@endpush

@push('scripts')
<script src="{{url('/plagins/slick-carousel/slick/slick.min.js')}}"></script>
<script src="{{url('/plagins/mixitup-v3/dist/mixitup.min.js')}}"></script>
<script src="{{url('/frontend/js/home.js')}}"></script>
@endpush