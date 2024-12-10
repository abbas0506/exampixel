@extends('layouts.basic')
@section('body')

<div class="flex h-screen items-center justify-center bg-white p-5">
    <div class="grid place-items-center w-full md:w-1/3 lg:1/4 mx-auto">
        <div><img src="{{ url('images/small/key.png') }}" alt="signup" class="w-48"></div>
        <!-- <img class="w-36 md:w-40 mx-auto" alt="logo" src="{{asset('images/logo/exampixel-0.png')}}"> -->
        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif
        <form action="{{route('passwords.update', Auth::user()->id)}}" method="post" class="grid gap-4 mt-4 w-full mx-auto" onsubmit="return validate(event)">
            @csrf
            @method('PATCH')

            <input type="text" id="current" name="current" class="custom-input-borderless py-1" placeholder="Current password" required>
            <input type="password" id="new" name="new" class="custom-input-borderless py-1" placeholder="New password" required>
            <input type="password" id="confirmpw" class="custom-input-borderless py-1" placeholder="Confirm password" required>

            <div class="flex flex-wrap justify-center gap-4 mt-4">
                <a href="{{url(session('role'))}}" class="btn-blue text-center rounded-sm py-1">Cancel</a>
                <button type="submit" class="btn-red rounded-sm py-1">Change Password</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('script')
<script lang="javascript">
    function validate(event) {
        var validated = true;
        if ($('#new').val() != $('#confirmpw').val()) {
            validated = false;
            event.preventDefault();
            Toast.fire({
                icon: 'warning',
                title: 'Confirm password not matched',
            })

        }

        return validated;
    }
</script>
@endsection