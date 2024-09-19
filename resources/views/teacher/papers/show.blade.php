@extends('layouts.basic')

@section('header')
<x-headers.user page="Welcome back!" icon="<i class='bi bi-emoji-smile'>
</i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.teacher page='paper'></x-sidebars.teacher>
@endsection

@php
$colors = config('globals.colors');
$roman = new Roman();
$QNo = 1;
@endphp

@section('body')
<div class="responsive-container">
    <div class="container">
        <div class="flex flex-row justify-between items-center">
            <div class="bread-crumb">
                <a href="{{ url('/') }}">Home</a>
                <div>/</div>
                <div>Paper</div>
            </div>
        </div>


        <div class="content-section rounded-lg mt-2">
            <!-- page message -->
            @if ($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            <div class="grid md:grid-cols-2 items-end gap-4">
                <div class="flex flex-col md:flex-row gap-3 items-center md:items-end">
                    <img src="{{ url('images/small/paper-0.png') }}" alt="paper" class="h-24">
                    <div class="flex flex-col">
                        <h2>{{ Auth::user()->profile?->institution }}</h2>
                        <h2>{{ $paper->book->name }} </h2>
                        <div class="flex items-center space-x-3">
                            <label>{{ $paper->title }}</label> <a href="{{ route('teacher.papers.edit', $paper) }}"
                                class="btn-sky flex justify-center items-center rounded-full p-0 w-5 h-5"><i
                                    class="bx bx-pencil text-xs"></i></a>
                        </div>
                    </div>
                </div>
                <!-- show print button only if paper has some questions -->
                @if ($paper->paperQuestions->count() > 0)
                <div class="flex justify-end w-full">
                    <div
                        class="flex w-12 h-12 items-center justify-center rounded-full bg-orange-100 hover:bg-orange-200">
                        <a href="{{ route('teacher.papers.pdf.create', $paper) }}"><i class="bi-printer"></i></a>
                    </div>
                </div>
                @endif

            </div>

            <div
                class="flex flex-col md:flex-row justify-between items-center mt-6 border bg-slate-200 border-teal-600 rounded-lg text-left p-3 px-5">
                <div class="text-center md:text-left">
                    Please click on a button to add questions
                </div>
                <div class="flex p-4 rounded gap-x-2 text-green-400 text-sm relative">
                    <a href="{{ route('teacher.papers.mcqs.create', $paper) }}" class="btn-teal rounded">MCQs</a>
                    <a href="{{ route('teacher.papers.shorts.create', $paper) }}" class="btn-blue rounded">Short</a>
                    <a href="{{ route('teacher.papers.wholeQuestions.create', $paper) }}"
                        class="btn-red rounded">Long</a>
                </div>
            </div>
            @if ($paper->paperQuestions->count())
            <div class="divider my-3"></div>
            <div class="flex flex-row justify-between items-center w-full">
                <!-- can edit only if some question exists -->
                <div class="flex items-center">
                    <label>Suggested Time: &nbsp {{ $paper->marks()*1.5 }}min</label>
                    <div class="flex items-center space-x-2">
                        <!-- <label>{{ $paper->duration }}</label> -->
                        <a href="{{ route('teacher.papers.edit', $paper) }}"
                            class="btn-sky flex justify-center items-center rounded-full p-0 w-5 h-5"><i
                                class="bx bx-pencil text-xs"></i></a>
                    </div>
                </div>

                <label>Max marks: {{ $paper->marks() }}</label>
            </div>
            <div class="divider my-3"></div>
            <div class="flex flex-col gap-2 mt-3">
                <!-- MCQs -->
                @foreach ($paper->paperQuestions->sortBy('type_id') as $paperQuestion)
                @php
                $i = 1;
                @endphp
                <!-- mcqs -->
                @if ($paperQuestion->type_id == 1)
                <div class="question mcq">
                    <div class="head">
                        <div class="sr">Q.{{ $QNo++ }}</div>
                        <h2 class="flex-1">{{ $paperQuestion->question_title }} <span class="text-sm">({{ $paperQuestion->compulsoryParts() }}x1={{ $paperQuestion->compulsoryParts() }})</span> </h2>
                        <form
                            action="{{ route('teacher.paper.questions.destroy', [$paper, $paperQuestion]) }}"
                            method="post">
                            @csrf
                            @method('DELETE')
                            <button><i class="bx bx-trash text-red-600 confirm-del"></i></button>
                        </form>
                    </div>
                    <div class="body">
                        @foreach ($paperQuestion->paperQuestionParts as $paperQuestionPart)
                        <div class="sub">
                            <div class="sr">{{ $roman->lowercase($i++) }}</div>
                            <div class="statement">{{ $paperQuestionPart->question->statement }}
                                @if (auth()->user()->email == 'mazeemrehan@gmail.com')
                                [{{ $paperQuestionPart->question->chapter_id }}
                                -{{ $paperQuestionPart->question->id }}]
                                @endif
                            </div>
                            <div class="action">
                                <a
                                    href="{{ route('teacher.paper-question-parts.refresh', $paperQuestionPart) }}"><i
                                        class="bi-arrow-repeat"></i></a>
                            </div>
                        </div>
                        <div class="choices">
                            <div class="choice">
                                <div class="sr">a.</div>
                                <div class="desc">{{ $paperQuestionPart->question->mcq->choice_a }}
                                </div>
                            </div>
                            <div class="choice">
                                <div class="sr">b.</div>
                                <div class="desc">{{ $paperQuestionPart->question->mcq->choice_b }}
                                </div>
                            </div>
                            <div class="choice">
                                <div class="sr">c.</div>
                                <div class="desc">{{ $paperQuestionPart->question->mcq->choice_c }}
                                </div>
                            </div>
                            <div class="choice">
                                <div class="sr">d.</div>
                                <div class="desc">{{ $paperQuestionPart->question->mcq->choice_d }}
                                </div>
                            </div>

                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Short Question -->
                @if ($paperQuestion->type_id == 2)
                <div class="question">
                    <div class="head">
                        <div class="sr">Q.{{ $QNo++ }}</div>
                        <h2 class="flex-1">{{ $paperQuestion->question_title }} <span class="text-sm">({{ $paperQuestion->compulsoryParts() }}x2={{ $paperQuestion->compulsoryParts()*2 }})</span> </h2>
                        <form
                            action="{{ route('teacher.paper.questions.destroy', [$paper, $paperQuestion]) }}"
                            method="post">
                            @csrf
                            @method('DELETE')
                            <button><i class="bx bx-trash text-red-600 confirm-del"></i></button>
                        </form>

                    </div>
                    <div class="body">
                        @foreach ($paperQuestion->paperQuestionParts as $paperQuestionPart)
                        <div class="sub">
                            <div class="sr">{{ $roman->lowercase($i++) }}</div>
                            <div class="statement">{{ $paperQuestionPart->question->statement }}
                                @if (auth()->user()->email == 'mazeemrehan@gmail.com')
                                [{{ $paperQuestionPart->question->chapter_id }}
                                -{{ $paperQuestionPart->question->id }}]
                                @endif
                            </div>
                            <div class="action">
                                <a
                                    href="{{ route('teacher.paper-question-parts.refresh', $paperQuestionPart) }}"><i
                                        class="bi-arrow-repeat"></i></a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif <!--end short -->

                <!-- Long Questions -->
                @if ($paperQuestion->type_id == 3)
                @if ($paperQuestion->question_nature == 'whole')
                @foreach ($paperQuestion->paperQuestionParts as $paperQuestionPart)
                <div class="flex items-center w-full">
                    @if ($loop->first)
                    <div class="w-12">Q. {{ $QNo++ }}</div>
                    <div class="flex-1 text-left">{{ $paperQuestionPart->question->statement }} <span class="text-sm">({{ $paperQuestionPart->marks }})</span></div>
                    <a href="{{ route('teacher.paper-question-parts.refresh', $paperQuestionPart) }}"
                        class="ml-2"><i class="bi-arrow-repeat text-cyan-600"></i></a>
                    <form
                        action="{{ route('teacher.paper.questions.destroy', [$paper, $paperQuestion]) }}"
                        method="post">
                        @csrf
                        @method('DELETE')
                        <button><i class="bx bx-trash text-red-600 confirm-del"></i></button>
                    </form>
                    @else
                    <div class="w-12"></div>
                    <div class="flex-1 text-left "><span class="font-semibold">OR</span> &nbsp
                        {{ $paperQuestionPart->question->statement }}@if (auth()->user()->email == 'mazeemrehan@gmail.com')
                        [{{ $paperQuestionPart->question->chapter_id }}
                        -{{ $paperQuestionPart->question->id }}]
                        @endif
                    </div>
                    <a href="{{ route('teacher.paper-question-parts.refresh', $paperQuestionPart) }}"
                        class="ml-2"><i class="bi-arrow-repeat text-cyan-600"></i></a>
                    @endif
                </div>
                @endforeach <!-- end iterating whole question/alternatives -->
                <div class="flex items-center mt-2">
                    <div class="w-12"></div>
                    <a href="{{ route('teacher.paperQuestions.alternativeLongs.create', $paperQuestion) }}"
                        class="btn-blue text-xs">OR</a>
                </div>
                @endif <!-- end whole -->

                <!-- Partial Question Starts -->
                @if ($paperQuestion->question_nature == 'partial')
                @php
                $alphabets = range('a', 'z');
                @endphp

                @foreach ($paperQuestion->paperQuestionParts as $paperQuestionPart)
                <div class="flex items-center w-full">
                    <div class="w-12">
                        @if ($loop->first)
                        Q. {{ $QNo++ }}
                        @endif
                    </div>
                    <div class="flex-1 text-left">{{ $alphabets[$loop->index] }}).
                        {{ $paperQuestionPart->question->statement }} ({{ $paperQuestionPart->marks }})
                    </div>
                    <a href="{{ route('teacher.paper-question-parts.refresh', $paperQuestionPart) }}"
                        class="ml-2"><i class="bi-arrow-repeat text-cyan-600"></i></a>
                    <form
                        action="{{ route('teacher.paper.questions.destroy', [$paper, $paperQuestion]) }}"
                        method="post">
                        @csrf
                        @method('DELETE')
                        <button><i class="bx bx-trash text-red-600 confirm-del"></i></button>
                    </form>

                </div>
                @endforeach <!-- end iterating partial question/alternatives -->
                <div class="flex items-center mt-2">
                    <div class="w-12"></div>
                    <a href="{{ route('teacher.paperQuestions.complementQuestions.create', $paperQuestion) }}"
                        class="btn-blue text-xs">Other</a>
                </div>
                @endif <!-- end partial -->
                @endif <!-- end longs -->
                @endforeach <!-- end paper questions -->
            </div>
            @else
            <div class="divider my-3"></div>
            <div class="h-full flex flex-col justify-center items-center py-4 gap-3">
                <i class="bi-emoji-smile text-4xl"></i>
                <p class="text-center">Start adding questions</p>
            </div>
            @endif
        </div>
    </div>
    @endsection

    @section('script')
    <script type="module">
        $('document').ready(function() {

            $('.confirm-del').click(function(event) {
                var form = $(this).closest("form");
                // var name = $(this).data("name");
                event.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        //submit corresponding form
                        form.submit();
                    }
                });
            });

        });
    </script>
    @endsection