@extends('layouts.basic')

@section('header')
<x-headers.user page="New Paper" icon="<i class='bi bi-emoji-smile'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.user page='paper'></x-sidebars.user>
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

            <div class="grid p-4 place-items-center relative bg-teal-100">
                <!-- <img src="{{url('images/small/paper-0.png')}}" alt="paper" class="h-24"> -->
                <div class="flex flex-col text-center ">
                    <h2>{{ Auth::user()->profile?->institution }}</h2>
                    <h2>{{ $paper->title }} </h2>
                    <p>{{ $paper->book->name }} </p>
                    <p class="text-sm text-slate-600">Dated: {{ $paper->paper_date->format('d/m/Y') }}</p>

                    <a href="{{route('user.papers.edit', $paper)}}" class="absolute w-8 h-8 -bottom-4 left-[calc(50%-16px)] rounded-full btn-blue flex items-center justify-center"><i class="bx bx-pencil"></i></a>
                </div>
            </div>

            <form action="{{route('user.papers.chapters.store', $paper)}}" method='post' class="mt-6 w-full md:w-4/5 mx-auto" onsubmit="return validate(event)">
                @csrf
                <h2 class="mt-4">Which chapters would you like to consider?</h2>
                <div class="flex items-center space-x-2 mt-3">
                    <p class="text-red-600">Full Book</p>
                    <input type="checkbox" id='check_all' class="custom-input w-4 h-4 rounded">
                </div>
                <div class="mt-4">
                    <div class="grid text-sm">
                        @foreach($paper->book->chapters->sortBy('chapter_no') as $chapter)
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
                    <div class="flex justify-end my-5">
                        <button type="submit" class="btn-teal rounded py-2 px-4" @disabled($paper->book->chapters->count()==0)>Next <i class="bi-arrow-right"></i></button>
                    </div>
            </form>
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