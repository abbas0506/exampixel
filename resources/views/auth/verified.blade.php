@extends('layouts.basic')
@section('title', 'Verified')
@section('body')
<div class="grid h-screen place-items-center bg-white p-5">
    <div class="grid gap-4 w-full md:w-1/2 mx-auto text-center">
        <div><i class="bi-person-check text-6xl md:text-8xl text-teal-600"></i></div>
        <h2 class="">Thanks for verifying your email!</h2>
        <h1 class="text-2xl text-teal-600 mt-3">Verified</h1>
        <p class="text-slate-600">Now enjoy quick paper generation. Default password is "000", you may change it at any time by using "Reset Password" option</p>
    </div>
    <a href="{{ url('/') }}" class="btn-teal rounded">Go to Your Dashboard <i class="bi-arrow-right ml-3"></i></a>
</div>
@endsection