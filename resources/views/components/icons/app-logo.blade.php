<div {{ $attributes->merge(['class'=>'w-16 h-16 rounded-full border relative bg-blue-950']) }}>
    <a href="/">
        <img src="{{ asset('auction.png') }}" alt="logo" class="w-full h-full object-cover rounded-full">
        <span
            class="absolute inset-x-1 top-1/2 -translate-y-1/2 text-center font-semibold text-lg bg-blue-600/60 text-white rounded-md">GRBid</span>
    </a>
</div>