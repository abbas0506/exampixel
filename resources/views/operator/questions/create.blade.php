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
            <div>New</div>
        </div>

        <div class="divider my-2"></div>

        <div class="md:w-3/4 mx-auto">
            <!-- page message -->
            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            <h2>{{ $chapter->book->name }}</h2>
            <label>Ch # {{ $chapter->sr }}. {{ $chapter->title }}</label>

            <form action="{{route('operator.chapter.questions.store', $chapter)}}" method='post' class="grid md:grid-cols-3 gap-6 mt-6" onsubmit="return validate(event)">
                @csrf
                <input type="hidden" name="type_id" value="{{$questionableType>2?3:$questionableType}}">
                <input type="hidden" name="questionableType" value="{{$questionableType}}">

                <div class="grid gap-y-1">
                    <label for="">Marks</label>
                    <input type="number" name="marks" value="{{$questionableType>2?5:$questionableType}}" min=1 class="custom-input-borderless">
                </div>

                <div class="grid gap-y-1 col-span-full">
                    <label for="">Question Statement</label>
                    <textarea type="text" id='statement' name="statement" class="custom-input py-2 mt-2" rows='3' placeholder="Type here"></textarea>
                </div>
                @if($questionableType==1)
                <!-- MCQs -->
                <div class="col-span-full">
                    <label for="">Choices</label>
                    <div class="grid gap-4 mt-2">
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" name='check_a' class="correct w-4 h-4" value='1' checked>
                            <input type="text" name='choice_a' class="custom-input-borderless choice md:w-1/2" placeholder="a.">
                        </div>
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" name='check_b' class="correct w-4 h-4" value='1'>
                            <input type="text" name='choice_b' class="custom-input-borderless choice md:w-1/2" placeholder="b.">
                        </div>
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" name='check_c' class="correct w-4 h-4" value='1'>
                            <input type="text" name='choice_c' class="custom-input-borderless choice md:w-1/2" placeholder="c.">
                        </div>
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" name='check_d' class="correct w-4 h-4" value='1'>
                            <input type="text" name='choice_d' class="custom-input-borderless choice md:w-1/2" placeholder="d.">
                        </div>
                    </div>
                </div>
                @elseif($questionableType==2)

                @elseif($questionableType==3)
                @elseif($questionableType==4)
                <!-- Paraphrasing question -->
                <div class="col-span-full">
                    <label for="">Paraphrasing: Poetry Lines</label>
                    <div class="grid gap-4 md:grid-cols-2 mt-2">
                        <input type="text" name='poetry_lines[]' class="custom-input-borderless" placeholder="Poetry line 1">
                        <input type="text" name='poetry_lines[]' class="custom-input-borderless" placeholder="">
                        <input type="text" name='poetry_lines[]' class="custom-input-borderless" placeholder="Poetry line 2">
                        <input type="text" name='poetry_lines[]' class="custom-input-borderless" placeholder="">
                        <input type="text" name='poetry_lines[]' class="custom-input-borderless" placeholder="Poetry line 3">
                        <input type="text" name='poetry_lines[]' class="custom-input-borderless" placeholder="">
                        <input type="text" name='poetry_lines[]' class="custom-input-borderless" placeholder="Poetry line 4">
                        <input type="text" name='poetry_lines[]' class="custom-input-borderless" placeholder="">
                        <input type="text" name='poetry_lines[]' class="custom-input-borderless" placeholder="Poetry line 5">
                        <input type="text" name='poetry_lines[]' class="custom-input-borderless" placeholder="">
                    </div>
                </div>

                @elseif($questionableType==5)
                <!-- Comprehension question -->
                <div class="col-span-ful">
                    <label for="">Comprehension Questions</label>
                    <div class="grid gap-4 mt-2">
                        <input type="text" name='sub_questions[]' class="custom-input-borderless" placeholder="Sub Q.">
                        <input type="text" name='sub_questions[]' class="custom-input-borderless" placeholder="Sub Q.">
                        <input type="text" name='sub_questions[]' class="custom-input-borderless" placeholder="Sub Q.">
                        <input type="text" name='sub_questions[]' class="custom-input-borderless" placeholder="Sub Q.">
                        <input type="text" name='sub_questions[]' class="custom-input-borderless" placeholder="Sub Q.">
                        <input type="text" name='sub_questions[]' class="custom-input-borderless" placeholder="Sub Q.">
                        <input type="text" name='sub_questions[]' class="custom-input-borderless" placeholder="Sub Q.">
                        <input type="text" name='sub_questions[]' class="custom-input-borderless" placeholder="Sub Q.">
                    </div>
                </div>

                @else
                Invalid Question Type
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
                    <button type="submit" class="btn-green">Create Now</button>
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
        $('.questionable').hide()

        // auto show or hide on page load
        if ($('#type_id').val() == 1)
            $('#mcqChoicesCover').show()
        else if ($('#type_id').val() == 3) {
            // long question
            if ($('#subtype_id').val() == 10)
                // paraphrasing case
                $('#paraphrasingCover').show()
            else if ($('#subtype_id').val() == 11)
                // comprehension case
                $('#comprehensionCover').show()
        }

        if (!$('#subtype_id').val())
            $('#subtypeIdCover').hide();

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