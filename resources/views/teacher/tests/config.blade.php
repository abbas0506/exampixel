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

        <form action="{{route('teacher.tests.store')}}" method='post' onsubmit="return validate(event)">
            @csrf
            <h2>Please select a grade</h2>
            <label for="">If your desired grade is missing, contant admin!</label>
            <div class="divider my-3"></div>
            <div class="md:w-3/4 mx-auto">
                <div class="flex flex-col justify-center items-center py-2 md:py-8">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 w-full">
                        @foreach($grades as $grade)
                        @if($annexedGrade && $annexedGrade->id==$grade->id)
                        <a href="{{route('teacher.tests.annex.grade', $grade)}}" class="flex bg-teal-300 h-12 justify-center items-center">{{$grade->roman_name}}</a>
                        @else
                        <a href="{{route('teacher.tests.annex.grade', $grade)}}" class="flex bg-teal-100 h-12 justify-center items-center">{{$grade->roman_name}}</a>
                        @endif
                        @endforeach
                    </div>
                </div>
                <div class="divider my-3"></div>
                @if($annexedGrade)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm">
                    @foreach($annexedGrade->subjects as $subject)
                    @if($annexedSubject && $annexedSubject->id==$subject->id)
                    <a href="{{route('teacher.tests.annex.subject', $subject)}}" class="flex bg-sky-300 h-10 justify-center items-center">{{$subject->name}}</a>
                    @else
                    <a href="{{route('teacher.tests.annex.subject', $subject)}}" class="flex bg-sky-100 h-10 justify-center items-center">{{$subject->name}}</a>
                    @endif
                    @endforeach
                </div>
                @endif
                <div class="divider my-3"></div>
                @if($annexedSubject)
                <div class="flex flex-col gap-2">
                    @foreach($annexedSubject->chapters->sortBy('chapter_no') as $chapter)
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" name='chapter_no_array[]' class="custom-input w-4 h-4" value="{{ $chapter->id }}">
                        <label>{{$chapter->chapter_no}}. {{$chapter->name}}</label>
                    </div>
                    @endforeach
                </div>
                <div class="divider my-3"></div>

                <div class="flex flex-col gap-x-4 gap-y-2">
                    <label for="">Test Title</label>
                    <input type="text" name="title" value='Sample Test' placeholder="Test Title" class="custom-input">
                    <div class="md:w-2/3">
                        <label for="">Test Date</label>
                        <input type="date" id='test_date' name="test_date" class="custom-input" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" name="exercise_only" class="custom-input w-6 h-6">
                        <label>Questions form exercise only</label>
                    </div>
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" name="frequent_only" class="custom-input w-6 h-6">
                        <label>Most frequent questions only</label>
                    </div>
                </div>
                <div class="divider my-3"></div>
                <input type="hidden" name="subject_id" value="{{ $annexedSubject->id }}">
                <div class="float-right">
                    <button type="submit" class="btn-teal rounded py-2 px-4" @disabled($annexedSubject->chapters->count()==0)>Next <i class="bi-arrow-right"></i></button>
                </div>
                @endif
            </div>
        </form>

    </div>
</div>

@endsection