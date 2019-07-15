<?php

namespace App\Http\Controllers\Cp;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Validation\ValidationException;

class IndexController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('cp');
    }

    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return view('cp.index');
    }

    public function showChgpwdForm()
    {
        return view('cp.auth.chgpwd');
    }

    public function chgpwd(Request $request)
    {
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            throw ValidationException::withMessages([
            'current-password' => ['Your current password does not match with the password you provided. Please try again.'],
            ]);
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            throw ValidationException::withMessages([
            'new-password_confirmation' => ['New Password cannot be same as your current password. Please choose a different password.'],
            ]);
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        Auth::logout();

        return ezReturnSuccessMessage('Password changed! Please login again');
        // return redirect('login')->with('status', 'Password changed! Please login again');
    }

}
