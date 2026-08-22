<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $vendors = User::where('role', 'vendor')->get();

        return view('superadmin.dashboard', compact('vendors'));
    }
}
