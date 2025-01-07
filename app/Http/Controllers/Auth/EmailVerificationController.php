<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailVerificationController extends Controller
{
    //
    public function verify($id, $hash)
    {
        // $request->fulfill();
        $user = User::find($id);

        if (!$user) {
            return redirect('not-verified');
        }

        // Verify the hash matches the user's email
        $expectedHash = sha1($user->getEmailForVerification());
        if (!hash_equals($expectedHash, $hash)) {
            return redirect('not-verified');
        }

        // Mark the email as verified
        if ($user->hasVerifiedEmail()) {
            return redirect('already-verified');
        }

        $user->markEmailAsVerified();
        // Optionally fire the Verified event
        event(new \Illuminate\Auth\Events\Verified($user));

        Auth::login($user);
        session(['role' => $user->roles->first()->name,]);

        return redirect('verified'); // Redirect after verification
    }
}
