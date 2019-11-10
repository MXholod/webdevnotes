<aside>
    <button id="sideBarMenuManage">Меню 
        <i class="far fa-caret-square-right fac-rule"></i>
    </button>
    <nav class="navbar navbar-light bg-light">
        <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="{{route('admin.category.index')}}">Категории</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('admin.post.index')}}">Материалы</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('admin.user_management.user.index')}}">Управление пользователями</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('admin.static-page.index')}}">Статические страницы</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
              <a class="nav-link disabled" href="#">Disabled</a>
            </li>
        </ul>
    </nav>    
</aside>