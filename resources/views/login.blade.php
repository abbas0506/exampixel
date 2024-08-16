@extends('layouts.basic')
@section('body')
<style>
    .main {
        position: relative;
        overflow: hidden;
    }

    .main::before {
        background: #edf3fb;
        content: "";
        position: absolute;
        width: 30rem;
        height: 30rem;
        border-radius: 50%;
        align-items: center;
        display: flex;
        justify-content: center;
        transform: scale(120%);
        z-index: -1;
    }
</style>
<div class="grid grid-cols-1 md:grid-cols-2 md:h-screen place-items-center bg-white p-5">
    <div><img src="{{ url('images/small/signup.png') }}" alt="signup" class="md:w-full"></div>
    <div class="grid place-items-center">
        <div class="">
            <img class="w-36 md:w-40 mx-auto" alt="logo" src="{{asset('images/logo/exampixel.png')}}">
            <!-- page message -->
            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif
            <form action="{{url('login')}}" method="post" class="w-full mt-8">
                @csrf
                <div class="flex flex-col w-full items-start">
                    <div class="flex items-center w-full relative">
                        <i class="bi bi-person absolute left-2 text-slate-600"></i>
                        <input type="text" id="email" name="email" class="w-full custom-input px-8" placeholder="Login id">
                    </div>
                    <div class="flex items-center w-full mt-3 relative">
                        <i class="bi bi-key absolute left-2 text-slate-600 -rotate-[45deg]"></i>
                        <input type="password" id="password" name="password" class="w-full custom-input px-8" placeholder="Password">
                        <!-- eye -->
                        <i class="bi bi-eye-slash absolute right-2 eye-slash"></i>
                        <i class="bi bi-eye absolute right-2 eye hidden"></i>
                    </div>

                    <button type="submit" class="w-full mt-6 btn-teal p-2">Login</button>
                </div>
            </form>

            <div class="text-center mt-6 text-slate-600 text-sm">
                <a href="">Forgot Password?</a>
            </div>
        </div>
        <div class="text-center text-xs">
            Dont have an account?<a href="{{ url('signup/me') }}" class="font-bold ml-2  link">Signup</a>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="module">
    $(document).ready(function() {
        $('.bi-eye-slash').click(function() {
            $('#password').prop({
                type: "text"
            });
            $('.eye-slash').hide()
            $('.eye').show();
        })
        $('.bi-eye').click(function() {
            $('#password').prop({
                type: "password"
            });
            $('.eye-slash').show()
            $('.eye').hide();
        })

    });
</script>

@endsection