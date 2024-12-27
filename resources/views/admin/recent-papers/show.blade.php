@extends('layouts.basic')

@section('header')
<x-headers.user page="Q. Paper" icon="<i class='bi bi-file-earmark-text'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.admin page='paper'></x-sidebars.admin>
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

            <div class="flex flex-row flex-wrap justify-between items-center gap-4 relative">
                <div class="flex flex-row items-center gap-3">
                    <a href="{{ route('user.papers.simple-pdf.create', $paper) }}">
                        <img src="{{ url('images/small/pdf.png') }}" alt="paper" class="w-12">
                    </a>
                    <div class="flex flex-col">
                        <h2>{{ $paper->book->name }} </h2>
                        <label>{{ $paper->title }}</label>
                    </div>
                </div>
                <div class="text-center">
                    <div><i class="bi-calendar4-event text-xl"></i></div>
                    <label for="">{{ $paper->paper_date->format('d/m/Y') }}</label>
                </div>

            </div>

            <!-- show print button only if paper has some questions -->
            <div class="fixed left-0 md:pl-60 bottom-0 bg-teal-50 flex justify-between items-center w-full px-4 py-2 opacity-90">
                <div class="flex flex-col flex-wrap gap-x-2">
                    <h3>{{ $paper->book->name }}</h3>
                    <label> Step 3/4 ( {{ $paper->paperQuestions->sum('marks') }} marks )</label>
                </div>
            </div>

            <div class="divider my-3"></div>

            @if ($paper->paperQuestions->count())
            <div class="flex flex-row justify-between items-center w-full">
                <label>Suggested Time: &nbsp {{ $paper->suggestedTime() }}</label>
                <label>Max marks: {{ $paper->paperQuestions->sum('marks') }}</label>
            </div>

            <div class="divider my-3"></div>

            <div class="overflow-x-auto mt-4">
                <table class="table-fixed w-full xs md:sm">
                    <thead>
                        <tr>
                            <th class="w-8"></th>
                            <th class="w-96"></th>
                            <th class="w-8"></th>
                            <th class="w-8"></th>
                            <th class="w-8"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($paper->paperQuestions as $paperQuestion)

                        <!-- MCQs -->
                        @if ($paperQuestion->type_name == 'mcq')
                        <tr>
                            <td class="font-bold">Q.{{ $QNo++ }}</td>
                            <td class="text-left font-bold">{{ $paperQuestion->question_title }}</td>
                            <td>({{ $paperQuestion->marks }})</td>
                        </tr>

                        @foreach ($paperQuestion->paperQuestionParts as $paperQuestionPart)
                        <tr>
                            <td>{{$roman->lowercase($loop->index+1)}}</td>
                            <td class="text-left">{{ $paperQuestionPart->question->statement }}</td>
                            <td></td>
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
                        </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td>
                                <div class="flex items-center">
                                    <a href="{{ route('user.paper-question.type.extensions.create', [$paperQuestion, $paperQuestion->paperQuestionParts->first()->question->type]) }}" class="flex justify-center items-center w-6 h-6 rounded-full bg-blue-600"><i class="bi-plus text-white"></i></a>
                                    &nbsp;<label for="">(append another question)</label>
                                </div>
                            </td>
                            <td></td>
                        </tr>
                        @endif

                        <!-- partial -->
                        @if ($paperQuestion->type_name == 'partial' || $paperQuestion->type_name == 'partial-x')
                        <tr>
                            <td class="font-bold">Q.{{ $QNo++ }}</td>
                            <td class="text-left font-bold">{{ $paperQuestion->question_title }}</td>
                            <td> ({{ $paperQuestion->marks }})</td>
                        </tr>
                        @foreach ($paperQuestion->paperQuestionParts as $paperQuestionPart)
                        <tr>
                            <td>{{$roman->lowercase($loop->index+1)}}</td>
                            <td class="text-left">{{ $paperQuestionPart->question->statement }}</td>
                            <td></td>
                        </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td>
                                <div class="flex items-center">
                                    <a href="{{ route('user.paper-question.type.extensions.create', [$paperQuestion, $paperQuestion->paperQuestionParts->first()->question->type]) }}" class="flex justify-center items-center w-6 h-6 rounded-full bg-blue-600"><i class="bi-plus text-white"></i></a>
                                    &nbsp;<label for="">(append another question)</label>
                                </div>
                            </td>
                            <td></td>
                        </tr>
                        @endif

                        <!-- simple question -->
                        @if ($paperQuestion->type_name == 'simple')
                        <tr>
                            <td class="font-bold">Q.{{ $QNo++ }}</td>
                            <td class="text-left font-bold">{{ $paperQuestion->question_title }}</td>
                            <td>({{ $paperQuestion->marks }})</td>
                        </tr>

                        <tr>
                            <td></td>
                            <td class="text-left">{{$paperQuestion->paperQuestionParts()->first()->question->statement }}</td>
                            <td></td>
                        </tr>

                        <tr>
                            <td></td>
                            <td>
                                <div class="flex items-center">
                                    <a href="{{ route('user.paper-question.type.extensions.index', [$paper, $paperQuestion]) }}" class="flex justify-center items-center w-6 h-6 rounded-full bg-blue-600"><i class="bi-plus text-white"></i></a>
                                    <!-- <a href="{{ route('user.paper-question.type.extensions.index', [$paperQuestion, $paperQuestion->paperQuestionParts->first()->question->type]) }}" class="flex justify-center items-center w-6 h-6 rounded-full bg-blue-600"><i class="bi-plus text-white"></i></a> -->
                                    &nbsp;<label for="">(append another question)</label>
                                </div>
                            </td>
                            <td></td>
                        </tr>
                        @endif

                        <!-- simple-or -->
                        @if ($paperQuestion->type_name == 'simple-or')
                        <tr>
                            <td class="font-bold">Q.{{ $QNo++ }}</td>
                            <td class="text-left font-bold">{{ $paperQuestion->question_title }}</td>
                            <td>({{ $paperQuestion->marks }})</td>
                        </tr>
                        @foreach ($paperQuestion->paperQuestionParts as $paperQuestionPart)
                        <tr>
                            <td></td>
                            <td class="text-left">
                                {{ $paperQuestionPart->question->statement }} @if(!$loop->last) <span class="font-bold">OR</span> @endif
                            </td>
                            <td></td>
                        </tr>
                        @endforeach
                        @endif

                        <!-- simple-and -->
                        @if ($paperQuestion->type_name == 'simple-and')
                        @php
                        $alphabets = range('a', 'z');
                        @endphp

                        <tr>
                            <td class="font-bold">Q.{{ $QNo++ }}</td>
                            <td class="text-left font-bold">{{ $paperQuestion->question_title }}</td>
                            <td>({{ $paperQuestion->marks }})</td>
                        </tr>

                        @foreach ($paperQuestion->paperQuestionParts as $paperQuestionPart)
                        <tr>
                            <td>{{ $alphabets[$loop->index] }})</td>
                            <td class="text-left">
                                {{ $paperQuestionPart->question->statement }}
                            </td>
                            <td>{{ $paperQuestionPart->marks }}</td>
                        </tr>
                        @endforeach
                        @endif

                        <!-- poetry lines -->
                        @if($paperQuestion->type_name=='stanza')

                        @endif

                        <!-- comprehension -->
                        @if($paperQuestion->type_name=='comprehension')

                        <tr>
                            <td class="font-bold">Q.{{ $QNo++ }}</td>
                            <td class="text-left font-bold">{{ $paperQuestion->question_title }}</td>
                            <td>({{ $paperQuestion->marks }})</td>
                        </tr>

                        <tr>
                            <td></td>
                            <td class="text-left">{{$paperQuestion->question->statement }}</td>
                            <td></td>
                        </tr>
                        @endif
                        @endforeach <!-- end iterating questions -->

                    </tbody>
                </table>
            </div>
            @else
            <!-- paper has no question -->
            <div class="flex items-center md:w-4/5 mx-auto mt-8  bg-teal-50 border border-teal-100 p-4 rounded-lg font-semibold">
                <p>No Question Found</p>
            </div>
            @endif <!-- end if paper has questions -->

        </div>
    </div>
</div>
<!-- bottom marging -->
<div class="h-16"></div>

@endsection