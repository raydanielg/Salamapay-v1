<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Service::forUser(auth()->id());

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        $services = $query->latest()->paginate(15)->withQueryString();
        $categories = Service::forUser(auth()->id())->select('category')->distinct()->pluck('category')->filter();

        $stats = [
            'total' => Service::forUser(auth()->id())->count(),
            'active' => Service::forUser(auth()->id())->active()->count(),
            'paused' => Service::forUser(auth()->id())->where('status', 'paused')->count(),
            'totalBookings' => Service::forUser(auth()->id())->sum('bookings'),
        ];

        return view('user.services.index', compact('services', 'stats', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'nullable|string|max:100',
            'category' => 'nullable|string|max:100',
            'status' => 'required|in:active,paused,archived',
        ]);

        $validated['user_id'] = auth()->id();
        Service::create($validated);

        return redirect()->route('user.services')->with('success', 'Service created successfully.');
    }

    public function update(Request $request, Service $service)
    {
        if ($service->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'nullable|string|max:100',
            'category' => 'nullable|string|max:100',
            'status' => 'required|in:active,paused,archived',
        ]);

        $service->update($validated);

        return redirect()->route('user.services')->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $this->authorize('delete', $service);
        $service->delete();
        return redirect()->route('user.services')->with('success', 'Service deleted successfully.');
    }
}
