@php $countMenu++; @endphp
@php $order=1; @endphp
@foreach($categories as $category)
    {{-- A Category has sub-categories --}}
    @if(count($category['sublevel']) > 0)
        {{--We are on the top Level--}}
        @if($countMenu == 1)
            <li class="main-left-navbar__top-level-present">
        @else
            <li class="main-left-navbar__sub-level-present">
        @endif
            <div>
                <!--<span><i class="fab fa-html5"></i></span>-->
                @if (isset($category['menu_label']))
                    <span><i class="{{$category['menu_label'] }}"></i></span>
                @else
                    <span></span>
                @endif
                <span data-level="{{$countMenu}}" data-order="{{$order}}">
                    <a href="{{url("/category/$category[slug]")}}">{{$category['title']}}</a>
                </span>
            </div>
            <ul class="main-left-navbar__child-menu">
                @include('layouts.top_menu',['categories' => $category['sublevel']])
            </ul>
    {{-- A Category hasn't sub-categories --}}
    @else
        {{--We are on the top Level--}}
        @if($countMenu == 1)
            <li class="main-left-navbar__top-level-absent">
        @else
            <li class="main-left-navbar__sub-level-absent">
        @endif
            <div>
            @if (isset($category['menu_label']))
                <span><i class="{{$category['menu_label'] }}"></i></span>
            @else
                 <span></span>
            @endif
            <span data-level="{{$countMenu}}" data-order="{{$order}}">
                <a href="{{url("/category/$category[slug]")}}">{{$category['title']}}</a>
            </span>
        </div>
@endif
        </li>
@php $order++; @endphp
@endforeach
