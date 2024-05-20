<section id="header">
    <div class="wrapper">
        <div class="header-con">
            <ul class="navbar">
                @guest
                    <li>
                        <a href="{{ route('welcome') }}">Login</a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}">Register</a>
                    </li>
                @endguest
                @auth
                    @if (auth()->user()->type == 1)
                        <li>
                            <a href="{{ route('homepage') }}">Home</a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}">Logout</a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('homepage') }}">Home</a>
                        </li>
                        <li>
                            <a href="{{ route('orders') }}">Order</a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}">Logout</a>
                        </li>
                    @endif
                @endauth
            </ul>
            <button class="mobile-btn">
                <i class="bi bi-list"></i>
            </button>
        </div>
    </div>
</section>
<section id="mobile-nav">
    <ul class="navbar">
        @guest
            <li>
                <a href="{{ route('welcome') }}">Login</a>
            </li>
            <li>
                <a href="{{ route('register') }}">Register</a>
            </li>
        @endguest
        @auth
            <li>
                <a href="{{ route('homepage') }}">Home</a>
            </li>
            <li>
                <a href="{{ route('orders') }}">Order</a>
            </li>
            <li>
                <a href="{{ route('logout') }}">Logout</a>
            </li>
        @endauth
    </ul>
</section>
