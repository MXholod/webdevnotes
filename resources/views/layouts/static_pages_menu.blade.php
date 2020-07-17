<div>
    <ul class="navbar-nav">
        @foreach($staticPages as $staticPage)
            <li class="nav-item">
                <a class="nav-link" href="{{$staticPage->path}}">
                    {{ $staticPage->title }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
