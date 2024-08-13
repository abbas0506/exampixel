@extends('layouts.teacher')
@section('page-content')

<div class="custom-container">
    <h1>Test Draft</h1>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <div>Draft</div>
    </div>

    <div class="content-section relative">
        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <!-- show print button only if test has some questions -->
        @if($test->questions->count()>0)
        <div class="flex justify-end w-full">
            <div class="flex w-12 h-12 items-center justify-center rounded-full bg-orange-100 hover:bg-orange-200">
                <a href="{{route('teacher.tests.pdf.create',$test)}}"><i class="bi-printer"></i></a>
            </div>
        </div>
        @endif

        <div class="flex flex-col items-center">
            <h2>{{$test->subject->name}} - {{$test->subject->grade->roman_name}}</h2>
            <div class="flex flex-row items-center space-x-3 mt-3">
                <label>{{$test->title}}</label> <a href="{{route('teacher.tests.edit',$test)}}" class="btn-sky flex justify-center items-center rounded-full p-0 w-5 h-5"><i class="bx bx-pencil text-xs"></i></a>
            </div>
        </div>
        @if($test->questions->count())
        <div class="divider my-3"></div>
        <div class="flex flex-row justify-between items-center w-full">
            <!-- can edit only if some question exists -->
            <div class="flex items-center">
                <label>Suggested Time: &nbsp</label>
                <div class="flex items-center space-x-2">
                    <label>{{$test->getDuration()}}</label>
                    <a href="{{route('teacher.tests.edit',$test)}}" class="btn-sky flex justify-center items-center rounded-full p-0 w-5 h-5"><i class="bx bx-pencil text-xs"></i></a>
                </div>
            </div>

            <label>Max marks: {{$test->totalMarks()}}</label>
        </div>
        <div class="divider my-3"></div>
        <div class="flex flex-col gap-2 mt-3">
            <!-- MCQs -->
            @foreach($test->questions()->mcqs()->get() as $testQuestion)
            <div class="flex items-center justify-between">
                <div class="flex items-baseline space-x-1">
                    <h3>Q.{{$testQuestion->question_no}}</h3>
                    <h3>Encircle the correct option. &nbsp</h3>
                    @if($testQuestion->parts->count()==$testQuestion->necessary_parts)
                    <p class="text-xs">(all questions are compulsory)</p>
                    @else
                    <p class="text-xs">(any {{$testQuestion->necessary_parts}} questions)</p>
                    @endif
                </div>
                <div class="text-sm">
                    {{$testQuestion->necessary_parts}}x1={{$testQuestion->necessary_parts}}
                </div>
            </div>
            <ol class="list-[lower-roman] list-outside text-sm pl-6">
                @foreach($testQuestion->parts as $part)
                <li>
                    {{$part->question->question}} <a href="{{route('teacher.tests.questions.parts.refresh',$part)}}" class="ml-2"><i class="bi-arrow-repeat"></i></a>
                    <div class="grid grid-cols-1 md:grid-cols-4">
                        <div>a. {{$part->question->mcq->option_a}}</div>
                        <div>b. {{$part->question->mcq->option_b}}</div>
                        <div>c. {{$part->question->mcq->option_c}}</div>
                        <div>d. {{$part->question->mcq->option_d}}</div>
                    </div>
                </li>
                @endforeach
            </ol>
            @endforeach

            <!-- SHORT Questions -->
            @foreach($test->questions()->short()->get() as $testQuestion)
            <div class="flex items-center justify-between mt-3">
                <div class="flex items-baseline space-x-1 ">
                    <h3>Q.{{$testQuestion->question_no}}</h3>
                    <h3> Answer the following. &nbsp</h3>
                    @if($testQuestion->parts->count()==$testQuestion->necessary_parts)
                    <p class="text-xs">(all questions are compulsory)</p>
                    @else
                    <p class="text-xs">(any {{$testQuestion->necessary_parts}} questions)</p>
                    @endif
                </div>
                <div class="text-sm">
                    {{$testQuestion->necessary_parts}}x2={{$testQuestion->necessary_parts*2}}
                </div>
            </div>
            <ol class="list-[lower-roman] list-outside text-sm pl-6">
                @foreach($testQuestion->parts as $part)
                <li class="mt-2">{{$part->question->question}} {{$part->question->bise_frequency}} <a href="{{route('teacher.tests.questions.parts.refresh',$part)}}" class="ml-2"><i class="bi-arrow-repeat"></i></a></li>
                @endforeach
            </ol>
            @endforeach

            <!-- LONG Questions -->
            @foreach($test->questions()->long()->get() as $testQuestion)

            @if($testQuestion->parts->count()==1)
            <!-- if long question is compact i.e not splitted  -->
            <div class="flex items-center justify-between mt-3">
                <div class="flex items-center space-x-1">
                    <h3>Q.{{$testQuestion->question_no}}</h3>
                    <p class="text-sm ml-1">{{$testQuestion->parts->first()->question->question}}</p>
                </div>
                <div class="flex items-center space-x-1">
                    <p class="text-sm">{{$testQuestion->parts->first()->marks}}</p>
                    <a href="{{route('teacher.question-parts.edit',$testQuestion->parts->first())}}" class="btn-sky flex justify-center items-center rounded-full p-0 w-5 h-5"><i class="bx bx-pencil text-xs"></i></a>
                </div>
            </div>
            @else
            <!-- if long question splits -->
            <div class="flex items-center justify-between mt-3">
                <div class="flex items-baseline space-x-1">
                    <h3>Q.{{$testQuestion->question_no}}</h3>
                    <h3>Answer the following</h3>
                </div>
                <div class="text-sm">
                </div>
            </div>
            <ol class="list-[lower-alpha] list-outside text-sm pl-6">
                @foreach($testQuestion->parts as $part)
                <li class="mt-2">
                    <div class="flex justify-between">
                        <div>{{$part->question->question}} <a href="{{route('teacher.tests.questions.parts.refresh',$part)}}" class="ml-2"><i class="bi-arrow-repeat"></i></a></div>
                        <div class="flex items-center space-x-2">
                            <div>{{$part->marks}}</div>
                            <a href="{{route('teacher.question-parts.edit',$part)}}" class="btn-sky flex justify-center items-center rounded-full p-0 w-5 h-5"><i class="bx bx-pencil text-xs"></i></a>
                        </div>
                    </div>
                </li>
                @endforeach
            </ol>
            <!-- long question ends -->
            @endif
            <!--looping test questions ends -->
            @endforeach
        </div>
        @else
        <div class="divider my-3"></div>
        <div class="h-full flex flex-col justify-center items-center py-4 gap-3">
            <i class="bi-emoji-smile text-4xl"></i>
            <p class="text-center">Start adding questions</p>
        </div>
        <!-- <div class="divider my-3"></div> -->
        @endif

        <div id='add-question-btn' class="fixed right-6 bottom-6 h-14 w-14 flex  justify-center items-center rounded-full btn-green">
            <i class="bi bi-plus-lg"></i>
        </div>

        <!-- modal showing question types -->
        <div id='floating-modal' class="modal bg-gray-600">
            <div class="flex p-4 rounded gap-x-6 text-green-400 text-sm relative">
                <a href="{{route('teacher.tests.questions.add',[$test, 'mcq'])}}" class="hover:text-slate-100">MCQs</a>
                <a href="{{route('teacher.tests.questions.add',[$test, 'short'])}}" class="hover:text-slate-100">Short</a>
                <a href="{{route('teacher.tests.questions.add',[$test, 'long'])}}" class="hover:text-slate-100">Long</a>

                <button id='close-modal' class="absolute -top-1 right-0 "><i class="bi bi-x text-orange-300 hover:text-orange-400 text-sm"></i></button>
            </div>
        </div>

        <!-- bottom options to add question: short, long, MCQ -->
        <!-- <div class="flex justify-center gap-x-2 mt-8">
            <div class="flex flex-col justify-center items-center">
                <a href="{{route('teacher.tests.questions.add',[$test, 'mcq'])}}" class="flex justify-center items-center w-8 h-8 btn-blue rounded-sm"><i class="bi-plus text-2xl"></i></a>
                <div class="text-xs text-slate-600">MCQs</div>
            </div>
            <div class="flex flex-col justify-center items-center">
                <a href="{{route('teacher.tests.questions.add',[$test, 'short'])}}" class="flex justify-center items-center w-8 h-8 btn-green rounded-e-sm"><i class="bi-plus text-2xl"></i></a>
                <div class="text-xs text-slate-600">Short</div>
            </div>
            <div class="flex flex-col justify-center items-center">
                <a href="{{route('teacher.tests.questions.add',[$test, 'long'])}}" class="flex justify-center items-center w-8 h-8 btn-red rounded-sm"><i class="bi-plus text-2xl"></i></a>
                <div class="text-xs text-slate-600">Long</div>
            </div>
        </div> -->

    </div>
</div>
@endsection
@section('script')
<script type="module">
    $('#close-modal').click(function() {
        if ($('.modal').hasClass('shown'))
            $('.modal').removeClass('shown');
    });
    $('#add-question-btn').click(function() {
        $('.modal').addClass('shown');
    });
</script>
@endsection