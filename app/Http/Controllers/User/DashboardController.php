<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $profileStatus = 50;
        $user = Auth::user();
        if ($user->profile) {
            if ($user->profile->subject_id) $profileStatus += 20;
            if ($user->profile->institution) $profileStatus += 10;
            if ($user->profile->logo) $profileStatus += 10;
            if ($user->profile->phone) $profileStatus += 10;
        }

        $data = [
            'values' => [$profileStatus, 100 - $profileStatus]
        ];
        return view('user.dashboard', compact('data', 'profileStatus'));
    }
}
