@extends('layouts.basic')

@section('header')
<x-header></x-header>
@endsection

@section('body')
<style>
    .option label {
        cursor: pointer;
    }

    .answer .tick,
    .answer .cross {
        display: none;
    }

    .answer.solved .rejected label {
        text-decoration-style: solid;
        text-decoration: line-through;
        text-decoration-color: red;
    }

    .answer.solved .radio {
        display: none;
    }

    .answer.solved .correct-option label {
        background-color: green;
        color: white;
    }

    .answer.solved.correctly-answered .tick {
        display: block;
    }

    .answer.solved.correctly-answered .cross {
        display: none;
    }

    .answer.solved .cross {
        display: block;
    }
</style>
@php
$sr=1;
@endphp
<div class="w-full md:w-2/3 mx-auto text-center mt-32 px-5">

    <div class="grid md:grid-cols-2 items-end gap-4">
        <div class="flex flex-col md:flex-row gap-3 items-center md:items-end">
            <img src="{{url('images/small/mcqs-1.jpg')}}" alt="mcqs" class="w-24">
            <div class="flex flex-col">
                <div class="flex text-left space-x-3">
                    <h2>{{ $book->name }} </h2>
                    <a href="{{route('self-tests.index')}}" class="btn-blue rounded-lg text-xs"><i class="bx bx-pencil"></i></a>
                </div>
                <p class="text-center md:text-left">@if(count($chapterNos)>1)Chapters @else Chapter @endif : {{ $chapterNos->implode(',') }}</p>
            </div>
        </div>
        <p class="text-slate-600 text-center md:text-right">MCQs: {{ session('mcqs_count') }}</p>
    </div>

    <div class="leading-relaxed mt-6 text-left bg-teal-800 text-slate-300 p-5">
        <ul class="list-disc list-inline text-left text-sm pl-4">
            <li>All questions are compulsory</li>
            <li>Once you finish the test, system will display your score and mistakes</li>
        </ul>
    </div>

    <input type="text" id="mcqs_count" value="{{session('mcqs_count')}}" hidden>
    <!-- questions -->
    <div class="mx-auto flex flex-col gap-y-6 mt-8">
        @foreach($questions as $question)
        <div class="flex flex-col items-start justify-start border border-dashed rounded  bg-slate-50 relative">
            <p class="w-8 font-semibold text-center text-slate-100 bg-teal-600">{{$sr++}}</p>
            <div class="pt-4 pb-8 px-8 md:px-16 w-full">
                <p class="font-semibold text-base text-left text-gray-800">{{$question->statement}}</p>
                <div class="divider my-4"></div>
                <div class="answer flex justify-between items-center">
                    <div class="flex flex-col mt-4 text-gray-600 gap-y-2">
                        <div class="option-group">
                            <div class="option flex space-x-3 items-center @if($question->mcq->correct=='a') correct-option @endif">
                                <input type="radio" id='radioa-{{$question->id}}' class="radio w-4 h-4">
                                <label for="radioa-{{$question->id}}" class="text-base">{{$question->mcq->choice_a}}</label>
                            </div>

                            <div class="option flex space-x-3 items-center @if($question->mcq->correct=='b') correct-option @endif">
                                <input type="radio" id='radiob-{{$question->id}}' class="radio w-4 h-4">
                                <label for="radiob-{{$question->id}}" class="text-base">{{$question->mcq->choice_b}}</label>
                            </div>

                            <div class="option flex space-x-3 items-center @if($question->mcq->correct=='c') correct-option @endif">
                                <input type="radio" id='radioc-{{$question->id}}' class="radio w-4 h-4">
                                <label for="radioc-{{$question->id}}" class="text-base">{{$question->mcq->choice_c}}</label>
                            </div>
                            <div class="option flex space-x-3 items-center @if($question->mcq->correct=='d') correct-option @endif">
                                <input type="radio" id="radiod-{{$question->id}}" class="radio w-4 h-4">
                                <label for="radiod-{{$question->id}}" class="text-base">{{$question->mcq->choice_d}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-center items-center">
                        <img src="{{url('images/icons/cross.png')}}" alt="cross" class="cross w-8">
                        <img src="{{url('images/icons/tick.png')}}" alt="tick" class="tick w-8">
                    </div>
                </div>
            </div>

        </div>
        @endforeach
        <div class="flex justify-end">
            <a id='quit' href="{{ url('/') }}" class="btn-blue rounded py-2 mr-3"> Cancel Now</a>
            <button id='finishQuizButton' type="submit" class="btn-red rounded py-2"> Finsh Test</button>
            <a id='tryOnceMore' href="{{ route('self-tests.show', $book) }}" class="hidden btn-green rounded py-2"> Try Once More</a>
        </div>
    </div>
    <div class="my-8"></div>
</div>
@endsection
@section('footer')
<x-footer></x-footer>
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
                if ($(this).parent().hasClass('correct-option')) {
                    $(this).parent().addClass('accepted')
                    $(this).parent().parent().parent().parent().addClass('correctly-answered')
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
                $('#tryOnceMore').removeClass('hidden');
            });
        }

    })
</script>
@endsection