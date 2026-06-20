<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ToolsSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        $settings = [
            'pos_enabled' => true,
            'invoice_auto_send' => false,
            'sales_tax_rate' => 18,
            'currency' => 'TZS',
            'receipt_footer' => 'Thank you for your business!',
        ];

        return view('user.tools.settings', compact('user', 'settings'));
    }
}
