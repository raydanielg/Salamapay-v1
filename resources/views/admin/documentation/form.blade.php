@extends('layouts.admin')

@section('title', ($page ? 'Edit' : 'New') . ' Doc Page - SalamaPay')
@section('page_title', ($page ? 'Edit' : 'New') . ' Documentation Page')

@section('content')
@include('admin.partials.alert')

@include('admin.partials.page-header', [
    'title' => ($page ? 'Edit' : 'New') . ' Page',
    'subtitle' => $page ? 'Update documentation content' : 'Create a new documentation page'
])

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Form --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl border p-6">
            <form action="{{ $page ? route('admin.documentation.update', $page->id) : route('admin.documentation.store') }}" method="POST" class="space-y-5">
                @csrf
                @if($page) @method('PUT') @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Page Title</label>
                        <input type="text" name="title" value="{{ old('title', $page?->title) }}" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" placeholder="e.g. Getting Started" required>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Slug</label>
                        <input type="text" name="slug" value="{{ old('slug', $page?->slug) }}" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none font-mono" placeholder="getting-started">
                        <p class="text-[10px] text-gray-400 mt-1">Auto-generated from title if left empty</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Category</label>
                        <select name="category" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none bg-white" required>
                            <option value="general" {{ old('category', $page?->category) === 'general' ? 'selected' : '' }}>General</option>
                            <option value="api" {{ old('category', $page?->category) === 'api' ? 'selected' : '' }}>API Reference</option>
                            <option value="getting_started" {{ old('category', $page?->category) === 'getting_started' ? 'selected' : '' }}>Getting Started</option>
                            <option value="payments" {{ old('category', $page?->category) === 'payments' ? 'selected' : '' }}>Payments</option>
                            <option value="webhooks" {{ old('category', $page?->category) === 'webhooks' ? 'selected' : '' }}>Webhooks</option>
                            <option value="security" {{ old('category', $page?->category) === 'security' ? 'selected' : '' }}>Security</option>
                            <option value="faq" {{ old('category', $page?->category) === 'faq' ? 'selected' : '' }}>FAQ</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Sort Order</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $page?->sort_order ?? 0) }}" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" min="0">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Content</label>
                    <textarea name="content" id="docContent" rows="20" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none font-mono text-xs resize-none" placeholder="Write your documentation content here... Markdown supported.">{{ old('content', $page?->content) }}</textarea>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_published" id="isPublished" value="1" {{ old('is_published', $page?->is_published ?? false) ? 'checked' : '' }} class="rounded text-emerald-600 focus:ring-emerald-500">
                    <label for="isPublished" class="text-xs font-medium text-gray-700">Publish this page (visible to public)</label>
                </div>

                <div class="pt-2 flex items-center gap-3">
                    <button type="submit" class="px-6 py-2.5 text-sm font-bold bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition-colors shadow-sm">{{ $page ? 'Update Page' : 'Create Page' }}</button>
                    <a href="{{ route('admin.documentation') }}" class="text-sm text-gray-500 hover:text-gray-700">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Preview & Help --}}
    <div class="space-y-4">
        <div class="bg-emerald-900 rounded-xl p-5 text-white">
            <h3 class="text-sm font-semibold mb-2">Markdown Tips</h3>
            <div class="space-y-1.5 text-[11px] text-emerald-200 font-mono">
                <p># Heading 1</p>
                <p>## Heading 2</p>
                <p>**Bold text**</p>
                <p>*Italic text*</p>
                <p>- List item</p>
                <p>`code`</p>
                <p>[Link text](url)</p>
            </div>
        </div>

        @if($page)
        <div class="bg-white rounded-xl border p-5">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Page Info</h3>
            <div class="space-y-2 text-xs text-gray-600">
                <p class="flex justify-between"><span>Created</span><span>{{ $page->created_at->format('M d, Y H:i') }}</span></p>
                <p class="flex justify-between"><span>Updated</span><span>{{ $page->updated_at->format('M d, Y H:i') }}</span></p>
                <p class="flex justify-between"><span>Views</span><span>{{ $page->slug }}</span></p>
            </div>
            <div class="mt-3 pt-3 border-t">
                <a href="{{ route('docs', $page->slug) }}" target="_blank" class="inline-flex items-center gap-1 text-xs font-medium text-emerald-600 hover:text-emerald-700">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    View Public Page
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
