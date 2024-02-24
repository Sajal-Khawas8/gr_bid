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

<body class="flex gap-0 h-screen">
    @if (session()->has('success'))
    <x-shared.message type='success' />
    @elseif (session()->has('error'))
    <x-shared.message type='error' />
    @endif

    <aside id="admin-nav" class="w-64 h-full px-3 py-2.5 text-lg flex flex-col gap-y-8 justify-evenly absolute inset-0 z-50 lg:static bg-white">
        <header class="mx-auto my-3 w-fit">
            <x-icons.app-logo />
        </header>
        <nav>
            <ul class="space-y-7">
                <li class="flex items-center relative">
                    <x-icons.home class="w-7 h-7 mx-4" />
                    <span>Home</span>
                    <a href="/" class="absolute inset-0"></a>
                </li>
                <li class="flex items-center">
                    <h3 class="text-indigo-600 font-semibold">General</h3>
                </li>
                <li class="flex items-center relative">
                    <x-icons.events class="w-7 h-7 mx-4" />
                    <span>Events</span>
                    <a href="/dashboard/events" class="absolute inset-0"></a>
                </li>
                <li class="flex items-center relative">
                    <x-icons.inventory class="w-7 h-7 mx-4" />
                    <span>Inventory</span>
                    <a href="/dashboard/inventory" class="absolute inset-0"></a>
                </li>
                <li class="flex items-center relative">
                    <x-icons.manager class="w-7 h-7 mx-4" />
                    <span>Users</span>
                    <a href="/dashboard/users" class="absolute inset-0"></a>
                </li>
                <li class="flex items-center">
                    <h3 class="text-indigo-600 font-semibold">Others</h3>
                </li>
                <li class="flex items-center relative">
                    <x-icons.category class="w-7 h-7 mx-4" />
                    <span>Categories</span>
                    <a href="/dashboard/categories" class="absolute inset-0"></a>
                </li>
                <li class="flex items-center relative">
                    <x-icons.locations class="w-7 h-7 mx-4" />
                    <span>Locations</span>
                    <a href="/dashboard/locations" class="absolute inset-0"></a>
                </li>
                <li class="flex items-center relative">
                    <x-icons.settings class="w-7 h-7 mx-4" />
                    <span>Settings</span>
                    <a href="{{ route('settings') }}" class="absolute inset-0"></a>
                </li>
            </ul>
        </nav>
        <footer class="mt-6 font-semibold leading-9 rounded-md bg-indigo-600 text-white hover:bg-indigo-800">
            <form action="/logout" method="post">
                @csrf
                <button name="logout" id="logout" class="flex items-center w-full">
                    <x-icons.logout class="w-7 h-7 mx-4" />
                    <span>Log Out</span>
                </button>
            </form>
        </footer>
    </aside>

    <main class="flex-1 bg-gray-100 overflow-y-hidden flex flex-col relative">
        <header class="flex justify-between items-center text-sm py-2.5 px-6">
            <h3 class="text-lg font-medium">Welcome, {{ auth()->user()->name }}</h3>
            <div class="flex gap-8 items-center">
                @empty(auth()->user()->image)
                <x-icons.user-circle class="w-10 h-10 text-indigo-500" />
                @else
                <div class="w-10 h-10 rounded-full">
                    <img src="{{ Storage::url(auth()->user()->image) }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover rounded-full">
                </div>
                @endempty
                <button type="button" id="admin-menu" class="lg:hidden" onclick='document.getElementById("admin-nav").classList.toggle("hidden")'>
                    <x-icons.menu-bar class="w-8 h-8" />
                </button>
            </div>

        </header>
        <section class="flex-1 flex flex-col space-y-5 overflow-y-hidden">
            @yield("main")
        </section>
    </main>
</body>

</html>