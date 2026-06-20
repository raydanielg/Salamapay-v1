<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PaymentProfile;
use App\Models\Template;
use Illuminate\Http\Request;

class TemplateBuilderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $templates = Template::active()->get();
        $profiles = PaymentProfile::where('user_id', auth()->id())
            ->with('template')
            ->orderBy('name')
            ->get();

        return view('user.templates.index', compact('templates', 'profiles'));
    }

    public function customize($profileId)
    {
        $profile = PaymentProfile::where('user_id', auth()->id())->findOrFail($profileId);
        $templates = Template::active()->get();

        return view('user.templates.customize', compact('profile', 'templates'));
    }

    public function update(Request $request, $profileId)
    {
        $profile = PaymentProfile::where('user_id', auth()->id())->findOrFail($profileId);

        $request->validate([
            'template_id' => 'nullable|exists:templates,id',
            'template_settings' => 'nullable|array',
            'logo' => 'nullable|image|max:5120',
            'color' => 'nullable|string|max:7',
            'business_name' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $data = [
            'template_id' => $request->template_id,
            'template_settings' => $request->template_settings,
            'color' => $request->color ?? $profile->color,
            'business_name' => $request->business_name ?? $profile->business_name,
            'description' => $request->description ?? $profile->description,
        ];

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('profile-logos', 'public');
        }

        $profile->update($data);

        return back()->with('success', 'Template settings saved');
    }

    public function preview($profileId)
    {
        $profile = PaymentProfile::where('user_id', auth()->id())->with('template')->findOrFail($profileId);

        // Create a mock payment link for preview
        $link = new \App\Models\PaymentLink([
            'slug' => 'preview',
            'title' => 'Preview Payment',
            'description' => $profile->description ?? 'Sample payment page',
            'amount' => 50000,
            'currency' => 'TZS',
            'is_active' => true,
            'profile_id' => $profile->id,
            'user_id' => auth()->id(),
        ]);
        $link->setRelation('profile', $profile);

        $templateSlug = $profile->template?->slug ?? 'default';

        if (view()->exists("payment.templates.{$templateSlug}")) {
            return view("payment.templates.{$templateSlug}", ['link' => $link]);
        }

        return view('payment.templates.neo', ['link' => $link]);
    }
}
