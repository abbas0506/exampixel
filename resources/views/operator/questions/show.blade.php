@extends('layouts.basic')
@section('header')
<x-headers.user page="Questions" icon="<i class='bi bi-database-gear'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.operator page='questions'></x-sidebars.operator>
@endsection

@section('body')
<div class="responsive-container">
    <div class="container">
        <div class="bread-crumb">
            <a href="{{url('/')}}">Home</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('operator.books.index')}}">Books</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('operator.books.chapters.index', $chapter->book)}}">Chapters</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('operator.chapter.questions.index', $chapter)}}">Questions</a>
            <i class="bx bx-chevron-right"></i>
            <div>View Q.</div>
        </div>

        <div class="md:w-4/5 mx-auto mt-8">
            <h2>{{ $question->chapter->book->name }}</h2>
            <label>Ch # {{ $question->chapter->sr }}. {{ $question->chapter->title }}</label>

            <div class="grid gap-6 mt-6">
                <div>
                    <label for="">Q. Type</label>
                    <h3>{{ $question->type->name}} ({{ $question->marks }})</h3>
                </div>

                <div class="grid gap-y-1 col-span-full">
                    <label for="">Question Statement</label>
                    <div class="custom-input-borderless">{{ $question->statement }}</div>
                </div>
                <!-- MCQs -->
                @if($question->type->name=='MCQs')
                <div class="text-sm">
                    <label for="">Choices</label>
                    <div class="grid gap-4 mt-2">
                        <div class="text-sm md:w-1/2">a. &nbsp{{ $question->mcq->choice_a }}</div>
                        <div class="text-sm md:w-1/2">b. &nbsp{{ $question->mcq->choice_b }}</div>
                        <div class="text-sm md:w-1/2">c. &nbsp{{ $question->mcq->choice_c }}</div>
                        <div class="text-sm md:w-1/2">d. &nbsp{{ $question->mcq->choice_d }}</div>
                    </div>
                </div>
                @elseif($question->type->name=='Long')
                <!-- Paraphrasing -->
                @if($question->subtype->tagname=='paraphrasing')
                <div class="text-sm">
                    <label for="">Parahrasing: Poetry lines</label>
                    <div class="grid gap-4 md:grid-cols-2 mt-2">
                        @foreach($question->paraphrasings as $paraphrasing)
                        <div class="text-sm">{{ $paraphrasing->poetry_line }}</div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Comprehension -->
                @if($question->subtype->tagname=='comprehension')
                <div class="text-sm">
                    <label for="">Comprehension Questions</label>
                    <div class="grid gap-4 mt-2">
                        @php
                        $i=1;
                        @endphp
                        @foreach($question->comprehensions as $comprehension)
                        <div class="text-sm">{{ Roman::lowercase($i++) }} &nbsp {{ $comprehension->sub_question }}</div>
                        @endforeach
                    </div>
                </div>
                @endif

                @endif

                <div class="grid gap-1">
                    <label>Exercise No.</label>
                    <div>{{ $question->exercise_no }}</div>
                </div>

                <div class="grid gap-1">
                    <label>Conceptual?</label>
                    <div>@if($question->is_conceptual) Yes @else No @endif</div>
                </div>

                <div class="grid gap-y-1">
                    <label for="">Bise Frequency</label>
                    <div>{{ $question->frequency }}</div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection