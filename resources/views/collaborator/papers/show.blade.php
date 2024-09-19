@extends('layouts.basic')
@section('header')
<x-headers.user page="Paper Creation" icon="<i class='bi bi-files'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.collaborator page='paper'></x-sidebars.collaborator>
@endsection

@php
$colors=config('globals.colors');
$roman=new Roman;
$questionSr=1;
@endphp

@section('body')
<div class="responsive-container">
    <div class="container">
        <div class="bread-crumb">
            <a href="{{url('/')}}">Home</a>
            <i class="bx bx-chevron-right"></i>
            <div>Papers</div>
        </div>

        <div class="w-full md:w-4/5 mx-auto text-center mt-12 px-5">

            <div class="px-6 py-2 w-full border border-dashed border-slate-200 mt-6 relative">
                <h2 class="text-center">{{$paper->title}}</h2>
                <p class="text-slate-600 text-sm text-center">{{$paper->paper_date->format('d/m/Y')}}</p>
                <div class="flex flex-wrap flex-row justify-evenly mt-5">
                    <div class="flex items-center space-x-2">
                        <label for="">Paper Date</label>
                        <h3>{{$paper->paper_date->format('M d, Y')}}</h3>
                    </div>
                    <div class="flex items-center space-x-2">
                        <label for="">Marks</label>
                        <h3>25</h3>
                    </div>
                    <div class="flex items-center space-x-2">
                        <label for="">Duration</label>
                        <h3>{{$paper->duration}}</h3>
                    </div>
                </div>
                <a href="{{route('collaborator.papers.edit',$paper)}}" class="absolute top-2 right-2 btn-sky flex justify-center items-center rounded-full p-0 w-5 h-5"><i class="bx bx-pencil text-xs"></i></a>
            </div>

            <div class="flex justify-center gap-4 my-6">
                <a href="{{ route('collaborator.paper.type.questions.create',[$paper, 1]) }}" class="btn btn-sky rounded text-sm">MCQs <i class="bi bi-plus-circle ml-1"></i></a>
                <a href="{{ route('collaborator.paper.type.questions.create',[$paper, 2]) }}" class="btn btn-teal rounded text-sm">Short <i class="bi bi-plus-circle  ml-1"></i></a>
                <a href="{{ route('collaborator.paper.type.questions.create',[$paper, 3]) }}" class="btn btn-green rounded text-sm">Long <i class="bi bi-plus-circle  ml-1"></i></a>
                <a href="{{ route('collaborator.paper.pdf.create',$paper) }}" target="_blank" class="btn btn-red rounded text-sm" @if($paper->paperQuestions->count()==0) hidden @endif>Print <i class="bi bi-printer  ml-1"></i></a>
            </div>

            <!-- page message -->
            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif


            <!-- display paper question and their details -->
            <!-- MCQs -->
            @foreach($paper->paperQuestions->sortBy('type_id') as $paperQuestion)
            @php
            $i=1;
            @endphp
            <!-- mcqs -->
            @if($paperQuestion->type_id == 1)
            <div class="question mcq">
                <div class="head">
                    <div class="sr">Q.{{ $questionSr++ }}</div>
                    <h2>{{ $paperQuestion->question_title }}</h2>
                    <div class="action border border-green-200 rounded bg-green-50 mx-2">
                        <a modal-id='{{$paperQuestion->id}}' class="show-modal text-cyan-600"><i class="bx bx-pencil"></i></a>
                        <a href=""><i class="bi-arrow-repeat"></i></a>
                        <form action="{{ route('collaborator.paper.questions.destroy',[$paper, $paperQuestion]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button><i class="bx bx-trash text-red-600 show-confirm"></i></button>
                        </form>
                    </div>
                </div>
                <div class="body">
                    @foreach($paperQuestion->paperQuestionParts as $part)
                    <div class="sub">
                        <div class="sr">{{$roman->lowercase($i++)}}</div>
                        <div class="statement">{{$part->question->statement}}</div>
                        <div class="action">
                            <a href=""><i class="bi-arrow-repeat"></i></a>
                            <form action="" method="post">
                                @csrf
                                @method('DELETE')
                                <button><i class="bx bx-x text-red-600 show-confirm"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="choices">
                        <div class="choice">
                            <div class="sr">a.</div>
                            <div class="desc">{{$part->question->mcq->choice_a}}</div>
                        </div>
                        <div class="choice">
                            <div class="sr">b.</div>
                            <div class="desc">{{$part->question->mcq->choice_b}}</div>
                        </div>
                        <div class="choice">
                            <div class="sr">c.</div>
                            <div class="desc">{{$part->question->mcq->choice_c}}</div>
                        </div>
                        <div class="choice">
                            <div class="sr">d.</div>
                            <div class="desc">{{$part->question->mcq->choice_d}}</div>
                        </div>

                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <!-- subjective questions -->

            @if($paperQuestion->question_nature=='vertical')

            <div class="flex items-center">
                <div class="w-12">Q. {{ $questionSr++ }}</div>
                <div class="flex-1 text-left">{{ $paperQuestion->question_title }}</div>
            </div>

            @php $i=1; @endphp
            @foreach($paperQuestion->paperQuestionParts as $part)

            <div class="flex items-center">
                <div class="w-12">{{Str::lower($roman->lowercase($i++))}}</div>
                <div class="flex-1 text-left">{{$part->question->statement}}</div>
                <div class="flex items-center space-x-3">
                    <a href="#"><i class="bi-arrow-repeat text-cyan-600"></i></a>
                    <form id='formDel{{$part->id}}' action="" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit"><i class="bx bx-x text-red-600 show-confirm"></i></button>
                    </form>
                </div>
            </div>
            @endforeach
            @elseif($paperQuestion->question_nature=='horizontal')
            <div class="flex items-center">
                <div class="w-12">Q. {{ $questionSr++ }}</div>
                <div class="flex-1 text-left">{{ $paperQuestion->question_title }}</div>
            </div>

            @php $i=1; @endphp
            <div class="flex flex-wrap items-center gap-x-8 gapy-3">
                @foreach($paperQuestion->paperQuestionParts as $part)
                <div class="w-12">{{Str::lower($roman->lowercase($i++))}}</div>
                <div class="text-left">{{$part->question->statement}}</div>
                <!-- <div class="flex items-center space-x-3">
                    <a href="#"><i class="bi-arrow-repeat text-cyan-600"></i></a>
                    <form id='formDel{{$part->id}}' action="" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit"><i class="bx bx-x text-red-600 show-confirm"></i></button>
                    </form>
                </div> -->

                @endforeach
            </div>
            @elseif($paperQuestion->question_nature=='compact')
            <div class="flex items-center">
                <div class="w-12">Q. {{ $questionSr++ }}</div>
                <div class="flex-1 text-left">{{ $paperQuestion->paperQuestionParts->first()->question->statement }}</div>

            </div>
            @else
            <!-- Or alternatives -->
            @foreach($paperQuestion->paperQuestionParts as $part)
            <div class="flex items-center">
                @if($loop->first)
                <div class="w-12">Q. {{ $questionSr++ }}</div>
                <div class="text-left"> {{ $part->question->statement }}</div>
                <div class="ml-2">OR</div>
                @elseif($loop->last)
                <div class="w-12"></div>
                <div class="text-left"> {{ $part->question->statement }}</div>
                @else
                <div class="w-12"></div>
                <div class="text-left"> {{ $part->question->statement }}</div>
                <div class="ml-2">OR</div>
                @endif
            </div>
            @endforeach
            @endif

            @endif

            @endforeach


        </div>
    </div>



    @endsection

    @section('script')
    <script type="module">
        $('document').ready(function() {

            $('.show-confirm').click(function(event) {
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


            $('.parts-count').click(function() {
                alert();
                $(this).select();
            })
            $('#choices').click(function() {
                $(this).select();
            })

            $('.parts-count').bind('keyup mouseup', function() {
                var sumOfParts = 0;
                $('.parts-count').each(function() {
                    sumOfParts += parseInt($(this).val());

                });

                sumOfParts = parseInt(sumOfParts);
                $('#parts_total').val(sumOfParts);
                // $('#choices').val(sumOfParts);
            });
        });
    </script>
    @endsection