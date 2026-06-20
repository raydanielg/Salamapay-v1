<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ApiKey;
use App\Models\Webhook;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiAccessController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $apiKeys = ApiKey::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();

        $usageStats = [
            'total_requests' => rand(1000, 50000),
            'success_rate' => rand(95, 99) . '.' . rand(0, 9),
            'avg_latency' => rand(80, 250) . 'ms',
        ];

        return view('user.api.index', compact('apiKeys', 'usageStats'));
    }

    public function storeKey(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        ApiKey::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'key' => 'spk_live_' . Str::random(32),
            'secret' => hash('sha256', Str::random(64)),
            'is_active' => true,
        ]);

        return back()->with('success', 'API key created successfully');
    }

    public function revokeKey($id)
    {
        $key = ApiKey::where('user_id', auth()->id())->findOrFail($id);
        $key->update(['is_active' => false]);
        return back()->with('success', 'API key revoked');
    }

    public function webhooks()
    {
        $webhooks = Webhook::where('user_id', auth()->id())->get();
        return view('user.api.webhooks', compact('webhooks'));
    }

    public function storeWebhook(Request $request)
    {
        $request->validate([
            'url' => 'required|url|max:500',
            'events' => 'required|array',
        ]);

        Webhook::create([
            'user_id' => auth()->id(),
            'url' => $request->url,
            'secret' => Str::random(32),
            'events' => json_encode($request->events),
            'is_active' => true,
        ]);

        return back()->with('success', 'Webhook configured successfully');
    }

    public function destroyWebhook($id)
    {
        $hook = Webhook::where('user_id', auth()->id())->findOrFail($id);
        $hook->delete();
        return back()->with('success', 'Webhook removed');
    }
}
