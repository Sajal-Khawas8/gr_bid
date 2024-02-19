<button
    {{ $attributes->merge(["class" => "px-4 py-1 text-lg font-medium rounded-md w-full text-white bg-indigo-600 hover:bg-indigo-800"]) }} @disabled($disabled)>
    {{ $slot }}
</button>