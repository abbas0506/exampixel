@extends('layouts.basic')
@section('header')
<x-headers.user page="Q. Bank" icon="<i class='bi bi-database-gear'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.admin page='qbank'></x-sidebars.admin>
@endsection

@section('body')

@php
$colors=config('globals.colors');
$activeBook=$book;
$i=0;
@endphp

<div class="responsive-container">
    <div class="container">
        <div class="bread-crumb">
            <a href="{{url('/')}}">Home</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('admin.grade.books.index', $book->grade)}}">Books</a>
            <i class="bx bx-chevron-right"></i>
            <div>{{ $book->name }}</div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <!-- mid panel  -->
            <div class="md:col-span-2 lg:col-span-3">
                <div class="p-4 border rounded-lg bg-green-100 border-green-200">
                    <div class="flex flex-wrap gap-4 justify-between items-cente">
                        <h2>{{ $book->name }} <i class="bx bx-chevron-right"></i> Chapters &nbsp<i class="bi-layers"></i></h2>
                        <a href="{{ route('admin.book.chapters.create', $book) }}" class="btn-green rounded text-sm">Add Chapter</a>

                    </div>
                </div>

                <!-- page message -->
                @if($errors->any())
                <x-message :errors='$errors'></x-message>
                @else
                <x-message></x-message>
                @endif

                <div class="mt-4">
                    <div class="grid text-sm">
                        @foreach($book->chapters->sortBy('chapter_no') as $chapter)
                        <div class="flex items-center odd:bg-slate-100 space-x-3">
                            <a href="{{route('admin.chapter.questions.index', $chapter)}}" class="flex flex-1 items-center justify-between p-3 space-x-2">
                                <div class="flex-1">{{ $chapter->chapter_no}}. &nbsp {{ $chapter->name }} ({{ $chapter->id }})</div>
                                <div class="text-xs">
                                    @if($chapter->questions()->today()->count()>0)
                                    {{ $chapter->questions()->today()->count() }}<i class="bi-arrow-up"></i>
                                    @endif
                                </div>
                                <div class="text-xs">
                                    {{ $chapter->questions()->count()}} <i class="bi-question-circle"></i>
                                </div>
                            </a>
                            <div class="flex items-center space-x-3 p-2 rounded">
                                <!-- <a href="" class="">
                                    <i class="bx bx-show-alt"></i>
                                </a> -->
                                <a href="{{route('admin.book.chapters.edit', [$chapter->book, $chapter])}}" class="text-green-600">
                                    <i class="bx bx-pencil"></i>
                                </a>
                                <form action="{{route('admin.book.chapters.destroy',[$book,$chapter])}}" method="POST" onsubmit="return confirmDel(event)">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-transparent p-0 border-0" @disabled($chapter->questions()->count())>
                                        <i class="bx bx-trash text-red-600"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- right panel -->
            <div class="">
                <div class="p-4 border rounded-lg">
                    <div class="flex items-center justify-between">
                        <h2 class="text-sm">Grades <i class="bi-mortarboard-fill"></i></h2>
                    </div>

                    <div class="flex items-center space-x-3 mt-3">
                        @foreach($grades as $grade)
                        @if($grade->id==$book->grade_id)
                        <a href="#" class="flex items-center justify-center text-xs py-3 w-8 h-8 space-x-3 rounded-full bg-green-800 text-slate-50">
                            {{ $grade->grade_no }}
                        </a>
                        @else
                        <a href="{{route('admin.grade.book.chapters.index',[$grade, 0])}}" class="flex items-center justify-center text-xs py-3 w-8 h-8 space-x-3 rounded-full bg-slate-100 text-slate-600">
                            {{ $grade->grade_no }}
                        </a>
                        @endif
                        @php $i++; @endphp
                        @endforeach
                    </div>
                </div>

                <div class="p-4 border rounded-lg mt-3">
                    <div class="flex items-center justify-between">
                        <h2 class="text-sm">Books <i class="bx bx-book"></i></h2>
                        <div class="flex items-center justify-center rounded-full px-2 bg-green-200  text-xs font-semibold"> {{ $activeBook->grade->books->count() }}</i></div>
                    </div>
                    <div class="grid divide-y mt-3">
                        @foreach($activeBook->grade->books->sortBy(' display_order') as $book)
                        <a href="{{route('admin.grade.book.chapters.index',[$book->grade, $book])}}" class="flex items-center text-xs py-3">
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