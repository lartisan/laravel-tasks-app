<header class="bg-white px-8 py-4 shadow-md">
    <div class="max-w-6xl flex justify-between items-center mx-auto">
        <!-- Left Side -->
        <a class="uppercase lg:tracking-wider font-extrabold text-lg flex items-center" href="/">
            <svg class="h-4 mr-2 fill-current text-indigo-600" viewBox="0 0 92 92"><path d="M36.2 14c0-2.8 2.2-5 5-5H85c2.8 0 5 2.2 5 5s-2.2 5-5 5H41.2c-2.7 0-5-2.2-5-5zM85 41H41.2c-2.8 0-5 2.2-5 5s2.2 5 5 5H85c2.8 0 5-2.2 5-5s-2.2-5-5-5zm0 32H41.2c-2.8 0-5 2.2-5 5s2.2 5 5 5H85c2.8 0 5-2.2 5-5s-2.2-5-5-5zM25 6.5C25 4.6 23.4 3 21.5 3h-15C4.6 3 3 4.6 3 6.5v15C3 23.4 4.6 25 6.5 25h15c1.9 0 3.5-1.6 3.5-3.5v-15zm0 47c0 1.9-1.6 3.5-3.5 3.5h-15C4.6 57 3 55.4 3 53.5v-15C3 36.6 4.6 35 6.5 35h15c1.9 0 3.5 1.6 3.5 3.5v15zM19 42h-9v8h9v-8zm6 43.5c0 1.9-1.6 3.5-3.5 3.5h-15C4.6 89 3 87.4 3 85.5v-15C3 68.6 4.6 67 6.5 67h15c1.9 0 3.5 1.6 3.5 3.5v15zM19 74h-9v9h9v-9z"/></svg>
            <span>Tasks<span class="text-indigo-600">App</span></span>
        </a>

        <!-- Right Side -->
        <nav class="">
            <div class="-mb-px flex justify-center space-x-8">
                @guest()
                    <a class="uppercase tracking-wide font-bold text-xs hover:text-gray-800" href="{{ route('login') }}">
                        Login
                    </a>
                @else
                    <a class="uppercase tracking-wide font-bold text-xs hover:text-gray-800" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endguest
            </div>
        </nav>
    </div>
</header>
