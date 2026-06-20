@extends('layouts.admin')

@section('title', 'New Blog Post - SalamaPay Admin')
@section('page_title', 'New Blog Post')

@section('content')
@include('admin.partials.alert')

<div class="mb-4">
    <a href="{{ route('admin.blogs') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Back to Posts</a>
</div>

<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl border p-6">
        <h3 class="text-sm font-semibold text-gray-900 mb-5">Create New Post</h3>
        <form action="{{ route('admin.blogs.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Title *</label>
                    <input type="text" name="title" required class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Slug</label>
                    <input type="text" name="slug" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" placeholder="auto-generated if empty">
                </div>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Excerpt *</label>
                <textarea name="excerpt" rows="2" required class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none resize-none"></textarea>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Content * (Markdown supported)</label>
                <textarea name="content" rows="12" required class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none font-mono leading-relaxed">## Introduction

Write your article here using Markdown formatting.

## Key Points

- Point 1
- Point 2
- Point 3

## Conclusion

Wrap up your thoughts here.</textarea>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Category *</label>
                    <input type="text" name="category" required class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" placeholder="e.g. Payments">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Author *</label>
                    <input type="text" name="author" required class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" placeholder="Author name">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Read Time *</label>
                    <input type="text" name="read_time" required class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" placeholder="e.g. 5 min read">
                </div>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Image Path (optional)</label>
                <input type="text" name="image" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none" placeholder="e.g. images/post.png">
            </div>
            <div class="pt-2">
                <button type="submit" class="px-5 py-2 text-sm font-semibold bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">Publish Post</button>
            </div>
        </form>
    </div>
</div>
@endsection
