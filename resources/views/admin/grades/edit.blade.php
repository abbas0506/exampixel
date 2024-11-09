@extends('layouts.basic')
@section('header')
<x-headers.user page="Q.Bank" icon="<i class='bi bi-database-gear'></i>"></x-headers.user>
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
            <div>Edit</div>
        </div>

        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <div class="container-light">
            <div class="flex items-center">
                <h3 class="text-green-600 bg-green-100 px-3 py-1 rounded-full">Edit Grade <i class="bi-mortarboard"></i></h3>
            </div>
            <div class="flex justify-center items-center mt-12">
                <!-- page message -->
                <form action="{{route('admin.grades.update',$grade)}}" method='post' class="md:w-2/3" onsubmit="return validate(event)">
                    @csrf
                    @method('PATCH')
                    <div class="md:w-1/3">
                        <label>Grade No.</label>
                        <input type="text" name='grade_no' class="custom-input-borderless" placeholder="Enter grade name" min=9 value="{{ $grade->grade_no }}" required>
                    </div>
                    <div class="mt-6">
                        <label>Grade Name</label>
                        <input type="text" name='name' class="custom-input-borderless" placeholder="Enter grade name" value="{{$grade->name}}" required>
                    </div>

                    <button type="submit" class="btn-green rounded mt-6">Update</button>
                </form>

            </div>

        </div>
    </div>
</div>
@endsection