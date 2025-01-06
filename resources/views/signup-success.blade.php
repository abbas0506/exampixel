@extends('layouts.basic')
@section('title', 'Signup Success')
@section('body')
<div class="grid h-screen place-items-center bg-white p-5">
    <div class="grid gap-4 w-full md:w-1/2 mx-auto text-center">
        <div><i class="bi-emoji-smile text-6xl text-teal-600"></i></div>
        <h2 class="text-teal-600">Thanks for signing up!</h2>
        <h1 class="text-2xl">Email Verification Required</h1>
        <p class="text-lg">Please check your email to complete the registration process </p>
        <!-- <div class="mt-6">
            <a href="{{ url('login') }}" class="btn-teal px-4 py-3 text-sm rounded-lg">Login Now</a>
        </div> -->
    </div>
</div>
@endsection