@extends('layouts.admin')

@section('title', 'Templates - SalamaPay')
@section('page_title', 'Website Templates')

@section('content')
@include('admin.partials.alert')

{{-- Header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-lg font-bold text-gray-900">Website Templates</h1>
        <p class="text-xs text-gray-500 mt-0.5">Manage templates that merchants can use for their payment pages</p>
    </div>
    <button type="button" onclick="openTemplateModal()" class="px-4 py-2 text-xs font-bold bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors shadow-sm flex items-center gap-1.5">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New Template
    </button>
</div>

{{-- Templates Grid --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse($templates as $template)
    <div class="bg-white rounded-xl border overflow-hidden hover:shadow-sm transition-all group">
        {{-- Thumbnail --}}
        <div class="aspect-video bg-gray-100 relative overflow-hidden">
            @if($template->thumbnail)
            <img src="{{ asset('storage/'.$template->thumbnail) }}" alt="{{ $template->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            @else
            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-emerald-50 to-gray-100">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
                </div>
            </div>
            @endif
            {{-- Badges --}}
            <div class="absolute top-2 left-2 flex gap-1.5">
                @if($template->is_premium)
                <span class="px-2 py-0.5 bg-gold-400 text-white text-[10px] font-bold rounded-md">PREMIUM</span>
                @endif
                @if(!$template->is_active)
                <span class="px-2 py-0.5 bg-gray-800/70 text-white text-[10px] font-medium rounded-md">Inactive</span>
                @endif
            </div>
            {{-- Users count --}}
            <div class="absolute bottom-2 right-2">
                <span class="px-2 py-0.5 bg-black/50 text-white text-[10px] font-medium rounded-md backdrop-blur-sm">
                    {{ $template->payment_profiles_count }} using
                </span>
            </div>
        </div>

        {{-- Info --}}
        <div class="p-4">
            <div class="flex items-start justify-between mb-2">
                <div>
                    <h3 class="text-sm font-bold text-gray-900">{{ $template->name }}</h3>
                    <p class="text-[11px] text-gray-400 mt-0.5">{{ $template->slug }}</p>
                </div>
            </div>
            <p class="text-xs text-gray-500 line-clamp-2 mb-3">{{ $template->description ?? 'No description' }}</p>

            {{-- Colors preview --}}
            @if($template->default_colors)
            <div class="flex items-center gap-1.5 mb-3">
                <span class="text-[10px] text-gray-400">Colors:</span>
                @foreach($template->default_colors as $key => $color)
                <div class="w-5 h-5 rounded-full border border-gray-200" style="background: {{ $color }}" title="{{ $key }}"></div>
                @endforeach
            </div>
            @endif

            {{-- Actions --}}
            <div class="flex items-center gap-2 pt-3 border-t border-gray-100">
                <a href="{{ route('admin.templates.users', $template->id) }}" class="flex-1 py-1.5 text-center text-xs font-medium text-emerald-600 bg-emerald-50 rounded-lg hover:bg-emerald-100 transition-colors">
                    View Users
                </a>
                <button type="button" onclick="editTemplate({{ $template->id }}, {{ json_encode($template) }})" class="px-3 py-1.5 text-xs font-medium text-gray-600 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    Edit
                </button>
                <form action="{{ route('admin.templates.destroy', $template->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this template?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3 py-1.5 text-xs font-medium text-red-500 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">Delete</button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="md:col-span-2 lg:col-span-3 bg-white rounded-xl border border-dashed border-gray-200 p-12 text-center">
        <div class="w-14 h-14 rounded-full bg-gray-50 flex items-center justify-center mx-auto mb-3">
            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
        </div>
        <p class="text-sm font-semibold text-gray-700">No templates yet</p>
        <p class="text-xs text-gray-400 mt-1 mb-4">Create your first template for merchants to use</p>
        <button type="button" onclick="openTemplateModal()" class="px-4 py-2 text-xs font-bold bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">Create Template</button>
    </div>
    @endforelse
</div>

{{-- Create/Edit Modal --}}
<div id="templateModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeTemplateModal()"></div>
    <div class="absolute right-0 top-0 h-full w-full max-w-lg bg-white shadow-2xl transform transition-transform duration-300 translate-x-full" id="templateModalPanel">
        <div class="flex flex-col h-full">
            <div class="flex items-center justify-between px-6 py-4 border-b">
                <div>
                    <h3 class="text-sm font-bold text-gray-900" id="modalTitle">New Template</h3>
                    <p class="text-[11px] text-gray-500 mt-0.5">Create a new payment page template</p>
                </div>
                <button onclick="closeTemplateModal()" class="text-gray-400 hover:text-gray-600 p-1 rounded-lg hover:bg-gray-100 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="flex-1 overflow-y-auto p-6">
                <form action="{{ route('admin.templates.store') }}" method="POST" id="templateForm" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <input type="hidden" name="template_id" id="templateId" value="">

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Template Name</label>
                        <input type="text" name="name" id="templateName" required class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200/50 transition-all">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Description</label>
                        <textarea name="description" id="templateDesc" rows="3" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200/50 transition-all resize-none"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Thumbnail</label>
                        <input type="file" name="thumbnail" accept="image/*" class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">Primary Color</label>
                            <input type="color" name="default_colors[primary]" id="colorPrimary" value="#024938" class="w-full h-10 rounded-xl border border-gray-200 cursor-pointer">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">Accent Color</label>
                            <input type="color" name="default_colors[accent]" id="colorAccent" value="#f9ac00" class="w-full h-10 rounded-xl border border-gray-200 cursor-pointer">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">Background</label>
                            <input type="color" name="default_colors[background]" id="colorBg" value="#ffffff" class="w-full h-10 rounded-xl border border-gray-200 cursor-pointer">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">Text Color</label>
                            <input type="color" name="default_colors[text]" id="colorText" value="#1f2937" class="w-full h-10 rounded-xl border border-gray-200 cursor-pointer">
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_active" id="isActive" value="1" checked class="rounded text-emerald-600 focus:ring-emerald-500 w-4 h-4">
                            <span class="text-xs text-gray-700 font-medium">Active</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_premium" id="isPremium" value="1" class="rounded text-emerald-600 focus:ring-emerald-500 w-4 h-4">
                            <span class="text-xs text-gray-700 font-medium">Premium</span>
                        </label>
                    </div>
                </form>
            </div>
            <div class="px-6 py-4 border-t bg-gray-50/50 flex gap-3">
                <button type="button" onclick="closeTemplateModal()" class="flex-1 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">Cancel</button>
                <button type="submit" form="templateForm" class="flex-1 py-2.5 text-sm font-bold bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition-colors shadow-sm">Save Template</button>
            </div>
        </div>
    </div>
</div>

<script>
const modal = document.getElementById('templateModal');
const panel = document.getElementById('templateModalPanel');
const form = document.getElementById('templateForm');
const methodInput = document.getElementById('formMethod');
const idInput = document.getElementById('templateId');

function openTemplateModal() {
    form.action = '{{ route('admin.templates.store') }}';
    methodInput.value = 'POST';
    idInput.value = '';
    document.getElementById('modalTitle').textContent = 'New Template';
    document.getElementById('templateName').value = '';
    document.getElementById('templateDesc').value = '';
    document.getElementById('isActive').checked = true;
    document.getElementById('isPremium').checked = false;
    modal.classList.remove('hidden');
    setTimeout(() => panel.classList.remove('translate-x-full'), 10);
}

function editTemplate(id, data) {
    form.action = '{{ url('admin/templates') }}/' + id;
    methodInput.value = 'PUT';
    idInput.value = id;
    document.getElementById('modalTitle').textContent = 'Edit Template';
    document.getElementById('templateName').value = data.name;
    document.getElementById('templateDesc').value = data.description || '';
    document.getElementById('isActive').checked = data.is_active;
    document.getElementById('isPremium').checked = data.is_premium;
    if (data.default_colors) {
        if (data.default_colors.primary) document.getElementById('colorPrimary').value = data.default_colors.primary;
        if (data.default_colors.accent) document.getElementById('colorAccent').value = data.default_colors.accent;
        if (data.default_colors.background) document.getElementById('colorBg').value = data.default_colors.background;
        if (data.default_colors.text) document.getElementById('colorText').value = data.default_colors.text;
    }
    modal.classList.remove('hidden');
    setTimeout(() => panel.classList.remove('translate-x-full'), 10);
}

function closeTemplateModal() {
    panel.classList.add('translate-x-full');
    setTimeout(() => modal.classList.add('hidden'), 300);
}
</script>
@endsection
