@extends('layouts.basic')

@section('body')
<div class="flex flex-col w-screen h-screen justify-center items-center px-5">
    <div class="md:w-1/3 md:px-8 py-3 bg-white relative">
        <div class="flex justify-center items-center">
            <img src="{{ url('images/small/lock.png') }}" alt="lock" class="w-36 h-36">
        </div>
        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <form action="{{url('forgot')}}" method="post" class="flex flex-col mt-8">
            @csrf
            <label for="" class="mt-3">Email Address</label>
            <input type="text" name="email" class="custom-input" placeholder="Enter your email address" required>
            <div class="text-xs mt-1">Password will be sent to only registered email account.</div>
            <div class="flex space-x-4">
                <button type="submit" class="w-full mt-6 btn-teal p-2">Send Now</button>
            </div>
        </form>

        <div class="flex flex-col items-center justify-center">
            <a href="{{ url('/') }}" class="flex justify-center items-center w-12 h-12 rounded-full bg-teal-100 mt-16"><i class="bi-x-lg"></i></a>
            <label for="">Close</label>
        </div>
    </div>

</div>
@endsection