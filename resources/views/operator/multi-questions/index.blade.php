@extends('layouts.basic')
@section('header')
<x-headers.user page="Questions" icon="<i class='bi bi-database-gear'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.operator page='questions'></x-sidebars.operator>
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
            <a href="{{route('operator.books.index')}}">Books</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('operator.books.chapters.index', $chapter->book)}}">Chapters</a>
            <i class="bx bx-chevron-right"></i>
            <div>Ch. {{ $chapter->sr }}</div>

        </div>


        <div class="gridgap-6">
            <!-- mid panel  -->
            <div class="flex flex-wrap items-center justify-between p-4 border rounded-lg bg-green-100 border-green-200">
                <div>
                    <h2>{{ $chapter->book->name }}</h2>
                    <label>Ch # {{ $chapter->sr }}. {{ $chapter->title }}</label>
                </div>

                <a href="{{route('operator.chapter.questions.index', $chapter)}}" class="btn-orange rounded">Back</a>

            </div>

            <!-- page message -->
            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            <!-- search -->
            <div class="md:w-1/3 relative my-4">
                <input type="text" id='searchby' placeholder="Search ..." class="custom-search w-full" oninput="search(event)">
                <i class="bx bx-search absolute top-2 right-2"></i>
            </div>

            <div class="overflow-x-auto">
                <form action="{{route('operator.chapter.multi-questions.update', [$chapter,1])}}" method='post' class="mt-6 w-full md:w-4/5 mx-auto" onsubmit="return validate(event)">
                    @csrf
                    @method('PATCH')
                    <div class="flex justify-between items-center">
                        <h2 class="mt-4">Select Questions and Update</h2>
                        <div>
                            <label for="">Change to Q Type</label>
                            <select name="type_id" id="" class="custom-input-borderless">

                                @foreach($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="flex items-center space-x-2 mt-3 pl-8">
                        <input type="checkbox" id='check_all' class="custom-input w-4 h-4 rounded">
                        <p class="text-red-600">Select All</p>
                    </div>
                    <div class="mt-4">
                        <div class="grid text-sm">
                            @foreach($chapter->questions->sortBy('type_id') as $question)
                            <div class="flex items-center odd:bg-slate-100 space-x-3 checkable-row pl-8">
                                <div class="flex flex-1 items-center justify-between space-x-2 pr-3">
                                    <div class="text-base font-extrabold mr-3">
                                        <input type="checkbox" id='question{{$question->id}}' name='question_ids_array[]' class="custom-input w-4 h-4 rounded hidden" value="{{ $question->id }}">
                                        <i class="bx bx-check"></i>
                                    </div>
                                    <label for='question{{$question->id}}' class="flex-1 text-sm text-slate-800 py-3 hover:cursor-pointer">{{ $loop->index+1}}. &nbsp {{ $question->statement }} </label>
                                </div>
                                <div>{{ $question->type->name }}</div>
                            </div>
                            @endforeach

                        </div>

                        <div class="divider my-5"></div>
                        <div class="flex justify-end my-5">
                            <button type="submit" class="btn-teal rounded py-2 px-4" @disabled($chapter->questions->count()==0)>Next <i class="bi-arrow-right"></i></button>
                        </div>
                </form>
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