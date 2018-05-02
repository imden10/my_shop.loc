@foreach($products as $product)
    <div class="@if (Session::get('view') == 'grid') product-block @elseif(Session::get('view') == 'list') product-block-list @endif">
        <a href="#" class="img-a">
            <div class="img" style="background-image: url('/uploads/tiny/images/products/{{$product->image}}')"></div>
        </a>
        <div class="info-list">
            <div class="info">
                <a href="#" class="name">{{str_limit($product->name,140)}}</a>
                <div class="description">{!! str_limit($product->description,200) !!}</div>
                <span class="price">{{$product->price}} грн.</span>
            </div>
            <div class="btns-box">
                <div class="to-cart-btn {{--in-cart--}}"></div>
                <div class="to-favorite {{--in-favorite--}}">
                    <span class="fa fa-heart"></span>
                </div>
            </div>
            <div class="stickers">
                <div class="sticker new"><span>Новинка</span></div>
                <div class="sticker hit"><span>Хит<br> продаж</span></div>
                <div class="sticker sale"><span>Акция</span></div>
            </div>
        </div>
    </div>
@endforeach