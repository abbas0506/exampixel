@extends('layouts.basic')

@section('header')
<x-headers.user page="Welcome back!" icon="<i class='bi bi-emoji-smile'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.teacher page='paper'></x-sidebars.teacher>
@endsection

@section('body')
<div class="responsive-container">
    <div class="container">
        <div class="flex flex-row justify-between items-center">
            <div class="bread-crumb">
                <a href="{{ url('/') }}">Home</a>
                <div>/</div>
                <div>New Paper</div>
                <div>/</div>
                <div>Chapters</div>
            </div>
        </div>


        <div class="content-section rounded-lg mt-2">
            <!-- page message -->
            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            <form action="{{route('teacher.papers.store')}}" method='post' onsubmit="return validate(event)">
                @csrf

                <div class="grid md:grid-cols-2 items-end gap-4">
                    <div class="flex flex-col md:flex-row gap-3 items-center md:items-end">
                        <img src="{{url('images/small/paper-0.png')}}" alt="paper" class="h-24">
                        <div class="flex flex-col">
                            <div class="flex text-left space-x-3">
                                <h2>{{ $book->name }} </h2>
                                <a href="{{route('teacher.papers.index')}}" class="btn-blue rounded-lg text-xs"><i class="bx bx-pencil"></i></a>
                            </div>
                            <p class="text-slate-600">Chaper selection</p>
                        </div>
                    </div>

                </div>

                <div class="leading-relaxed mt-6 text-left bg-teal-800 text-slate-300 p-5">
                    <ul class="list-disc list-inline text-left text-sm pl-4">
                        <li>You may select multiple chapters</li>
                        <li>After selecting chapters, click on start now button</li>
                    </ul>
                </div>

                <div class="flex flex-col md:flex-row gap-x-4 gap-y-2 p-6 border rounded-b bg-teal-50">
                    <div class="md:w-2/3">
                        <label for="">Paper Title</label>
                        <input type="text" name="title" value='Sample Paper' placeholder="Paper Title" class="custom-input">

                    </div>
                    <div class="md:w-1/3">
                        <div class="flex flex-col items-start md:items-end">
                            <div class="grid grid-cols-1 gap-3 md:ml-8">
                                <div class="flex items-center space-x-2">
                                    <input type="checkbox" name="exercise_only" class="custom-input w-5 h-5">
                                    <label>Questions form exercise only</label>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <input type="checkbox" name="frequent_only" class="custom-input w-5 h-5">
                                    <label>Most frequent questions only</label>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>



                <div class="flex items-center justify-between px-3 mt-6">
                    <div class="text-slate-600 text-sm">Please select chapter(s) for the paper</div>
                    <div class="flex items-center space-x-2">
                        <label for="check_all">Check All</label>
                        <input type="checkbox" id='check_all' class="custom-input w-4 h-4 rounded">
                    </div>
                </div>
                <div class="mt-4">
                    <div class="grid text-sm">
                        @foreach($book->chapters->sortBy('chapter_no') as $chapter)
                        <div class="flex items-center odd:bg-slate-100 space-x-3 checkable-row">
                            <div class="flex flex-1 items-center justify-between space-x-2 pr-3">
                                <label for='chapter{{$chapter->id}}' class="flex-1 text-sm text-slate-800 py-3 hover:cursor-pointer">{{ $chapter->chapter_no}}. &nbsp {{ $chapter->name }} </label>
                                <div class="text-base font-extrabold">
                                    <input type="checkbox" id='chapter{{$chapter->id}}' name='chapter_ids_array[]' class="custom-input w-4 h-4 rounded hidden" value="{{ $chapter->id }}">
                                    <i class="bx bx-check"></i>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="divider my-5"></div>
                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                    <div class="flex justify-end mt-5">
                        <button type="submit" class="btn-teal rounded py-2 px-4" @disabled($book->chapters->count()==0)>Next <i class="bi-arrow-right"></i></button>
                    </div>

                    <div class="divider my-5"></div>



            </form>

        </div>
    </div>

    @endsection

    @section('script')
    <script type="module">
        $('.checkable-row input').change(function() {
            if ($(this).prop('checked'))
                $(this).parents('.checkable-row').addClass('active')
            else
                $(this).parents('.checkable-row').removeClass('active')
        })

        $('#check_all').change(function() {
            if ($(this).prop('checked')) {
                $('.checkable-row input').each(function() {
                    $(this).prop('checked', true)
                    $(this).parents('.checkable-row').addClass('active')
                })
            } else {
                $('.checkable-row input').each(function() {
                    $(this).prop('checked', false)
                    $(this).parents('.checkable-row').removeClass('active')
                })
            }
        })
    </script>
    @endsection