@extends('layouts.basic')
@section('header')
<x-headers.user page="Q. Bank" icon="<i class='bi bi-database-gear'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.admin page='qbank'></x-sidebars.admin>
@endsection

@section('body')
<div class="responsive-container">
    <div class="container">
        <div class="bread-crumb">
            <a href="/">Home</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('admin.grades.index')}}">Grades</a>
            <i class="bx bx-chevron-right"></i>
            <div>New</div>
        </div>

        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <div class="container-light">
            <div class="flex items-center">
                <h3 class="text-green-600 bg-green-100 px-3 py-1 rounded-full">New Grade <i class="bi-mortarboard"></i></h3>
            </div>
            <div class="flex h-64 justify-center items-center w-full md:w-2/3 mx-auto">
                <!-- page message -->
                <form action="{{route('admin.grades.store')}}" method='post' class="w-full">
                    @csrf
                    <div class="md:w-1/3">
                        <label>Grade No.</label>
                        <input type="text" name='grade_no' class="custom-input-borderless" placeholder="Enter grade name" min=9 value="{{ $grades->max('grade_no')+1 }}" required>
                    </div>
                    <div class="mt-6">
                        <label>Grade Name</label>
                        <input type="text" name='name' class="custom-input-borderless" placeholder="Enter grade name" value="" required>
                    </div>


                    <button type="submit" class="btn-green rounded mt-6">Create</button>
                </form>

            </div>

        </div>
    </div>
</div>
@endsection