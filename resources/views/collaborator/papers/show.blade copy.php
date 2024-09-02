@extends('layouts.basic')
@section('header')
<x-headers.user page="Paper Creation" icon="<i class='bi bi-files'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.collaborator page='paper'></x-sidebars.collaborator>
@endsection

@php
$colors=config('globals.colors');
$i=0;
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


            <div data-modal-target="default-modal" data-modal-toggle="default-modal" class="flex justify-center items-center my-8">
                <button type="submit" class="btn-green flex justify-center items-center"> Add Question(s) to Paper</button>
            </div>
            <!-- show print button only if paper has some questions -->


            <!-- page message -->
            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            <!-- modal -->
            <div id="default-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">

                <form action="{{ route('collaborator.paper.questions.store',$paper) }}" method="post">
                    @csrf
                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-slate-100 rounded-lg shadow dark:bg-gray-700">
                            <!-- Modal header -->
                            <input type="hidden" id='book_id' value="{{ $book->id }}">
                            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Add Question
                                </h3>
                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                                    <i class="bi-x"></i>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="p-4 md:p-8 h-80 overflow-y-auto">
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 md:gap-x-16 text-left">
                                    <div class="">
                                        <label>Question Type</label>
                                        <select name="type_id" id="type_id" class="custom-input-borderless text-sm">
                                            @foreach($types as $type)
                                            <option value="{{ $type->id }}" @selected(session('type_id')==$type->id)> {{ $type->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    @if($book->subtype_mappings->count())
                                    <div class="">
                                        <label>Sub Type</label>
                                        <select name="subtype_id" id="subtype_id" class="custom-input-borderless text-sm">
                                            @foreach($book->subtypes(1) as $subtype)
                                            <option value="{{ $subtype->id }}">{{ $subtype->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endif
                                    <div class="" id='display_style_cover'>
                                        <label>Display Format</label>
                                        <select name="display_style" id="display_style" class="custom-input-borderless text-sm">
                                            <option value="compact">Compact Question</option>
                                            <option value="vertical">Vertical List</option>
                                            <option value="horizontal">Horizontal List </option>
                                            <option value="alt">OR Separated Alternative</option>
                                        </select>
                                    </div>
                                    <div class="grid" id='marks_cover'>
                                        <label>Marks (each)</label>
                                        <input type="number" name="marks" class="custom-input-borderless" value="1">
                                    </div>
                                    <div class="">
                                        <label>Exercise Ratio</label>
                                        <select name="exercise_ratio" id="display_style" class="custom-input-borderless text-sm">
                                            <option value="0">0 %</option>
                                            <option value="10">10 %</option>
                                            <option value="20">20 %</option>
                                            <option value="30">30 %</option>
                                            <option value="50">50 %</option>
                                            <option value="75">75 %</option>
                                            <option value="100">100 %</option>
                                        </select>
                                    </div>
                                    <div class="">
                                        <label>Conceptual Ratio</label>
                                        <select name="conceptual_ratio" class="custom-input-borderless text-sm">
                                            <option value="0">0 %</option>
                                            <option value="10">10 %</option>
                                            <option value="20">20 %</option>
                                            <option value="30">30 %</option>
                                            <option value="50">50 %</option>
                                            <option value="75">75 %</option>
                                            <option value="100">100 %</option>
                                        </select>
                                    </div>
                                    <div class="">
                                        <label>Importance Level</label>
                                        <input type="number" name="frequency" class="custom-input-borderless" value="1">
                                    </div>


                                    <div class="col-span-full">
                                        <label>Question Title</label>
                                        <input type="text" name="question_title" class="custom-input-borderless" placeholder="Attempt any three following questions">
                                    </div>

                                    <div class="grid col-span-full text-sm overflow-auto">
                                        @foreach($selectedChapters->sortBy('chapter_no') as $chapter)
                                        <div class="flex items-center odd:bg-transparent px-3">
                                            <label for='chapter{{$chapter->id}}' class="flex-1 text-sm text-slate-800 py-3 hover:cursor-pointer">{{ $chapter->chapter_no}}. &nbsp {{ $chapter->name }} </label>
                                            <input type="hidden" name='chapter_ids_array[]' value="{{$chapter->id}}">
                                            <input type="number" name='parts_count_array[]' autocomplete="off" class="parts-count custom-input-borderless w-16 h-8 text-center px-0" min='0' value="0" oninput="syncNumOfParts()">

                                        </div>
                                        @endforeach
                                    </div>

                                </div>

                            </div>
                            <!-- Modal footer -->

                            <div class="flex flex-wrap justify-center items-center p-4 md:p-5 gap-6 border-t border-gray-200 rounded-b dark:border-gray-600">

                                <div>
                                    <label>Total Parts</label>
                                    <input type="number" id="parts_total" class="custom-input-borderless w-16 h-8 text-center font-bold" value="0" disabled>
                                </div>
                                <div> <label>Choices</label>
                                    <input type="number" name="choices" class="custom-input-borderless w-16 h-8 text-center font-bold text-red-600" value="0">
                                </div>
                                <div>
                                    <button data-modal-hide="default-modal" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add Q.</button>
                                </div>
                            </div>

                        </div>

                    </div>
                </form>
            </div>

            @php
            $roman=new Roman;
            $questionSr=1;
            @endphp
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
                        <form action="" method="post">
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

            @if($paperQuestion->display_style=='vertical')

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
            @elseif($paperQuestion->display_style=='horizontal')
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
            @elseif($paperQuestion->display_style=='compact')
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
        @endsection

        @section('script')
        <script type="module">
            $('document').ready(function() {

                // initialize controls
                if ($('#type_id').val() == 1) {
                    $('#display_style_cover').hide();
                    $('#marks_cover').hide();
                }

                $('#type_id').change(function() {
                    // objetive selected
                    if ($(this).val() == 1) {
                        $('#display_style_cover').hide();
                        $('#marks_cover').hide();
                        $('.questionable').hide()
                        $('#mcqCover').show()
                        $('')
                    } else {
                        $('#display_style_cover').show();
                        $('#marks_cover').show();
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


                });

                $('.parts-count').click(function() {
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


            })
        </script>
        @endsection