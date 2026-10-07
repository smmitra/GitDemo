<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminLogin;

class AdminLoginController extends Controller
{
    //

    public function index(){

        return view('adminlogin.adminlogin');
    }


     public function login(Request $request)
    {
        $request->validate([
            'al_user_name' => 'required|email',
            'al_password'  => 'required|string',
        ]);

        // dd($request->all());

        $admin = AdminLogin::where('al_user_name', $request->al_user_name)->first();

        if ($admin && Hash::check($request->al_password, $admin->al_password)) {
            // ✅ Store admin info in session
            $request->session()->put('admin_id', $admin->al_id);
            $request->session()->put('admin_name', $admin->al_name);

            return redirect()->route('dashboard');
        }

        return back()->withErrors(['al_user_name' => 'Invalid email or password']);
    }


    public function logout(Request $request)
    {
        $request->session()->forget(['admin_id', 'admin_name']);
        $request->session()->flush();

        return redirect()->route('login');
    }

}
