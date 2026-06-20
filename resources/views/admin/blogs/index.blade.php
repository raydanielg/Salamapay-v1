@extends('layouts.admin')

@section('title', 'Blog Management - SalamaPay Admin')
@section('page_title', 'Blog Posts')

@section('content')
@include('admin.partials.alert')

@include('admin.partials.page-header', [
    'title' => 'Blog Posts',
    'subtitle' => 'Manage all blog content',
    'action' => true,
    'actionUrl' => route('admin.blogs.create'),
    'actionLabel' => 'New Post'
])

<div class="bg-white rounded-xl border overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-gray-500 bg-gray-50/50">
                    <th class="px-5 py-3 font-medium">Title</th>
                    <th class="px-5 py-3 font-medium">Category</th>
                    <th class="px-5 py-3 font-medium">Author</th>
                    <th class="px-5 py-3 font-medium">Published</th>
                    <th class="px-5 py-3 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($blogs as $blog)
                <tr class="border-t border-gray-100 hover:bg-gray-50/50 transition-colors">
                    <td class="px-5 py-3">
                        <div class="font-medium text-gray-900">{{ Str::limit($blog->title, 50) }}</div>
                        <div class="text-xs text-gray-500">{{ $blog->slug }}</div>
                    </td>
                    <td class="px-5 py-3">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">{{ $blog->category }}</span>
                    </td>
                    <td class="px-5 py-3 text-gray-600">{{ $blog->author }}</td>
                    <td class="px-5 py-3 text-gray-500 text-xs">{{ $blog->published_at?->format('M d, Y') ?? 'Draft' }}</td>
                    <td class="px-5 py-3 text-right flex items-center gap-2 justify-end">
                        <a href="{{ route('blog-detail', $blog->slug) }}" target="_blank" class="text-xs font-medium text-gray-500 hover:text-gray-700">View</a>
                        <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="text-xs font-medium text-emerald-600 hover:text-emerald-700">Edit</a>
                        <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this post?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs font-medium text-red-600 hover:text-red-700">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-10 text-center text-gray-400">
                        <p class="text-sm font-medium">No blog posts yet</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($blogs->hasPages())
    <div class="px-5 py-3 border-t">{{ $blogs->links() }}</div>
    @endif
</div>
@endsection
