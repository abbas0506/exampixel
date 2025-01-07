@extends('layouts.basic')
@section('title', 'Verified')
@section('body')
<div class="grid h-screen place-items-center bg-white p-5">
    <div class="grid gap-4 w-full md:w-1/2 mx-auto text-center">
        <div><i class="bi-emoji-neutral text-6xl text-slate-600"></i></div>
        <h2 class="">Sorry, email could not be verified!</h2>
        <h1 class="text-2xl text-red-600 mt-3">Verification Failed</h1>
        <p class="text-slate-600">You may contact site admin for necessary help so that your issue could be resolved!</p>
    </div>
    <a href="{{ url('https://wa.me/+923000373004') }}" class="btn-teal rounded">Contact Admin <i class="bi-arrow-right ml-3"></i></a>
</div>
@endsection