@unless ($breadcrumbs->isEmpty())
<nav class="container mx-auto">
    <ol class="py-4 rounded flex flex-wrap items-center text-gray-800 font-medium text-2xl">
        @foreach ($breadcrumbs as $breadcrumb)

        @if ($breadcrumb->url && !$loop->last)
        <li>
            <a href="{{ $breadcrumb->url }}"
                class="text-indigo-600 hover:text-indigo-800 hover:underline focus:text-blue-900 focus:underline">
                {{ $breadcrumb->title }}
            </a>
        </li>
        @else
        <li>
            {{ $breadcrumb->title }}
        </li>
        @endif

        @unless($loop->last)
        <li class="text-gray-600 px-2">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24"
                viewBox="0 0 24 24" fill="currentColor">
                <g>
                    <rect fill="none" height="24" width="24"></rect>
                </g>
                <g>
                    <g>
                        <polygon points="15.5,5 11,5 16,12 11,19 15.5,19 20.5,12"></polygon>
                        <polygon points="8.5,5 4,5 9,12 4,19 8.5,19 13.5,12"></polygon>
                    </g>
                </g>
            </svg>
        </li>
        @endif

        @endforeach
    </ol>
</nav>
@endunless