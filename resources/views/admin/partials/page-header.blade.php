@props(['title', 'subtitle' => null])

<div class="mb-6">
    <h1 class="text-xl lg:text-2xl font-bold text-gray-900 tracking-tight">{{ $title }}</h1>
    @if($subtitle)
    <p class="text-sm text-gray-500 mt-0.5">{{ $subtitle }}</p>
    @endif
</div>
