<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    //
    public function verify($id, $hash)
    {
        // $request->fulfill();
        $user = User::find($id);

        if (!$user) {
            return response('User not found.', 404);
        }

        // Verify the hash matches the user's email
        $expectedHash = sha1($user->getEmailForVerification());
        if (!hash_equals($expectedHash, $hash)) {
            return response('Invalid verification link.', 403);
        }

        // Mark the email as verified
        if ($user->hasVerifiedEmail()) {
            return response('Email already verified.', 200);
        }

        $user->markEmailAsVerified();
        // Optionally fire the Verified event
        event(new \Illuminate\Auth\Events\Verified($user));

        session([
            'role' => $user->roles->first()->name,
        ]);
        $user->login();
        return redirect('/'); // Redirect after verification
    }
}
