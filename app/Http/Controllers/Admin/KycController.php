<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class KycController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pending = User::where('verification_status', 'pending')
            ->whereNotNull('business_name')
            ->orderBy('updated_at', 'desc')
            ->paginate(15, ['*'], 'pending');

        $all = User::whereNotNull('business_name')
            ->whereIn('verification_status', ['verified', 'rejected', 'unverified'])
            ->orderBy('updated_at', 'desc')
            ->paginate(15, ['*'], 'all');

        return view('admin.kyc.index', compact('pending', 'all'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.kyc.show', compact('user'));
    }

    public function approve(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'verification_status' => 'verified',
            'verified_at' => now(),
            'verification_notes' => $request->input('notes', 'Approved by admin'),
        ]);

        // Notify user
        Notification::create([
            'user_id' => $user->id,
            'title' => 'Business Verified',
            'message' => 'Your business profile has been verified. You can now accept unlimited payments.',
            'type' => 'success',
            'category' => 'kyc',
            'action_url' => '/dashboard/business',
            'action_text' => 'View Business',
        ]);

        // Email user
        try {
            Mail::raw(
                "Dear {$user->first_name},\n\nYour business verification for {$user->business_name} has been approved.\n\nYou can now:\n- Accept unlimited payments\n- Request instant settlements\n- Access all API features\n\nThank you,\nSalamaPay Team",
                function ($message) use ($user) {
                    $message->to($user->email)
                        ->subject('Business Verified - SalamaPay');
                }
            );
        } catch (\Exception $e) {
            // Log email failure silently
        }

        return back()->with('success', 'Business verified successfully');
    }

    public function reject(Request $request, $id)
    {
        $request->validate(['reason' => 'required|string|max:500']);

        $user = User::findOrFail($id);
        $user->update([
            'verification_status' => 'rejected',
            'verification_notes' => $request->input('reason'),
        ]);

        // Notify user
        Notification::create([
            'user_id' => $user->id,
            'title' => 'Verification Rejected',
            'message' => 'Your business verification was rejected. Reason: ' . $request->input('reason'),
            'type' => 'error',
            'category' => 'kyc',
            'action_url' => '/dashboard/business',
            'action_text' => 'Review & Resubmit',
        ]);

        // Email user
        try {
            Mail::raw(
                "Dear {$user->first_name},\n\nYour business verification for {$user->business_name} was not approved.\n\nReason: {$request->input('reason')}\n\nPlease update your information and resubmit.\n\nThank you,\nSalamaPay Team",
                function ($message) use ($user) {
                    $message->to($user->email)
                        ->subject('Verification Update - SalamaPay');
                }
            );
        } catch (\Exception $e) {
        }

        return back()->with('success', 'Verification rejected with reason');
    }
}
