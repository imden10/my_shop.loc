@if(Request::has('checked') || ((Request::has('price_min') && (Request::get('price_min') != $minPrice) ))|| ((Request::has('price_max') && (Request::get('price_max') != $maxPrice) )))
    <div class="selected-filters-box">
        <span class="caption">Выбранные параметры</span>
        <ul>
            @if (Request::has('checked'))
            @foreach($features as $item)
                    @foreach($item->children as $var)
                        @if (in_array($var->id,Request::get('checked')))
                            <li>
                                <span class="sf-name">{{ $var->name }}</span>
                                <span class="sf-btn-close filter {{$mode}} fa fa-times-circle" data-id="{{ $var->id }}"></span>
                            </li>
                        @endif
                    @endforeach
                @endforeach
            @endif
            @if (Request::has('price_min'))
                @if ((Request::get('price_min')!=$minPrice)||(Request::get('price_max')!=$maxPrice))
                    <li>
                        <span class="sf-name">Цена {{ Request::get('price_min') }} - {{ Request::get('price_max') }}</span>
                        <span class="sf-btn-close price {{$mode}} fa fa-times-circle"></span>
                    </li>
                @endif
            @endif
        </ul>
    </div>
@else
    <span class="caption">Фильтры</span>
@endif

<form action="" method="get" id="form_filters_{{$mode}}">
    @if($minPrice != $maxPrice)
        <div class="price-box md-mode">
            <span class="name">Цена</span>
            <div class="inputs">
                <input type="text" name="price_min" value="{{ Request::has('price_min') ? Request::get('price_min') : $minPrice}}" id="minCost-{{$mode}}">
                <span>-</span>
                <input type="text" name="price_max" value="{{ Request::has('price_max') ? Request::get('price_max') : $maxPrice}}" id="maxCost-{{$mode}}">
            </div>
            <div id="price-range-{{$mode}}"></div>
        </div>
    @endif
    @foreach($features as $item)
        <div class="features-box">
            <span class="name">{{ $item->name }}</span>
            <ul>
                @foreach($item->children as $var)
                    @if($var->parent_id == $item->id)
                        <li>
                            <label>
                                <input type="checkbox" name="checked[]" class="styler" value="{{ $var->id }}" @if (Request::has('checked') && in_array($var->id, Request::get('checked'))) checked="checked" @endif">
                                <span class="f-name">{{ $var->name }}</span>
                            </label>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    @endforeach
    <div class="filter-btn-success {{$mode}}">Подобрать товар</div>
</form>