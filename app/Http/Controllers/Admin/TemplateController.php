<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TemplateController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $templates = Template::withCount('paymentProfiles')->orderBy('created_at', 'desc')->get();
        return view('admin.templates.index', compact('templates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'thumbnail' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'is_premium' => 'boolean',
            'default_colors' => 'nullable|array',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'is_active' => $request->boolean('is_active', true),
            'is_premium' => $request->boolean('is_premium', false),
            'default_colors' => $request->default_colors ?? [
                'primary' => '#024938',
                'accent' => '#f9ac00',
                'background' => '#ffffff',
                'text' => '#1f2937',
            ],
            'created_by' => auth()->id(),
        ];

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('templates', 'public');
        }

        Template::create($data);

        return redirect()->route('admin.templates')->with('success', 'Template created successfully');
    }

    public function update(Request $request, $id)
    {
        $template = Template::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'thumbnail' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'is_premium' => 'boolean',
            'default_colors' => 'nullable|array',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active', $template->is_active),
            'is_premium' => $request->boolean('is_premium', $template->is_premium),
            'default_colors' => $request->default_colors ?? $template->default_colors,
        ];

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('templates', 'public');
        }

        $template->update($data);

        return back()->with('success', 'Template updated');
    }

    public function destroy($id)
    {
        $template = Template::findOrFail($id);
        $template->delete();
        return back()->with('success', 'Template deleted');
    }

    public function users($id)
    {
        $template = Template::with('paymentProfiles.user')->findOrFail($id);
        return view('admin.templates.users', compact('template'));
    }
}
