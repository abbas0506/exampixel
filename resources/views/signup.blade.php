@extends('layouts.basic')
@section('body')

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
            <form action="{{url('signup')}}" method="post" class="w-full mt-8">
                @csrf
                <div class="flex flex-col w-full items-start">
                    <div class="flex items-center w-full relative">
                        <i class="bi bi-person absolute left-2 text-slate-600"></i>
                        <input type="text" id="name" name="name" class="w-full custom-input px-8" placeholder="Your name">
                    </div>
                    <div class="flex items-center w-full relative">
                        <i class="bi bi-envelope-at absolute left-2 text-slate-600"></i>
                        <input type="text" id="email" name="email" class="w-full custom-input px-8" placeholder="Your email">
                    </div>

                    <button type="submit" class="w-full mt-6 btn-teal p-2">Sign Up</button>
                </div>
            </form>
        </div>
        <div class="text-center text-sm mt-3">
            I have an account?<a href="{{ url('login') }}" class="font-bold ml-2">Login</a>
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