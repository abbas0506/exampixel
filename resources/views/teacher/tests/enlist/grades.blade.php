@extends('layouts.teacher')
@section('page-content')

<div class="custom-container">
    <h1>New Test</h1>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <div>New Test</div>
    </div>
    <div class="content-section">
        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif


        <h2>Please select a grade</h2>
        <label for="">If your desired grade is missing, contant admin!</label>
        <div class="divider my-3"></div>
        <div class="md:w-1/2 mx-auto">
            <div class="flex flex-col justify-center items-center py-2 md:py-8">
                <div class="grid grid-cols-2 md:grid-cols-2 gap-2 w-full">
                    @foreach($grades as $grade)
                    <a href="{{route('teacher.tests.annex.grade', $grade)}}" class="flex bg-teal-100 hover:bg-teal-300 h-12 justify-center items-center">{{$grade->roman_name}}</a>
                    @endforeach
                </div>
            </div>

        </div>


    </div>
</div>

@endsection