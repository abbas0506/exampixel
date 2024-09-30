@extends('layouts.basic')

@section('header')
<x-headers.user page="Welcome back!" icon="<i class='bi bi-emoji-smile'>
</i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.user page='paper'></x-sidebars.user>
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


        <div class="content-section rounded-lg mt-8 text-sm ">
            <!-- page message -->
            @if ($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            <div class="flex flex-col md:flex-row justify-between items-center gap-4 ">
                <div class="flex flex-col md:flex-row gap-3 items-center">
                    <img src="{{ url('images/small/pdf.png') }}" alt="paper" class="h-16">
                    <div class="flex flex-col">
                        <h2>{{ $paper->institution }}</h2>
                        <h2>{{ $paper->book->name }} </h2>
                        <div class="flex items-center space-x-3">
                            <label>{{ $paper->title }}</label> <a href="{{ route('user.papers.edit', $paper) }}"
                                class="btn-sky flex justify-center items-center rounded-full p-0 w-5 h-5"><i
                                    class="bx bx-pencil text-xs"></i></a>
                        </div>
                    </div>
                </div>
                <!-- show print button only if paper has some questions -->

                <div class="flex items-center space-x-3">
                    <a href="{{ route('user.papers.questionChoices.index', $paper) }}" class="flex w-12 h-12 items-center justify-center rounded-full bg-teal-200 hover:bg-teal-400">Q+</a>
                    @if ($paper->paperQuestions->count() > 0)
                    <div
                        class="flex w-12 h-12 items-center justify-center rounded-full bg-orange-100 hover:bg-orange-200">
                        <a href="{{ route('user.papers.pdf.create', $paper) }}"><i class="bi-printer"></i></a>
                    </div>
                    @endif
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
                        <a href="{{ route('user.papers.edit', $paper) }}"
                            class="btn-sky flex justify-center items-center rounded-full p-0 w-5 h-5"><i
                                class="bx bx-pencil text-xs"></i></a>
                    </div>
                </div>

                <label>Max marks: {{ $paper->marks() }}</label>
            </div>
            <div class="divider my-3"></div>
            <div class="flex flex-col gap-2 mt-3">
                <!-- MCQs -->
                @foreach ($paper->paperQuestions as $paperQuestion)
                @php
                $i = 1;
                @endphp

                <!-- mcqs -->
                @if ($paperQuestion->question_type == 1)
                <div class="question mcq">
                    <div class="head">
                        <div class="sr">Q.{{ $QNo++ }}</div>
                        <h2 class="flex-1">{{ $paperQuestion->question_title }} <span class="text-sm">({{ $paperQuestion->compulsoryParts() }}x1={{ $paperQuestion->compulsoryParts() }})</span> </h2>
                        <form
                            action="{{ route('user.paper.questions.destroy', [$paper, $paperQuestion]) }}"
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
                                    href="{{ route('user.paper-question-parts.refresh', $paperQuestionPart) }}"><i
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
                @if ($paperQuestion->question_type == 2)

                <div class="flex items-center w-full">
                    <div class="w-12 font-semibold">Q.{{ $QNo++ }}</div>
                    <h3 class="flex-1 font-semibold">{{ $paperQuestion->question_title }} <span class="text-sm">({{ $paperQuestion->compulsoryParts() }}x2={{ $paperQuestion->compulsoryParts()*2 }})</span> </h3>
                    <form
                        action="{{ route('user.paper.questions.destroy', [$paper, $paperQuestion]) }}"
                        method="post">
                        @csrf
                        @method('DELETE')
                        <button><i class="bx bx-trash text-red-600 confirm-del"></i></button>
                    </form>

                </div>

                @foreach ($paperQuestion->paperQuestionParts as $paperQuestionPart)
                <div class="flex items-center">
                    <div class="w-12"></div>
                    <div class="flex-1">{{ $roman->lowercase($i++) }} &nbsp {{ $paperQuestionPart->question->statement }}
                        @if (auth()->user()->email == 'mazeemrehan@gmail.com')
                        [{{ $paperQuestionPart->question->chapter_id }}
                        -{{ $paperQuestionPart->question->id }}]
                        @endif
                    </div>
                    <div class="action">
                        <a
                            href="{{ route('user.paper-question-parts.refresh', $paperQuestionPart) }}"><i
                                class="bi-arrow-repeat"></i></a>
                    </div>
                </div>
                @endforeach

                @endif <!--end short -->

                <!-- Long Questions -->

                <!-- title + satement -->
                @if ($paperQuestion->question_type == 3)
                <div class="flex items-center w-full">
                    <div class="w-12 font-semibold">Q. {{ $QNo++ }}</div>
                    <div class="flex-1 text-left font-semibold">{{ $paperQuestion->question_title }} <span class="text-sm">({{ $paperQuestion->paperQuestionParts()->first()->marks }})</span></div>
                    <a href="{{ route('user.paper-question-parts.refresh', $paperQuestion->paperQuestionParts()->first()) }}"
                        class="ml-2"><i class="bi-arrow-repeat text-cyan-600"></i></a>
                    <form
                        action="{{ route('user.paper.questions.destroy', [$paper, $paperQuestion]) }}"
                        method="post">
                        @csrf
                        @method('DELETE')
                        <button><i class="bx bx-trash text-red-600 confirm-del"></i></button>
                    </form>
                </div>
                <div class="pl-12">
                    {{$paperQuestion->paperQuestionParts()->first()->question->statement }}
                </div>
                @endif <!-- end question_type 3 -->

                <!-- satement only -->
                @if ($paperQuestion->question_type == 4)
                <div class="flex items-center w-full">
                    <div class="w-12">Q. {{ $QNo++ }}</div>
                    <div class="flex-1 text-left">{{ $paperQuestion->paperQuestionParts()->first()->question->statement }} <span class="text-sm">({{ $paperQuestion->paperQuestionParts()->first()->marks }})</span></div>
                    <a href="{{ route('user.paper-question-parts.refresh', $paperQuestion->paperQuestionParts()->first()) }}"
                        class="ml-2"><i class="bi-arrow-repeat text-cyan-600"></i></a>
                    <form
                        action="{{ route('user.paper.questions.destroy', [$paper, $paperQuestion]) }}"
                        method="post">
                        @csrf
                        @method('DELETE')
                        <button><i class="bx bx-trash text-red-600 confirm-del"></i></button>
                    </form>
                </div>

                @endif <!-- end question_type 4 -->

                <!--Long: no title, with Or alternative -->
                @if ($paperQuestion->question_type == 5)
                @foreach ($paperQuestion->paperQuestionParts as $paperQuestionPart)
                <div class="flex items-center w-full">
                    <div class="w-12">@if ($loop->first) Q. {{ $QNo++ }} @endif</div>
                    <div class="flex-1 text-left">{{ $paperQuestionPart->question->statement }} <span class="text-sm">({{ $paperQuestion->paperQuestionParts()->first()->marks }})</span>@if(!$loop->last) <span class="font-semibold">OR</span> @endif</div>
                    @if ($loop->last)<a href="{{ route('user.paperQuestions.extendedParts.create', $paperQuestion) }}" class="flex justify-center items-center w-6 h-6 p-0 btn-blue rounded-full"><i class="bi-plus"></i></a>@endif

                    <a href="{{ route('user.paper-question-parts.refresh', $paperQuestionPart) }}"
                        class="ml-2"><i class="bi-arrow-repeat text-cyan-600"></i></a>
                    <form
                        action="{{ route('user.paper.questions.destroy', [$paper, $paperQuestion]) }}"
                        method="post">
                        @csrf
                        @method('DELETE')
                        <button><i class="bx bx-trash text-red-600 confirm-del"></i></button>
                    </form>
                </div>
                @endforeach
                @endif <!-- end question_type 5 -->

                <!--Long: partial no title, no choice i.e all compulsory -->
                @if ($paperQuestion->question_type == 6)
                @foreach ($paperQuestion->paperQuestionParts as $paperQuestionPart)

                @php
                $alphabets = range('a', 'z');
                @endphp

                <div class="flex items-center w-full">
                    <div class="w-12">@if ($loop->first) Q. {{ $QNo++ }} @endif</div>
                    <div class="flex-1 text-left">{{ $alphabets[$loop->index] }}).{{ $paperQuestionPart->question->statement }} <span class="text-sm">({{ $paperQuestionPart->marks }})</span></div>
                    @if ($loop->last)<a href="{{ route('user.paperQuestions.extendedParts.create', $paperQuestion) }}" class="flex justify-center items-center w-6 h-6 p-0 btn-blue rounded-full"><i class="bi-plus"></i></a>@endif

                    <a href="{{ route('user.paper-question-parts.refresh', $paperQuestionPart) }}"
                        class="ml-2"><i class="bi-arrow-repeat text-cyan-600"></i></a>
                    <form
                        action="{{ route('user.paper.questions.destroy', [$paper, $paperQuestion]) }}"
                        method="post">
                        @csrf
                        @method('DELETE')
                        <button><i class="bx bx-trash text-red-600 confirm-del"></i></button>
                    </form>
                </div>
                @endforeach
                @endif <!-- end question_type 6 -->


                <!--Long: title + mulitpart + vertical -->
                @if ($paperQuestion->question_type == 7)
                <div class="flex items-center">
                    <div class="w-12 font-semibold"> Q. {{ $QNo++ }} </div>
                    <div class="flex-1 text-left font-semibold">{{ $paperQuestion->question_title }} </div>
                    <form
                        action="{{ route('user.paper.questions.destroy', [$paper, $paperQuestion]) }}"
                        method="post">
                        @csrf
                        @method('DELETE')
                        <button><i class="bx bx-trash text-red-600 confirm-del"></i></button>
                    </form>
                </div>
                @php
                $i=1;
                @endphp

                @foreach ($paperQuestion->paperQuestionParts as $paperQuestionPart)
                <div class="flex items-center w-full">
                    <div class="w-12"></div>
                    <div class="flex-1 text-left">{{ $roman->lowercase($i++) }}. &nbsp {{ $paperQuestionPart->question->statement }} </div>

                    <a href="{{ route('user.paper-question-parts.refresh', $paperQuestionPart) }}"
                        class="ml-2"><i class="bi-arrow-repeat text-cyan-600"></i></a>
                    <form
                        action="{{ route('user.paper.questions.destroy', [$paper, $paperQuestion]) }}"
                        method="post">
                        @csrf
                        @method('DELETE')
                        <button><i class="bx bx-trash text-red-600 confirm-del"></i></button>
                    </form>

                </div>
                @endforeach
                @endif <!-- end question_type 7 -->

                <!--Long: title + mulitpart + vertical -->
                @if ($paperQuestion->question_type == 8)
                <div class="flex items-center">
                    <div class="w-12 font-semibold"> Q. {{ $QNo++ }} </div>
                    <div class="flex-1 text-left font-semibold">{{ $paperQuestion->question_title }} </div>
                    <form
                        action="{{ route('user.paper.questions.destroy', [$paper, $paperQuestion]) }}"
                        method="post">
                        @csrf
                        @method('DELETE')
                        <button><i class="bx bx-trash text-red-600 confirm-del"></i></button>
                    </form>
                </div>
                @php
                $i=1;
                @endphp
                <div class="flex flex-wrap items-center w-full">
                    @foreach ($paperQuestion->paperQuestionParts as $paperQuestionPart)
                    <div class="w-12"></div>
                    <div class="text-left">{{ $roman->lowercase($i++) }}. &nbsp {{ $paperQuestionPart->question->statement }} </div>
                    @endforeach
                </div>
                @endif <!-- end question_type 8 -->


                @endforeach <!-- end iterating question -->
                @else <!-- in case no question exists -->

                <div class="grid place-items-center h-96">
                    <img src="{{ url('/images/guideline/add-q.png') }}" alt="" class="md:w-1/3">
                </div>
                @endif <!-- end if question exists -->
            </div>
        </div>
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