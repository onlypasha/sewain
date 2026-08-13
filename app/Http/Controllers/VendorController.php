<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index(){
        // get senmua data vendor
        $vendors = User::where('role', 'vendor')->get();
        return view('vendor.index', compact('vendors'));
    }
}
