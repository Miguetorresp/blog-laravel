<div class="category-container">
    <ul>
        <li class="nav-item {{ request()->routeIs('home.index') ? 'active' : '' }}"><a href="{{ route('home.index') }}">Todo</a></li>

        @foreach ($navbar as $category)
        <!-- Escapar datos: de esa forma se evitan ataques xss y lo que se encuentre dentro no se va poder modificar en el frontend -->
        <li class="nav-item {!! (Request::path()) == 'category/'.$category->slug ? 'active' : '' !!}">
            <a href="{{ route('categories.detail', $category->slug) }}">{{ $category->name }}</a>
        </li>
        @endforeach

        <li class="nav-item {{ request()->routeIs('home.all') ? 'active' : '' }}">
            <a href="{{ route('home.all') }}">Todas las categorias</a>
        </li>

    </ul>
</div>
