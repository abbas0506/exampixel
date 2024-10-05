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
            <div>Edit Q.</div>
        </div>

        <div class="divider"></div>

        <div class="md:w-3/4 mx-auto mt-8">

            <h2>{{ $question->chapter->book->name }}</h2>
            <label>Ch # {{ $question->chapter->sr }}. {{ $question->chapter->title }}</label>

            <!-- page message -->
            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif
            <form action="{{route('operator.chapter.questions.update', [$chapter, $question])}}" method='post' class="grid md:grid-cols-3 gap-6 md:gap-y-8 md:gap-x-16 mt-12" onsubmit="return validate(event)">
                @csrf
                @method('PATCH')
                <input type="hidden" id='book_id' value="{{ $chapter->book->id }}">
                <div class="grid gap-y-1">
                    <label>Question Type</label>
                    <p>{{ $question->type->name }}</p>
                </div>

                <div class="grid gap-y-1 col-span-full">
                    <label for="">Question Statement</label>
                    <textarea type="text" id='statement' name="statement" class="custom-input py-2 mt-2" rows='3' placeholder="Type here">{{ $question->statement }}</textarea>
                </div>

                <!-- MCQs -->
                @if($question->type_id == 1)
                <div id='mcqCover' class="questionable col-span-full">
                    <label for="">Choices</label>
                    <div class="grid gap-4 mt-2">
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" name='check_a' class="correct w-4 h-4" value='1' @checked($question->mcq->correct=='a')>
                            <input type="text" name='choice_a' class="custom-input-borderless choice md:w-1/2" placeholder="a." value="{{ $question->mcq->choice_a }}">
                        </div>
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" name='check_b' class="correct w-4 h-4" value='1' @checked($question->mcq->correct=='b')>
                            <input type="text" name='choice_b' class="custom-input-borderless choice md:w-1/2" placeholder="b." value="{{ $question->mcq->choice_b }}">
                        </div>
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" name='check_c' class="correct w-4 h-4" value='1' @checked($question->mcq->correct=='c')>
                            <input type="text" name='choice_c' class="custom-input-borderless choice md:w-1/2" placeholder="c." value="{{ $question->mcq->choice_c }}">
                        </div>
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" name='check_d' class="correct w-4 h-4" value='1' @checked($question->mcq->correct=='d')>
                            <input type="text" name='choice_d' class="custom-input-borderless choice md:w-1/2" placeholder="d." value="{{ $question->mcq->choice_d }}">
                        </div>
                    </div>
                </div>

                @elseif($question->type_id == 3)
                @if($question->subtype->tagname=='paraphrasing')
                <!-- paraphrasing question -->
                <div id='paraphrasingCover' class="questionable col-span-full">
                    <label for="">Paraphrasing: Poetry Lines</label>
                    <div class="grid gap-4 md:grid-cols-2 mt-2">
                        @foreach($question->paraphrasings as $paraphrasing)
                        <input type="text" name='poetry_lines[]' class="custom-input-borderless" placeholder="Poetry line 1" value="{{ $paraphrasing->poetry_line }}">
                        @endforeach
                        <input type="text" name='poetry_lines[]' class="custom-input-borderless" placeholder="Poetry line">
                        <input type="text" name='poetry_lines[]' class="custom-input-borderless" placeholder="">

                    </div>
                </div>
                @endif

                @if($question->subtype->tagname=='comprehension')
                <!-- Comprehension question -->
                <div class="col-span-full">
                    <label for="">Comprehension Questions</label>
                    <div class="grid gap-4 mt-2">
                        @foreach($question->comprehensions as $comprehension)
                        <input type="text" name='sub_questions[]' class="custom-input-borderless" placeholder="Q." value="{{ $comprehension->sub_question }}">
                        @endforeach
                        <input type="text" name='sub_questions[]' class="custom-input-borderless" placeholder="Q.">

                    </div>
                </div>
                @endif
                @endif

                <!-- preview -->
                <div class="col-span-full border p-6">
                    <!-- <span id="math" class="text-left no-line-break text-slate-400">Preview</span> -->
                    <span id="math" class="text-left text-slate-400">Preview</span>
                </div>
                <div class="grid gap-1">
                    <label>Exercise No.</label>
                    <select name="exercise_no" id="" class="custom-input-borderless">
                        <option value="">NA</option>
                        @if($chapter->book->subject->name_en!='Mathematics')
                        <option value="0">Basic</option>
                        @else
                        @for($i=1;$i<=20;$i++) <option value="{{$i}}" @selected(session('exercise_no')==$i)>{{ $chapter->sr }}.{{$i}}</option>
                            @endfor
                            @endif
                    </select>
                </div>

                <div class="grid gap-1">
                    <label>Conceptual?</label>
                    <select name="is_conceptual" id="" class="custom-input-borderless">
                        <option value="1" @selected(session('is_conceptual'))>Yes</option>
                        <option value="0" @selected(!session('is_conceptual'))>No</option>
                    </select>
                </div>

                <div class="grid gap-y-1">
                    <label for="">Bise Frequency</label>
                    <input type="number" name="frequency" value="1" min=0 class="custom-input-borderless">
                </div>
                <input type="hidden" name='sr' value="{{ $chapter->sr }}">
                <div class="text-right col-span-full">
                    <button type="submit" class="btn-green">Update Now</button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
@section('script')
<script type="module">
    $(document).ready(function() {
        // show or hide on page load
        if ($('#type_id').val() == 1) {
            $('.questionable').hide()
            $('#mcqCover').show()
        } else if ($('#subtype_id').val() == 18) {
            $('.questionable').hide()
            $('#paraphrasingCover').show()
        } else if ($('#subtype_id').val() == 19) {
            $('.questionable').hide()
            $('#divComprehension').show()
        }


        $('#statement').bind('input propertychange', function() {
            $('#math').html($('#statement').val());
            MathJax.typeset();
        });

        $('#type_id').change(function() {
            //objetive selected
            if ($(this).val() == 1) {
                $('.questionable').hide()
                $('#mcqCover').show()
            } else {
                $('#mcqCover').hide()
            }

            var token = $("meta[name='csrf-token']").attr("content");
            var book_id = $('#book_id').val();

            //fetch subtypes

            $.ajax({
                type: 'GET',
                url: "{{url('fetchSubTypesByTypeId')}}",
                data: {
                    "type_id": $(this).val(),
                    "book_id": book_id,
                    "_token": token,
                },
                success: function(response) {
                    //
                    $('#subtype_id').html(response.options);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    Swal.fire({
                        icon: 'warning',
                        title: errorThrown
                    });
                }
            }); //ajax end



        });

        $('#subtype_id').change(function() {
            // paraphrasing
            if ($(this).val() == 18) {
                $('.questionable').hide()
                $('#paraphrasingCover').show()
            } else {
                $('#paraphrasingCover').hide()
            }

            // if comprehension option 
            if ($(this).val() == 19) {
                $('.questionable').hide()
                $('#divComprehension').show()
            } else {
                $('#divComprehension').hide()
            }

        })

        $('.choice').bind('input propertychange', function() {
            $('#math').html($(this).val());
            MathJax.typeset();
        });


        $('.correct').change(function() {
            $('.correct').not(this).prop('checked', false);
            $(this).prop('checked', true)
        });
    });
</script>
@endsection