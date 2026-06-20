<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $settings = SystemSetting::orderBy('group')->orderBy('key')->get()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        foreach ($request->except('_token') as $key => $value) {
            if (str_starts_with($key, 'setting_')) {
                $realKey = substr($key, 8);
                $setting = SystemSetting::where('key', $realKey)->first();
                if ($setting) {
                    SystemSetting::set($realKey, $value, $setting->group, $setting->type);
                }
            }
        }

        return back()->with('success', 'Settings updated successfully');
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|max:255|unique:system_settings,key',
            'value' => 'nullable',
            'group' => 'required|string|max:50',
            'type' => 'required|in:string,number,boolean,json',
        ]);

        SystemSetting::set($request->key, $request->value, $request->group, $request->type);
        return back()->with('success', 'Setting created');
    }
}
