<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>GRBid</title>

    <link rel="shortcut icon" href="{{ asset('auction.png') }}" type="image/x-icon">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">

    <!-- Styles and Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    {{-- header --}}
    <header class="flex justify-between items-center bg-white px-10 py-4 shadow-lg sticky top-0 z-50">
        <x-icons.app-logo />
        <nav id="main-nav"
            class="bg-white flex-1 hidden space-y-7 lg:space-y-0 absolute lg:static top-24 left-0 z-50 py-5 lg:p-0 shadow-md lg:shadow-none lg:flex items-center justify-center">
            <ul
                class="flex-1 flex flex-col lg:flex-row items-center justify-center gap-x-16 gap-y-6 font-medium text-lg text-center">
                <li
                    class="hover:text-sky-600 px-20 py-5 lg:p-0 w-full lg:w-auto active:bg-slate-200 lg:active:bg-white">
                    <a href="/">Home</a>
                </li>
                <li
                    class="hover:text-sky-600 px-20 py-5 lg:p-0 w-full lg:w-auto active:bg-slate-200 lg:active:bg-white">
                    <a href="/aboutUs">About Us</a>
                </li>
                <li
                    class="hover:text-sky-600 px-20 py-5 lg:p-0 w-full lg:w-auto active:bg-slate-200 lg:active:bg-white">
                    <a href="/#events">Events</a>
                </li>

                <li
                    class="hover:text-sky-600 px-20 py-5 lg:p-0 w-full lg:w-auto active:bg-slate-200 lg:active:bg-white">
                    <a href="/#contactUs">Contact Us</a>
                </li>
            </ul>
            @auth
            <form action="/logout" method="post">
                @csrf
                <button title="Log Out">
                    <x-icons.logout class="w-7 h-7" />
                </button>
            </form>
            @else
            <div class="w-12 h-12 rounded-full shadow-md mx-auto lg:m-0">
                <a href="/login" title="My Account">
                    <x-icons.user-circle class="w-full h-full text-gray-500" />
                </a>
            </div>
            @endauth
        </nav>
        <div>
            <button id="menu" type="button" onclick='document.getElementById("main-nav").classList.toggle("hidden")'>
                <x-icons.menu-bar class="w-8 h-8 text-black lg:hidden" />
            </button>
        </div>
    </header>

    {{-- Notification --}}
    @if (session()->has('success'))
    <x-shared.message type='success' />
    @elseif (session()->has('error'))
    <x-shared.message type='error' />
    @endif

    {{-- main content of page --}}
    <main>
        @yield("main")
    </main>

    {{-- footer --}}
    <footer id="contactUs"
        class="bg-gradient-to-b from-gray-900 to-violet-950 relative px-16 divide-y divide-gray-200 text-gray-300">
        <div class="py-6 pt-12 flex flex-col lg:flex-row justify-between gap-y-16">
            <section class="flex-1 flex flex-col lg:flex-row gap-16">
                <div class="lg:max-w-72 space-y-7">
                    <x-icons.app-logo class="mx-auto" />
                    <p>
                        You can all our call center, we are open on weekdays from <time datetime="09:00"> 9:00 AM
                        </time> to <time datetime="20:00"> 8:00PM
                        </time> and on weekends from
                        <time datetime="09:00"> 9:00AM </time> to <time datetime="13:00"> 1:00PM </time>
                    </p>
                    <address class="flex flex-col gap-2">
                        <a href="tel:+1-340-618-7841">+1-340-618-7841</a>
                        <a href="mailto:hello-bidpro@mail.com">hello-bidpro@mail.com</a>
                    </address>
                </div>
                <div class="space-y-6">
                    <h3 class="text-2xl font-medium">Useful Links</h3>
                    <ul class="space-y-4 list-['-'] list-inside text-red-600 font-black">
                        <li>
                            <a href="/"
                                class="text-gray-300 font-normal ml-1 hover:absolute hover:translate-x-1 hover:translate-y-1">Home</a>
                        </li>
                        <li>
                            <a href="/aboutUs"
                                class="text-gray-300 font-normal ml-1 hover:absolute hover:translate-x-1 hover:translate-y-1">About
                                Us</a>
                        </li>
                        <li>
                            <a href="/#events"
                                class="text-gray-300 font-normal ml-1 hover:absolute hover:translate-x-1 hover:translate-y-1">Events</a>
                        </li>
                        <li>
                            <a href="/#contactUs"
                                class="text-gray-300 font-normal ml-1 hover:absolute hover:translate-x-1 hover:translate-y-1">Contact
                                Us</a>
                        </li>
                    </ul>
                </div>
            </section>
            <section class="flex-1 lg:max-w-96 space-y-6">
                <h3 class="text-2xl font-medium">Newsletter</h3>

                <form action="#" method="post" class="flex flex-col gap-y-6">
                    @csrf
                    <div class="space-y-4 w-full">
                        <label for="email">Join our Newsletter to get updates:</label>
                        <input type="email" name="email" id="email" placeholder="Your Email"
                            class="px-4 py-3 rounded-md w-full text-black outline-none">
                    </div>
                    <button
                        class="w-fit px-10 py-3 bg-blue-700 rounded-md text-lg font-semibold text-white uppercase">Subscribe</button>
                </form>
            </section>
        </div>
        <div class="py-6 text-center">&copy; {{ now()->year }} GRBid. All rights reserved.</div>
    </footer>

</body>

</html>