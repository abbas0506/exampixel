<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    //
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return redirect('/'); // Redirect after verification
    }
}
