<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = User::where('role', 'user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20);

        $stats = [
            'total' => User::where('role', 'user')->count(),
            'active' => User::where('role', 'user')->where('status', 'active')->count(),
            'pending' => User::where('role', 'user')->where('status', 'pending')->count(),
            'suspended' => User::where('role', 'user')->where('status', 'suspended')->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    public function show($id)
    {
        $user = User::where('role', 'user')->findOrFail($id);
        $transactions = $user->transactions()->orderBy('processed_at', 'desc')->take(10)->get();
        $settlements = $user->settlements()->orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.users.show', compact('user', 'transactions', 'settlements'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:active,pending,suspended']);
        $user = User::where('role', 'user')->findOrFail($id);
        $user->update(['status' => $request->status]);
        return back()->with('success', 'User status updated');
    }
}
