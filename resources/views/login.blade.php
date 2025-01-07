@extends('layouts.basic')
@section('title', 'Login')
@section('body')
<div class="flex h-screen items-center justify-center bg-white p-5">

    <div class="grid place-items-center w-full md:w-1/3 lg:1/4 mx-auto">
        <div><img src="{{ url('images/logo/app-logo.png') }}" alt="signup" class="w-20"></div>

        <!-- <h2 class="text-4xl font-bold mt-8">WELCOME</h2> -->
        <label for="" class="text-sm mt-4">https://www.exampixel.com</label>

        <div class="flex items-center w-full px-5 py-3 bg-teal-50 border border-teal-100 rounded mt-6">
            <p class="text-sm ">
                <!-- <i class="bi-shield-check"></i> -->
                Only verified accounts can login. For any help click on whatsapp button
            </p>

            <a href="{{ url('https://wa.me/+923000373004') }}" class="flex justify-center items-center text-teal-600 text-3xl ml-3">
                <i class="bi-whatsapp"></i>
            </a>.
        </div>
        <form action="{{ url('login') }}" method="post" class="w-full mt-4 text-center">
            @csrf

            <!-- page message -->
            @if ($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            <div class="flex flex-col w-full items-start">
                <div class="flex items-center w-full relative">
                    <i class="bi bi-at absolute left-2 text-slate-600"></i>
                    <input type="text" id="email" name="email" class="w-full custom-input px-8"
                        placeholder="Email address">
                </div>
                <div class="flex items-center w-full mt-3 relative">
                    <i class="bi bi-key absolute left-2 text-slate-600 -rotate-[45deg]"></i>
                    <input type="password" id="password" name="password" class="w-full custom-input px-8"
                        placeholder="Password">
                    <!-- eye -->
                    <i class="bi bi-eye-slash absolute right-2 eye-slash"></i>
                    <i class="bi bi-eye absolute right-2 eye hidden"></i>
                </div>
                <label>Default password for new verified users: 000</label>

                <button type="submit" class="w-full mt-6 btn-teal p-2">Login</button>
            </div>
        </form>

        <div class="text-center mt-6 text-slate-600 text-sm">
            <a href="{{ url('forgot') }}" class="text-xs link">Reset Password?</a>
        </div>
        <!-- </div> -->
        <div class="text-center text-xs">
            Dont have an account?<a href="{{ route('signup.create') }}" class="font-bold ml-2 link">Signup</a>
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