<div>
    <ul>
        @foreach($staticPages as $staticPage)
            <li><a href="{{$staticPage->path}}">{{ $staticPage->title }}</a></li>
        @endforeach
    </ul>
</div>