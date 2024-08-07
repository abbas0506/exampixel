@extends('layouts.basic')

@section('header')
<x-header></x-header>
@endsection

@section('body')
<style>
    .option label {
        cursor: pointer;
    }

    .bi-ckeck-lg {
        color: green;
        font-weight: bolder;
    }

    .bi-x {
        color: red;
        font-weight: bolder;
    }

    .answer i {
        display: none;
    }

    .answer.solved .accepted .bi-check-lg {
        display: block;
    }

    .answer.solved .rejected .bi-x {
        display: block;
    }

    .answer.solved .radio {
        display: none;
    }

    .answer.solved .correct label {
        background-color: #76D7C4;
        color: white;
    }

    .hero {
        background-image: linear-gradient(rgba(0, 100, 100, 1.0),
                rgba(128, 128, 128, 0));
        /* url("{{asset('/images/bg/exams1-01.svg')}}"); */
        background-position: top;
        background-repeat: no-repeat;
        background-size: contain;
        background-clip: border-box;
        position: relative;
    }
</style>
@php
$sr=1;
@endphp
<div class="w-full md:w-2/3 mx-auto text-center mt-32 px-5">
    <h1 class="text-2xl md:text-3xl">SELF TEST</h1>
    <div class="leading-relaxed mt-6 text-left bg-teal-800 text-slate-300 p-5">
        <ul class="list-disc list-inline text-left text-sm pl-4">
            <li>All questions are compulsory</li>
            <li>Attempt all questions before you finish the test</li>
            <li>Once you finish the test,system will display your score and mistakes</li>
        </ul>
    </div>
    <div class="h-1 w-24 bg-teal-800 mx-auto mt-6"></div>
    <h2 class="mt-6 text-red-600">MCQs: {{ session('mcqs_count') }}</h2>
    <input type="text" id="mcqs_count" value="{{session('mcqs_count')}}" hidden>
    <!-- questions -->
    <div class="mx-auto flex flex-col gap-y-6 px-4 mt-8">
        @foreach($questions as $question)
        <div class="flex flex-col items-start justify-start border border-dashed rounded  bg-slate-50 relative">
            <p class="w-8 font-semibold text-center text-slate-100 bg-teal-600">{{$sr++}}</p>
            <div class="pt-4 pb-8 px-8 md:px-16 w-full">
                <p class="font-semibold text-base text-left text-gray-800">{{$question->statement}}</p>
                <div class="divider my-4"></div>
                <div id='ans' class="answer flex flex-col mt-4 text-gray-600 gap-y-2">
                    <div class="option flex space-x-3 items-center @if($question->mcq->correct=='a') correct @endif">
                        <input type="radio" id='radioa-{{$question->id}}' class="radio">
                        <label for="radioa-{{$question->id}}" class="text-base">{{$question->mcq->choice_a}}</label>
                        <i class="bi-check-lg"></i>
                        <i class="bi-x"></i>
                    </div>

                    <div class="option flex space-x-3 items-center @if($question->mcq->correct=='b') correct @endif">
                        <input type="radio" id='radiob-{{$question->id}}' class="radio">
                        <label for="radiob-{{$question->id}}" class="text-base">{{$question->mcq->choice_b}}</label>
                        <i class="bi-check-lg"></i>
                        <i class="bi-x"></i>
                    </div>

                    <div class="option flex space-x-3 items-center @if($question->mcq->correct=='c') correct @endif">
                        <input type="radio" id='radioc-{{$question->id}}' class="radio">
                        <label for="radioc-{{$question->id}}" class="text-base">{{$question->mcq->choice_c}}</label>
                        <i class="bi-check-lg"></i>
                        <i class="bi-x"></i>
                    </div>
                    <div class="option flex space-x-3 items-center @if($question->mcq->correct=='d') correct @endif">
                        <input type="radio" id="radiod-{{$question->id}}" class="radio">
                        <label for="radiod-{{$question->id}}" class="text-base">{{$question->mcq->choice_d}}</label>
                        <i class="bi-check-lg"></i>
                        <i class="bi-x"></i>
                    </div>
                </div>

            </div>

        </div>
        @endforeach
        <div class="flex justify-end">
            <button id='finishQuizButton' type="submit" class="btn-orange rounded py-2"> Finsh Test</button>
        </div>
    </div>
    <div class="my-8"></div>
</div>
@endsection

@section('script')
<script type="module">
    $('.radio').change(function() {
        var selectedOption = $(this)
        $(this).parent().parent().children().find('.radio').each(function() {
            if ($(this) != selectedOption)
                $(this).prop('checked', false);
        })
        selectedOption.prop('checked', true)
    });

    $('#finishQuizButton').click(function() {
        var correctAnswers = 0;
        var numOfMcqs = $('#mcqs_count').val();
        var unAnswered = numOfMcqs;
        $('.answer').each(function() {
            $(this).children().find('.radio:checked').each(function() {
                unAnswered -= 1
                if ($(this).parent().hasClass('correct')) {
                    $(this).parent().addClass('accepted')
                    correctAnswers += 1;
                } else
                    $(this).parent().addClass('rejected')
            })
        })
        if (unAnswered > 0) {
            Swal.fire({
                icon: "warning",
                title: unAnswered + " questions left",
                text: "Please complete the quiz!",
            });
        } else {
            var scorePercentage = parseFloat(correctAnswers / numOfMcqs * 100).toFixed(0);
            var text = '';
            if (scorePercentage < 60) text = "Best of luck for next time!"
            else if (scorePercentage < 75) text = "Good effort..."
            else if (scorePercentage < 90) text = "Outstanding marks!"
            else text = "Brilliant!"
            Swal.fire({
                icon: "success",
                title: scorePercentage + "%",
                // parseFloat(numOfMcqs / correctAnswers).toFixed(1) 
                text: text,
            });
            // display correct asnswers
            $('.answer').each(function() {
                $(this).addClass('solved')
                $('#finishQuizButton').addClass('hidden');
            });
        }

    })
</script>
@endsection