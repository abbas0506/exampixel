@extends('layouts.basic')
@section('header')
<x-headers.user page="Approve Qs." icon="<i class='bi bi-bookmark-check'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.collaborator page='approval'></x-sidebars.collaborator>
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
            <div>Approval</div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- mid panel  -->
            <div class="md:col-span-2 order-last md:order-first">

                <!-- page message -->
                @if($errors->any())
                <x-message :errors='$errors'></x-message>
                @else
                <x-message></x-message>
                @endif

                <h2 class="text-green-800">{{ $activeBook->name }}</h2>
                <!-- <div class="divider my-5"></div> -->
                <div class="flex flex-wrap items-center gap-3">
                    <h3>Chapters</h3>
                    @foreach($activeBook->chapters->sortBy('sr') as $chapter)
                    @if($activeChapter->id == $chapter->id)
                    <a href="#" class="flex items-center justify-center text-xs py-3 w-8 h-8 space-x-3 rounded-full bg-green-800 text-slate-50">
                        {{ $chapter->sr }}
                    </a>
                    @else
                    <a href="{{ route('collaborator.chapter.approvables.index', $chapter) }}" class="flex items-center justify-center text-xs py-3 w-8 h-8 space-x-3 rounded-full bg-slate-100 text-slate-600">
                        {{ $chapter->sr }}
                    </a>
                    @endif
                    @endforeach

                </div>

                <div class="divider my-5"></div>
                <div class="md:w-1/2 relative">
                    <input type="text" id='searchby' placeholder="Search ..." class="custom-search w-full" oninput="search(event)">
                    <i class="bx bx-search absolute top-2 right-2"></i>
                </div>
                <div class="overflow-x-auto mt-4">
                    <table class="table-fixed borderless w-full">
                        <thead>
                            <tr class="">
                                <th class="w-8">Sr</th>
                                <th class='w-60 text-left'>Question</th>
                                <th class='w-20'>Type</th>
                                <th class='w-6'>...</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $sr=1;
                            @endphp
                            @foreach($activeChapter->questions->whereNull('approver_id')->sortBy('type_id') as $question) <tr class="tr">
                                <td>{{$sr++}}</td>
                                <td class=" text-left">{{ $question->statement }}</td>
                                <td class="">{{ $question->type->name }}</td>
                                <td><a href="{{route('collaborator.approvables.show',$question)}}" class="text-orange-600"><i class="bx bx-show-alt"></i></a></td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>
            <!-- right panel -->
            <div>
                <div class="p-4 border rounded-lg">
                    <div class="flex items-center justify-between">
                        <h2 class="text-sm">Books <i class="bx bx-book"></i></h2>
                        <div class="flex items-center justify-center rounded-full px-2 bg-green-200  text-xs font-semibold"> </i></div>
                    </div>
                    <div class="grid divide-y mt-3">
                        @foreach($books->sortBy('display_order') as $book)
                        <a href="{{ route('collaborator.book.approvables.index', $book) }}" class="flex items-center text-xs py-3">
                            <div class="flex justify-center items-center w-8 h-8 rounded bg-{{ $colors[$i % 5] }}-100 text-{{ $colors[$i % 5] }}-600"><i class="bx bx-book text-sm"></i></div>
                            <div class="flex justify-between items-center flex-1 pl-3 gap-y-1">
                                <div>
                                    <div class="font-semibold">{{ $book->name }}</div>
                                    <div class="flex space-x-5 text-slate-600 text-[10px]">
                                        <div> <i class="bi-question-circle"></i> {{ $book->questions->count() }}</div>
                                        <div> <i class="bi-layers"></i> {{ $book->chapters->count() }} chapters</div>
                                        <div class="">
                                            @if($book->questions()->today()->count()>0)
                                            {{ $book->questions()->today()->count() }}<i class="bi-arrow-up"></i>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @if($activeBook->id==$book->id)
                                <div class="w-2 h-2  bg-red-600 rounded-full">
                                </div>
                                @endif
                            </div>
                        </a>
                        @php $i++; @endphp
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    function search(event) {
        var searchtext = event.target.value.toLowerCase();
        var str = 0;
        $('.tr').each(function() {
            if (!(
                    $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext)
                )) {
                $(this).addClass('hidden');
            } else {
                $(this).removeClass('hidden');
            }
        });
    }
</script>
@endsection