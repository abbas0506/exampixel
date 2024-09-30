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
            <a href="{{url('/')}}">Home</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('admin.qbank-books.index',)}}">Books</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('admin.qbank-books.chapters.index',$book)}}">Chapters</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('admin.chapter.questions.index',$chapter)}}">Questions</a>
            <i class="bx bx-chevron-right"></i>
            <div>Edit</div>
        </div>


        <div class="container-light">
            <div class="flex flex-wrap items-center justify-between">
                <h3 class="bg-green-800 text-green-100 px-3 py-1 rounded-full">Edit Question</h3>
                <div class="flex items-center space-x-1 ">
                    <h3>{{ $chapter->book->name }}</h3>
                    <i class="bx bx-chevron-right"></i>
                    <p class="text-sm">Chapter {{ $chapter->sr }}</p>
                </div>
            </div>
            <div class="divider my-5"></div>
            <div class="md:w-3/4 mx-auto mt-8">
                <!-- page message -->
                @if($errors->any())
                <x-message :errors='$errors'></x-message>
                @else
                <x-message></x-message>
                @endif
                <form action="{{route('admin.chapter.questions.update', [$chapter, $question])}}" method='post' class="grid md:grid-cols-3 gap-6 md:gap-y-8 md:gap-x-16 mt-12" onsubmit="return validate(event)">
                    @csrf
                    @method('PATCH')
                    <div class="grid gap-y-1">
                        <label>Question Type</label>
                        <p>{{ $question->type->name }}</p>
                    </div>

                    <!-- <div class="grid gap-y-1">
                        <label>Sub Type</label>
                        <p>{{ $question->subtype->name ?? '' }}</p>
                    </div> -->

                    <div class="grid gap-y-1">
                        <label for="">Marks</label>
                        <input type="number" name="marks" value="{{ $question->marks }}" min=1 class="custom-input-borderless">
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
                    <!-- long question -->
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
                            @if($book->subject->name_en!='Mathematics')
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