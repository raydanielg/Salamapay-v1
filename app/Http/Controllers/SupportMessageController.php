<?php

namespace App\Http\Controllers;

use App\Models\SupportMessage;
use Illuminate\Http\Request;

class SupportMessageController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'message' => 'required|string|max:2000',
        ]);

        $message = SupportMessage::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'] ?? (auth()->user()?->first_name . ' ' . auth()->user()?->last_name),
            'email' => $validated['email'] ?? auth()->user()?->email,
            'phone' => $validated['phone'] ?? null,
            'message' => $validated['message'],
            'ip_address' => $request->ip(),
            'source' => auth()->check() ? 'dashboard' : 'website',
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully.',
                'data' => [
                    'id' => $message->id,
                    'message' => $message->message,
                    'created_at' => $message->created_at->format('M d, H:i'),
                    'status' => $message->status,
                ]
            ]);
        }

        return back()->with('success', 'Message sent successfully.');
    }

    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $messages = SupportMessage::with('user')
                ->orderBy('created_at', 'desc')
                ->paginate(20);
            $unreadCount = SupportMessage::where('status', 'open')->count();
        } else {
            $messages = SupportMessage::where('user_id', $user->id)
                ->orWhere(function ($q) use ($user) {
                    $q->whereNull('user_id')
                      ->where('email', $user->email);
                })
                ->orderBy('created_at', 'desc')
                ->paginate(20);
            $unreadCount = SupportMessage::where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhere(function ($q2) use ($user) {
                      $q2->whereNull('user_id')
                         ->where('email', $user->email);
                  });
            })->where('status', 'open')->count();
        }

        return view('user.support.index', compact('messages', 'unreadCount'));
    }

    public function reply(Request $request, SupportMessage $supportMessage)
    {
        $validated = $request->validate([
            'reply' => 'required|string|max:2000',
        ]);

        $supportMessage->update([
            'reply' => $validated['reply'],
            'replied_by' => auth()->id(),
            'replied_at' => now(),
            'status' => 'replied',
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Reply sent successfully.',
                'reply' => $validated['reply'],
                'replied_at' => now()->format('M d, H:i'),
            ]);
        }

        return back()->with('success', 'Reply sent successfully.');
    }

    public function close(SupportMessage $supportMessage)
    {
        $supportMessage->update(['status' => 'closed']);
        return back()->with('success', 'Conversation closed.');
    }

    public function history(Request $request)
    {
        $query = SupportMessage::query();

        if (auth()->check()) {
            $query->where(function ($q) {
                $q->where('user_id', auth()->id())
                  ->orWhere(function ($q2) {
                      $q2->whereNull('user_id')
                         ->where('email', auth()->user()->email);
                  });
            });
        } else {
            $query->where('ip_address', $request->ip())->whereNull('user_id');
        }

        $messages = $query->orderBy('created_at', 'asc')->get(['id', 'message', 'reply', 'status', 'created_at', 'replied_at']);

        return response()->json([
            'success' => true,
            'messages' => $messages->map(fn($m) => [
                'id' => $m->id,
                'message' => $m->message,
                'reply' => $m->reply,
                'status' => $m->status,
                'created_at' => $m->created_at->format('M d, H:i'),
                'replied_at' => $m->replied_at?->format('M d, H:i'),
                'is_me' => true,
            ])
        ]);
    }
}
