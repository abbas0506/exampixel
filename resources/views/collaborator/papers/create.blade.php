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
$activeBook=$book;
@endphp

@section('body')
<div class="responsive-container">
    <div class="container">
        <div class="bread-crumb">
            <a href="{{url('/')}}">Home</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{ route('collaborator.papers.index') }}">Books</a>
            <i class="bx bx-chevron-right"></i>
            <div>{{ $book->name }}</div>
        </div>


        <div class="md:w-3/4 mx-auto">
            <!-- mid panel  -->
            <div class="md:col-span-2 lg:col-span-3">
                <form id='start-test-form' action="{{route('collaborator.papers.store')}}" method='post' onsubmit="return validate(event)">
                    @csrf
                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                    <div class="grid p-4 mt-6 border border-dashed rounded-lg">
                        <h2 class="text-green-800">{{ $book->name }} </h2>
                        <div class="flex justify-between gap-4 mt-2 ">

                            <div class="flex-1">
                                <label for="">Paper Title *</label>
                                <input type="text" name="title" value='' placeholder="Enter paper title" class="custom-input-borderless" required>
                            </div>

                            <div>
                                <label for="">Paper Date</label>
                                <input type="date" id='paper_date' name="paper_date" class="custom-input-borderless" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>

                    </div>

                    <!-- page message -->
                    @if($errors->any())
                    <x-message :errors='$errors'></x-message>
                    @else
                    <x-message></x-message>
                    @endif

                    <div class="flex items-center justify-between px-3 mt-6">
                        <div class="text-slate-600 text-sm">Please select chapter(s) for the paper</div>
                        <div class="flex items-center space-x-2">
                            <label for="check_all">Check All</label>
                            <input type="checkbox" id='check_all' class="custom-input w-4 h-4 rounded">
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="grid text-sm">
                            @foreach($book->chapters->sortBy('sr') as $chapter)
                            <div class="flex items-center odd:bg-slate-100 space-x-3 checkable-row">
                                <div class="flex flex-1 items-center justify-between space-x-2 pr-3">
                                    <label for='chapter{{$chapter->id}}' class="flex-1 text-sm text-slate-800 py-3 hover:cursor-pointer">{{ $chapter->sr}}. &nbsp {{ $chapter->title }} </label>
                                    <div class="text-base font-extrabold">
                                        <input type="checkbox" id='chapter{{$chapter->id}}' name='chapter_ids_array[]' class="custom-input w-4 h-4 rounded hidden" value="{{ $chapter->id }}">
                                        <i class="bx bx-check"></i>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="flex justify-center items-center my-8">
                            <button type="submit" class="btn-green rounded flex justify-center items-center" @disabled($book->chapters->count()==0)> Go Next & Add Qs.</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
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