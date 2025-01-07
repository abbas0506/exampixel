@extends('layouts.basic')
@section('title', 'Verified')
@section('body')
<div class="flex flex-col items-center justify-center h-screen bg-white p-5">
    <div class="grid gap-4 w-full md:w-1/2 mx-auto text-center">
        <div><i class="bi-emoji-neutral text-6xl text-slate-600"></i></div>
        <h2 class="">Sorry, access not allowed!</h2>
        <h1 class="text-2xl text-red-600 mt-3">Account Verification Required</h1>
        <p class="text-slate-600">Please check your inbox or spam folder and verify your email address</p>
    </div>

    <a href="{{ url('signout') }}" class="flex justify-center items-center w-12 h-12 rounded-full bg-teal-100 mt-16"><i class="bi-x-lg"></i></a>
    <label for="">Close</label>
</div>
@endsection