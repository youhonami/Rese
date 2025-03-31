<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;

class RepresentativeController extends Controller
{
    public function dashboard()
    {
        return view('representative.dashboard');
    }
}
