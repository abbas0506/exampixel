@extends('layouts.basic')
@section('header')
<x-headers.user page="Q. Bank" icon="<i class='bi bi-database-gear'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.admin page='qbank'></x-sidebars.admin>
@endsection

@php
$colors=config('globals.colors');
$i=0;
$activeChapter=$chapter;
@endphp

@section('body')
<div class="responsive-container">
    <div class="container">
        <div class="bread-crumb">
            <a href="{{url('/')}}">Home</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('admin.qbank-books.index',)}}">Books</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('admin.qbank-books.chapters.index',$chapter->book)}}">Chapters</a>
            <i class="bx bx-chevron-right"></i>
            <div>Ch. {{ $chapter->sr }}</div>
        </div>



        <div class="flex flex-wrap items-center justify-between p-4 border rounded-lg bg-green-100 border-green-200">
            <div>
                <h2>{{ $chapter->book->name }}</h2>
                <p>Ch # {{ $chapter->sr}}. {{ $chapter->title }}</p>
            </div>
            <div class="flex items-center flex-wrap justify-between gap-x-6">
                <!-- search -->

                <a href="{{route('admin.chapter.questions.create',$chapter)}}" class="btn-green rounded">New Q.</a>
            </div>
        </div>

        <!-- search -->
        <div class="relative md:w-1/3 my-4">
            <input type="text" id='searchby' placeholder="Search ..." class="custom-search w-full" oninput="search(event)">
            <i class="bx bx-search absolute top-2 right-2"></i>
        </div>
        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <div class="overflow-x-auto">
            <table class="table-fixed borderless w-full mt-3">
                <thead>
                    <tr class="tr">
                        <th class="w-8">Sr</th>
                        <th class="w-48">Question</th>
                        <th class="w-20">Type</th>
                        <th class="w-12">Action</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($chapter->questions->sortBy('type_id') as $question)
                    <tr class="tr">
                        <td>{{ $loop->index+1 }}</td>
                        <td class="text-left">
                            <a href="{{ route('admin.chapter.questions.show',[$chapter,$question]) }}" class="link">{{ $question->statement }}</a>
                            @if($question->mcq)
                            <div class="">

                                <div @if($question->mcq->correct=='a') class='font-semibold' @endif>{{ $question->mcq->choice_a }}</div>
                                <div @if($question->mcq->correct=='b') class='font-semibold' @endif>{{ $question->mcq->choice_b }}</div>
                                <div @if($question->mcq->correct=='c') class='font-semibold' @endif>{{ $question->mcq->choice_c }}</div>
                                <div @if($question->mcq->correct=='d') class='font-semibold' @endif>{{ $question->mcq->choice_d }}</div>

                            </div>
                            @endif

                        </td>
                        <td>
                            {{ $question->type->name }}

                        </td>
                        <td>
                            <div class="flex justify-center items-center space-x-2">
                                <a href="{{route('admin.chapter.questions.edit', [$chapter, $question])}}">
                                    <i class="bx bx-pencil text-green-600"></i>
                                </a>
                                <form action="{{route('admin.chapter.questions.destroy', [$chapter->id, $question])}}" method="POST" onsubmit="return confirmDel(event)">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-transparent p-0 border-0">
                                        <i class="bx bx-trash text-red-600"></i>
                                    </button>
                                </form>
                            </div>

                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript">
    function confirmDel(event) {
        event.preventDefault(); // prevent form submit
        var form = event.target; // storing the form

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
                form.submit();
            }
        })
    }

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