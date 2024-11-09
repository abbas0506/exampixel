@extends('layouts.basic')

@section('header')
<x-headers.user page="Q. Paper" icon="<i class='bi bi-file-earmark-text'></i>"></x-headers.user>
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

            <div class="flex flex-row flex-wrap justify-between items-center gap-4 ">
                <div class="flex flex-row items-center gap-3">
                    <a href="{{ route('user.papers.simple-pdf.create', $paper) }}">
                        <img src="{{ url('images/small/pdf.png') }}" alt="paper" class="h-12 md:h-16">
                    </a>
                    <div class="flex flex-col">
                        <h2>{{ $paper->book->name }} </h2>
                        <div class="flex items-center space-x-3">
                            <label>{{ $paper->title }}</label>
                            <a href="{{ route('user.papers.edit', $paper) }}" class="btn-sky flex justify-center items-center rounded-full p-0 w-5 h-5"><i class="bx bx-pencil text-xs"></i></a>
                        </div>
                    </div>
                </div>
                <!-- show print button only if paper has some questions -->

                <div class="flex items-center space-x-3">
                    <a href="{{ route('user.papers.questionTypes.index', $paper) }}" class="flex w-12 h-12 items-center justify-center rounded-full bg-teal-200 hover:bg-teal-400">Q+</a>
                    @if ($paper->paperQuestions->count() > 0)
                    <div
                        class="flex w-12 h-12 items-center justify-center rounded-full bg-orange-100 hover:bg-orange-200">
                        <a href="{{ route('user.papers.latex-pdf.create', $paper) }}"><i class="bi-printer"></i></a>
                    </div>
                    @endif
                </div>

            </div>
            <div class="divider my-3"></div>

            @if ($paper->paperQuestions->count())
            <div class="flex flex-row justify-between items-center w-full">
                <label>Suggested Time: &nbsp {{ $paper->marks()*1.5 }}min</label>
                <label>Max marks: {{ $paper->marks() }}</label>
            </div>

            <div class="divider my-3"></div>

            <div class="overflow-x-auto mt-4">
                <table class="table-fixed w-full">
                    <thead>
                        <tr>
                            <th class="w-8"></th>
                            <th class="w-96"></th>
                            <th class="w-8"></th>
                            <th class="w-8"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($paper->paperQuestions as $paperQuestion)

                        <!-- MCQs -->
                        @if ($paperQuestion->question_type == 1)
                        <tr>
                            <td class="font-bold">Q.{{ $QNo++ }}</td>
                            <td class="text-left font-bold">{{ $paperQuestion->question_title }}</td>
                            <td>({{ $paperQuestion->compulsoryParts() }})</td>
                            <td>
                                <form
                                    action="{{ route('user.paper.questions.destroy', [$paper, $paperQuestion]) }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button><i class="bx bx-trash text-red-600 confirm-del"></i></button>
                                </form>
                            </td>
                        </tr>

                        @foreach ($paperQuestion->paperQuestionParts as $paperQuestionPart)
                        <tr>
                            <td>{{$roman->lowercase($loop->index+1)}}</td>
                            <td class="text-left">{{ $paperQuestionPart->question->statement }}</td>
                            <td></td>
                            <td>
                                <a href="{{ route('user.paper-question-parts.refresh', $paperQuestionPart) }}"><i class="bi-arrow-repeat text-green-600"></i></a>
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td class="text-left">
                                <div class="grid grid-cols-2">
                                    <div>a) {{ $paperQuestionPart->question->mcq->choice_a }}</div>
                                    <div>b) {{ $paperQuestionPart->question->mcq->choice_b }}</div>
                                    <div>c) {{ $paperQuestionPart->question->mcq->choice_c }}</div>
                                    <div>d) {{ $paperQuestionPart->question->mcq->choice_d }}</div>
                                </div>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endforeach
                        @endif

                        <!-- Short -->
                        @if ($paperQuestion->question_type == 2)
                        <tr>
                            <td class="font-bold">Q.{{ $QNo++ }}</td>
                            <td class="text-left font-bold">{{ $paperQuestion->question_title }}</td>
                            <td>({{ $paperQuestion->compulsoryParts()*2 }})</td>
                            <td>
                                <form
                                    action="{{ route('user.paper.questions.destroy', [$paper, $paperQuestion]) }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button><i class="bx bx-trash text-red-600 confirm-del"></i></button>
                                </form>
                            </td>
                        </tr>
                        @foreach ($paperQuestion->paperQuestionParts as $paperQuestionPart)
                        <tr>
                            <td>{{$roman->lowercase($loop->index+1)}}</td>
                            <td class="text-left">{{ $paperQuestionPart->question->statement }}</td>
                            <td></td>
                            <td>
                                <a href="{{ route('user.paper-question-parts.refresh', $paperQuestionPart) }}"><i class="bi-arrow-repeat text-green-600"></i></a>
                            </td>
                        </tr>
                        @endforeach
                        @endif

                        <!-- simple long with title -->
                        @if ($paperQuestion->question_type == 3)
                        <tr>
                            <td class="font-bold">Q.{{ $QNo++ }}</td>
                            <td class="text-left font-bold">{{ $paperQuestion->question_title }}</td>
                            <td>({{ $paperQuestion->paperQuestionParts()->first()->marks }})</td>
                            <td>
                                <form
                                    action="{{ route('user.paper.questions.destroy', [$paper, $paperQuestion]) }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button><i class="bx bx-trash text-red-600 confirm-del"></i></button>
                                </form>
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td class="text-left">{{$paperQuestion->paperQuestionParts()->first()->question->statement }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endif

                        <!-- long (simple) -->
                        @if ($paperQuestion->question_type == 4)
                        <tr>
                            <td>Q.{{ $QNo++ }}</td>
                            <td class="text-left">{{ $paperQuestion->paperQuestionParts()->first()->question->statement }}</td>
                            <td>({{ $paperQuestion->paperQuestionParts()->first()->marks }})</td>
                            <td>
                                <form
                                    action="{{ route('user.paper.questions.destroy', [$paper, $paperQuestion]) }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button><i class="bx bx-trash text-red-600 confirm-del"></i></button>
                                </form>
                            </td>
                        </tr>

                        @endif

                        <!-- long  (parts with or) -->
                        @if ($paperQuestion->question_type == 5)
                        @foreach ($paperQuestion->paperQuestionParts as $paperQuestionPart)
                        <tr>
                            <td>@if ($loop->first) Q.{{ $QNo++ }} @endif</td>
                            <td class="text-left">{{ $paperQuestionPart->question->statement }} @if(!$loop->last) <span class="font-bold">OR</span> @endif</td>
                            <td> ({{ $paperQuestion->paperQuestionParts()->first()->marks }}) </td>
                            <td>
                                @if($loop->first)
                                <form
                                    action="{{ route('user.paper.questions.destroy', [$paper, $paperQuestion]) }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button><i class="bx bx-trash text-red-600 confirm-del"></i></button>
                                </form>
                                @endif
                                <a href="{{ route('user.paper-question-parts.refresh', $paperQuestionPart) }}"><i class="bi-arrow-repeat text-green-600"></i></a>
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td>
                                <div class="flex items-center">
                                    <a href="{{ route('user.paper-question.extensions.create', $paperQuestion) }}" class="flex justify-center items-center w-6 h-6 rounded-full bg-blue-600"><i class="bi-plus text-white"></i></a>
                                    &nbsp;<label for="">(add another part)</label>
                                </div>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endif

                        <!-- Long: mendatory parts -->
                        @if ($paperQuestion->question_type == 6)
                        @php
                        $alphabets = range('a', 'z');
                        @endphp
                        @foreach ($paperQuestion->paperQuestionParts as $paperQuestionPart)
                        <tr>
                            <td>@if ($loop->first) Q.{{ $QNo++ }} @endif</td>
                            <td class="text-left">{{ $alphabets[$loop->index] }}).{{ $paperQuestionPart->question->statement }}</td>
                            <td>({{ $paperQuestionPart->marks }})</td>
                            <td>
                                @if($loop->first)
                                <form
                                    action="{{ route('user.paper.questions.destroy', [$paper, $paperQuestion]) }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button><i class="bx bx-trash text-red-600 confirm-del"></i></button>
                                </form>
                                @endif
                                <a href="{{ route('user.paper-question-parts.refresh', $paperQuestionPart) }}"><i class="bi-arrow-repeat text-green-600"></i></a>
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td>
                                <div class="flex items-center">
                                    <a href="{{ route('user.paper-question.extensions.create', $paperQuestion) }}" class="flex justify-center items-center w-6 h-6 rounded-full bg-blue-600"><i class="bi-plus text-white"></i></a>
                                    &nbsp;<label for="">(add another part)</label>
                                </div>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endif

                        <!--Long: title + mulitpart + vertical -->
                        @if ($paperQuestion->question_type == 7)
                        <tr>
                            <td class="font-bold">Q.{{ $QNo++ }}</td>
                            <td class="text-left font-bold">{{ $paperQuestion->question_title }}</td>
                            <td>()</td>
                            <td>
                                <form
                                    action="{{ route('user.paper.questions.destroy', [$paper, $paperQuestion]) }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button><i class="bx bx-trash text-red-600 confirm-del"></i></button>
                                </form>
                            </td>
                        </tr>
                        @foreach ($paperQuestion->paperQuestionParts as $paperQuestionPart)
                        <tr>
                            <td>{{$roman->lowercase($loop->index+1)}}</td>
                            <td class="text-left">{{ $paperQuestionPart->question->statement }}</td>
                            <td></td>
                            <td>
                                <a href="{{ route('user.paper-question-parts.refresh', $paperQuestionPart) }}"><i class="bi-arrow-repeat text-green-600"></i></a>
                            </td>
                        </tr>
                        @endforeach
                        @endif

                        <!--Long: title + mulitpart + horizontal -->
                        @if ($paperQuestion->question_type == 8)
                        <tr>
                            <td class="font-bold">Q.{{ $QNo++ }}</td>
                            <td class="text-left font-bold">{{ $paperQuestion->question_title }}</td>
                            <td>()</td>
                            <td>
                                <form
                                    action="{{ route('user.paper.questions.destroy', [$paper, $paperQuestion]) }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button><i class="bx bx-trash text-red-600 confirm-del"></i></button>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="text-left">
                                @foreach ($paperQuestion->paperQuestionParts as $paperQuestionPart)
                                {{$roman->lowercase($loop->index+1)}}) {{ $paperQuestionPart->question->statement }} <span> </span>
                                @endforeach
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endif

                        <!--Long: poetry -->
                        @if ($paperQuestion->question_type == 'stanza')
                        <tr>
                            <td class="font-bold">Q.{{ $QNo++ }}</td>
                            <td class="text-left font-bold">{{ $paperQuestion->question_title }}</td>
                            <td>({{$paperQuestion->paperQuestionParts->first()->marks}})</td>
                            <td>
                                <form
                                    action="{{ route('user.paper.questions.destroy', [$paper, $paperQuestion]) }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button><i class="bx bx-trash text-red-600 confirm-del"></i></button>
                                </form>
                            </td>
                        </tr>
                        @foreach ($paperQuestion->paperQuestionParts->first()->question->paraphrasings as $stanza)
                        <tr>
                            <td></td>
                            <td class="text-left">{{ $stanza->poetry_line }}</td>
                            <td></td>
                            <td></td>

                        </tr>
                        @endforeach
                        @endif

                        <!--Long: comprehension -->
                        @if ($paperQuestion->question_type == 'comprehension')
                        <tr>
                            <td class="font-bold">Q.{{ $QNo++ }}</td>
                            <td class="text-left font-bold">{{ $paperQuestion->question_title }}</td>
                            <td>({{$paperQuestion->paperQuestionParts->first()->marks}})</td>
                            <td>
                                <form
                                    action="{{ route('user.paper.questions.destroy', [$paper, $paperQuestion]) }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button><i class="bx bx-trash text-red-600 confirm-del"></i></button>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="text-left">{{ $paperQuestion->paperQuestionParts->first()->question->statement }}</td>
                            <td></td>
                            <td></td>
                        </tr>

                        @foreach ($paperQuestion->paperQuestionParts->first()->question->comprehensions as $comprehension)
                        <tr>
                            <td></td>
                            <td class="text-left">{{ $comprehension->sub_question }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endforeach
                        @endif


                        @endforeach <!-- end iterating questions -->

                    </tbody>
                </table>
            </div>
            @else
            <!-- paper has no question -->
            <div class="grid place-items-center h-64">
                <img src="{{ url('/images/guideline/add-q.png') }}" alt="add-q" class="w-64">
            </div>

            @endif <!-- end if paper has questions -->

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