@extends('layouts.basic')
@section('title', 'Signup Success')
@section('body')
<div class="flex flex-col items-center justify-center h-screen bg-white p-5">
    <div class="grid gap-4 w-full md:w-1/2 mx-auto text-center">
        <div><i class="bi-emoji-smile text-6xl text-teal-600"></i></div>
        <h2 class="text-teal-600 text-xl">Thanks for signing up!</h2>
        <h1 class="text-xl md:text-2xl">Please Check Your Email</h1>
        <p class="text-slate-600">A verification link has been sent to your email. See your <span class="font-semibold text-red-600">inbox or spam folder</span> to complete the registration process </p>
    </div>
    <a href="{{ url('/') }}" class="flex justify-center items-center w-12 h-12 rounded-full bg-teal-100 mt-16"><i class="bi-x-lg"></i></a>
    <label for="">Close</label>
</div>
@endsection