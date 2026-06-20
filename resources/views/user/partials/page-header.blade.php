@props(['title', 'subtitle' => null, 'action' => null, 'actionUrl' => '#', 'actionLabel' => 'New'])

<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-xl lg:text-2xl font-bold text-gray-900 tracking-tight">{{ $title }}</h1>
        @if($subtitle)
        <p class="text-sm text-gray-500 mt-0.5">{{ $subtitle }}</p>
        @endif
    </div>
    @if($action)
    <a href="{{ $actionUrl }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        {{ $actionLabel }}
    </a>
    @endif
</div>
