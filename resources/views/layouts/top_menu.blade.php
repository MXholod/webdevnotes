@php $countMenu++; @endphp
@foreach($categories as $category)
    @if(count($category['sublevel']) > 0)
        <li>
            <a href="{{url("/category/$category[slug]")}}">{{$category['title']}}</a>
            @if($countMenu <= 1)
                <ul class="parent-menu__child-menu">
            @else
                <ul class="parent-menu__child-menu parent-menu__child-menu_offset">
            @endif
                @include('layouts.top_menu',['categories' => $category['sublevel']])
            </ul>
    @else
        <li>
            <a href="{{url("/category/$category[slug]")}}">{{$category['title']}}</a>
        
    @endif
        </li>
@endforeach
