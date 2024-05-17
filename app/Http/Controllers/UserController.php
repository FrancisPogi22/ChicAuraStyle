<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = new User;
    }


    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validation->fails()) return back()->withInput()->with('warning', implode('<br>', $validation->errors()->all()));

        if (auth()->attempt($request->only('email', 'password'))) return $this->checkUserAccount();

        return back()->withInput()->with('warning', 'Incorrect User Credentials.');
    }

    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'address' => 'required',
            'Cpassword' => 'required|same:password'
        ]);

        if ($validation->fails()) return back()->withInput()->with('warning', implode('<br>', $validation->errors()->all()));

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Successfully registered.');
    }

    public function logout()
    {
        auth()->logout();
        session()->flush();
        return redirect('/')->with('success', 'Successfully Logged out.');
    }

    private function checkUserAccount()
    {
        if (!auth()->check()) return back();

        $userAuthenticated = auth()->user();

        if (auth()->user()->type == 1) {
            return redirect("/admin/homepage")->with('success', "Welcome $userAuthenticated->username.");
        } else {
            return redirect("/homepage")->with('success', "Welcome $userAuthenticated->username.");
        }
    }
}
