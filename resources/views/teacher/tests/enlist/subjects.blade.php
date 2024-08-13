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
        @if ($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif
        <h2>Please select a subject</h2>
        <label for="">If your desired grade is missing, contant admin!</label>
        <div class="divider my-3"></div>
        <div class="mx-auto">
            <h1>Grade: {{$selectedGrade->roman_name}}</h1>
            <div class="divider my-3"></div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-2 text-sm text-center">
                @foreach ($selectedGrade->subjects as $subject)
                <a href="{{ route('teacher.tests.annex.subject', $subject) }}" class="flex bg-sky-100 hover:bg-sky-300 h-10 justify-center items-center">{{ $subject->name }}</a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection