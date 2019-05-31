
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        {{ app()->getLocale() }} <i class="fa fa-caret-down"></i>
    </a>
    <ul class="dropdown-menu">
        @foreach (config('translatable.locales') as $lang => $language)
            @if ($lang != app()->getLocale())
                <li>
                    <a href="{{ route('lang.switch', $lang) }}">
                        {{ $language }}
                    </a>
                </li>
            @endif
        @endforeach
    </ul>
</li>
@yield('content')