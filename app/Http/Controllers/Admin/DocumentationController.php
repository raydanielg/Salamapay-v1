<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentationPage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DocumentationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = DocumentationPage::orderBy('sort_order')->orderBy('title');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('slug', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $pages = $query->paginate(20);
        $categories = DocumentationPage::distinct()->pluck('category');

        $stats = [
            'total' => DocumentationPage::count(),
            'published' => DocumentationPage::where('is_published', true)->count(),
            'draft' => DocumentationPage::where('is_published', false)->count(),
        ];

        return view('admin.documentation.index', compact('pages', 'categories', 'stats'));
    }

    public function create()
    {
        return view('admin.documentation.form', ['page' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:documentation_pages,slug',
            'content' => 'required|string',
            'category' => 'required|string|max:100',
            'sort_order' => 'required|integer|min:0',
            'is_published' => 'boolean',
        ]);

        DocumentationPage::create([
            'title' => $request->title,
            'slug' => $request->slug ?: Str::slug($request->title),
            'content' => $request->content,
            'category' => $request->category,
            'sort_order' => $request->sort_order ?? 0,
            'is_published' => $request->boolean('is_published', false),
        ]);

        return redirect()->route('admin.documentation')->with('success', 'Documentation page created');
    }

    public function edit($id)
    {
        $page = DocumentationPage::findOrFail($id);
        return view('admin.documentation.form', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $page = DocumentationPage::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:documentation_pages,slug,' . $page->id,
            'content' => 'required|string',
            'category' => 'required|string|max:100',
            'sort_order' => 'required|integer|min:0',
            'is_published' => 'boolean',
        ]);

        $page->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content,
            'category' => $request->category,
            'sort_order' => $request->sort_order ?? 0,
            'is_published' => $request->boolean('is_published', false),
        ]);

        return redirect()->route('admin.documentation')->with('success', 'Documentation page updated');
    }

    public function destroy($id)
    {
        DocumentationPage::findOrFail($id)->delete();
        return back()->with('success', 'Documentation page deleted');
    }
}
