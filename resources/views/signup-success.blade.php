@extends('layouts.basic')
@section('body')
<div class="grid h-screen place-items-center bg-white p-5">
    <div class="w-full md:w-1/2 mx-auto text-center">
        <h1 class="text-green-800 text-2xl">Account has been successfully created</h1>
        <p>Check your email. Password has been sent to your email</p>
        <div class="mt-6">
            <a href="{{ url('login') }}" class="btn-teal">Login Now</a>
        </div>
    </div>
</div>
@endsection