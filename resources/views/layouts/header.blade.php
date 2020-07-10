<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{ route('home') }}">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('project.index') }}">@lang('main.project')</a>
            </li><li class="nav-item">
                <a class="nav-link" href="{{ route('my.projects') }}">@lang('main.my_projects')</a>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @lang('main.tasks')
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="{{ route('task.index') }}">@lang('main.all')</a>
                    <a class="dropdown-item" href="{{ route('task.filter','new') }}">@lang('main.new')</a>
                    <a class="dropdown-item" href="{{ route('task.filter','in_process') }}">@lang('main.in_process')</a>
                    <a class="dropdown-item" href="{{ route('task.filter','done') }}">@lang('main.done')</a>
                </div>
            </li>
            @if(isset(Auth::user()->id) && Auth::user()->is_admin == 1)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.get.users') }}">Список юзеров</a>
                </li>
            @endif

        </ul>
        <ul class="navbar-nav ml-auto nav-flex-icons">
            <li class="nav-item"> <a class="nav-link" href="{{ route('locale',__('main.set_lang')) }}">@lang('main.set_lang')</a></li>
            <li class="nav-item avatar">
                @guest
                    <a class="btn btn-outline-primary" href="{{ route('login') }}">@lang('main.log_in')</a>
                    <a style="margin-left:10px;" class="btn btn-outline-primary" href="{{ route('register') }}">@lang('main.register')</a>
                @endguest
                @auth
                    @lang('main.hello'), {{ Auth::user()->name}}
                    <a style="margin-left:10px;" class="btn btn-outline-primary"
                       href="{{ route('get-logout') }}">@lang('main.logout')</a>
                @endauth
            </li>
        </ul>
    </div>
</nav>
{{--    @guest--}}
{{--        <a class="btn btn-outline-primary" href="{{ route('login') }}">Войти</a>--}}
{{--        <a style="margin-left:10px;" class="btn btn-outline-primary" href="{{ route('register') }}">Зарегистрироваться</a>--}}
{{--    @endguest--}}
{{--    @auth--}}
{{--        <a style="margin-left:10px;" class="btn btn-outline-primary" href="{{ route('get-logout') }}">Выйти</a>--}}
{{--    @endauth--}}
</div>
