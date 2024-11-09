<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',

        ]);

        // 
        if (Auth::attempt($credentials)) {
            //user verified, now redirect to his/her dashboard
            $role = Auth::user()->roles->first()->name;
            session([
                'role' => $role,
            ]);

            // go to related dashboard
            return redirect($role);
        } else {
            //user not verified
            return redirect()->back()->with(['warning' => 'User credentials incorrect !']);
        }
    }
    // login step2
    public function loginAs(Request $request)
    {
        $request->validate([
            'role' => 'required',
        ]);


        if (Auth::user()->hasRole($request->role)) {

            session([
                'role' => $request->role,
            ]);
            // go to related page
            return redirect($request->role);
        } else
            return redirect('/');
    }


    public function verify_step2(Request $request)
    {
        //get 2nd factor secret code sent to gmail
        //if matched, redirect to user dashboard

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function signout()
    {
        //destroy session
        session()->flush();
        Auth::logout();
        return redirect('/');
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();
        //change password process
        $request->validate([
            'current' => 'required',
            'new' => 'required',
        ]);

        try {

            if (Hash::check($request->current, $user->password)) {
                $user->password = Hash::make($request->new);
                $user->save();
                return redirect()->back()->with('success', 'successfuly changed');
            } else {
                //password not found
                return redirect()->back()->with('warning', 'Oops, something wrong!');;
            }
        } catch (Exception $e) {
            return redirect()->back()
                ->withErrors($e->getMessage());
            // something went wrong
        }
    }
    public function  forgot(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $email = $request->email;
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $code = Str::random(5);

            $user->update([
                'password' => Hash::make($code),
            ]);

            try {

                Mail::raw('Password has been reset by exampixel.com : ' . $code, function ($message) use ($email) {
                    $message->to($email);
                    $message->subject('Password reset');
                });

                return redirect('login')->with('success', 'Password sent to your email');
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        } else {
            return redirect()->back()->with('warning', 'The email does not exist in record');
        }
    }
}
