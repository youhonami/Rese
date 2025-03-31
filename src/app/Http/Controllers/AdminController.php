<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreRepresentativeRequest;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function createRepresentative()
    {
        return view('admin.create_representative');
    }

    public function store(StoreRepresentativeRequest $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'representative',
        ]);

        return redirect()->route('admin.representatives.create')->with('success', '店舗代表者アカウントを作成しました。');
    }
}
