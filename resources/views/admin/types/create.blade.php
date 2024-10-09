@extends('layouts.basic')
@section('header')
<x-headers.user page="Config" icon="<i class='bi bi-gear'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.admin page='config'></x-sidebars.admin>
@endsection

@section('body')
<div class="responsive-container">
    <div class="container">
        <div class="bread-crumb">
            <a href="{{url('/')}}">Home</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('admin.subjects.index')}}">Config</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('admin.types.index')}}">Q. Types</a>
            <i class="bx bx-chevron-right"></i>
            <div>New</div>
        </div>

        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif


        <div class="p-8 md:w-3/4 mx-auto bg-white mt-12">
            <form action="{{route('admin.types.store')}}" method='post' class="">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <h2 class="md:col-span-2 text-green-600">New Type <i class="bi-box"></i></h2>
                    <div class="md:col-span-2">
                        <label for="">Type Name</label>
                        <input type="text" id='' name='name' class="custom-input-borderless" placeholder="Question Type" value="">
                    </div>

                    <div class="md:col-span-2 text-right">
                        <button type="submit" class="btn-teal rounded">Create Now</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="module">

</script>
@endsection