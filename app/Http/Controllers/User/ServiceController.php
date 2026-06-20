<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $services = [
            ['name' => 'Web Development', 'price' => 450000, 'duration' => '2 Weeks', 'status' => 'active', 'bookings' => 18],
            ['name' => 'Graphic Design', 'price' => 150000, 'duration' => '3 Days', 'status' => 'active', 'bookings' => 42],
            ['name' => 'Digital Marketing', 'price' => 280000, 'duration' => '1 Month', 'status' => 'active', 'bookings' => 24],
            ['name' => 'IT Consulting', 'price' => 100000, 'duration' => '1 Day', 'status' => 'paused', 'bookings' => 7],
            ['name' => 'SEO Optimization', 'price' => 200000, 'duration' => '2 Weeks', 'status' => 'active', 'bookings' => 31],
        ];

        $stats = [
            'total' => 5,
            'active' => 4,
            'paused' => 1,
            'totalBookings' => 122,
        ];

        return view('user.services.index', compact('services', 'stats'));
    }
}
