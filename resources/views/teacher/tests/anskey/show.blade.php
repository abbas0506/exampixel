@extends('layouts.teacher')
@section('page-content')

<div class="custom-container">
    <h1>Answer Key</h1>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <div>Answer key</div>
    </div>

    <div class="content-section">
        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        @if($test->questions()->mcqs()->count()>0)
        <div class="flex justify-end w-full">
            <div class="flex w-12 h-12 items-center justify-center rounded-full bg-orange-100 hover:bg-orange-200">
                <a href="{{route('teacher.tests.anskey.pdf',$test)}}" target="_blank"><i class="bi-printer"></i></a>
            </div>
        </div>
        @endif

        <div class="flex justify-between mt-4">
            <div>
                <label>{{$test->title}}</label>
                <h2>{{$test->subject->grade->roman_name}} - {{$test->subject->name}}</h2>
            </div>
            <div class="flex flex-col justify-center">
                <div class="flex items-center">
                    <label>Dated: &nbsp</label>
                    <label>{{$test->test_date->format('d/m/Y')}}</label>
                </div>
            </div>
        </div>
        <div class="divider my-3"></div>
        @if($test->questions->count()>0)
        <div class="flex flex-col gap-2 mt-3">
            @foreach($test->questions()->mcqs()->get() as $testQuestion)
            <!-- MCQ case -->
            <div class="flex items-baseline space-x-1">
                <h3>Q.{{$testQuestion->question_no}}</h3>
                <h3>Answer any {{$testQuestion->necessary_parts}} questions</h3>
            </div>

            <ol class="list-[lower-roman] list-outside text-sm pl-6">
                @foreach($testQuestion->parts as $part)
                <li>
                    {{$part->question->question}}
                    <div class="grid grid-cols-1 md:grid-cols-4">
                        <div @if($part->question->answer=='a') class='font-bold' @endif>a. {{$part->question->mcq->option_a}}</div>
                        <div @if($part->question->answer=='b') class='font-bold' @endif>b. {{$part->question->mcq->option_b}}</div>
                        <div @if($part->question->answer=='c') class='font-bold' @endif>c. {{$part->question->mcq->option_c}}</div>
                        <div @if($part->question->answer=='d') class='font-bold' @endif>d. {{$part->question->mcq->option_d}}</div>
                    </div>
                </li>
                @endforeach
            </ol>
            <!--looping test questions ends -->
            @endforeach
        </div>
        @else
        <div class="h-full flex flex-col justify-center items-center">
            <h3>Currently test is empty!</h3>
            <label for="">Please select one of the following options to add question</label>
        </div>
        @endif

    </div>
</div>
@endsection