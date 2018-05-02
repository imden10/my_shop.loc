@extends('frontend.layout')

@section('main')
    <ul class="local_menu">
        @foreach($languages as $item)
            <li><a href="{{ LaravelLocalization::getLocalizedURL($item->lang)}}">{{$item->name}}</a></li>
        @endforeach
    </ul>

    <ul class="main-ul" id="main-menu">
        @foreach($menu as $item)
            @if($item->parent_id == 0)
                <li class="main-li @if($current_page->slug == $item->slug)active @endif">
                    <a href="{{LaravelLocalization::getLocalizedURL(App::getLocale(),$item->slug) }}">
                        <span>{{$item->name}}</span>
                    </a>
                    @if (count(json_decode($item->children, true))>0)
                        <i class="fa fa-chevron-down li-btn-childs visible-xs"></i>
                        <ul class="child-ul">
                            @foreach(json_decode($item->children, true) as $child)
                                <li class="child-li">
                                    <a href="{{LaravelLocalization::getLocalizedURL(App::getLocale(),$child['slug'])}}">
                                        <span>{{$child['name']}}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endif
        @endforeach
    </ul>
@endsection

@push('scripts')
<script src="{{url('/plagin/slick-carousel/slick/slick.min.js')}}"></script>
<script src="{{url('/plagin/mixitup-v3/dist/mixitup.min.js')}}"></script>
@endpush