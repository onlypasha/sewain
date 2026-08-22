<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;

class SubscriptionController extends Controller
{
    public function index()
    {
        return view('superadmin.subscription');
    }
}
