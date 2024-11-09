@extends('layouts.basic')

@section('header')
<x-header></x-header>
@endsection

@section('body')
<div class="w-full md:w-2/3 mx-auto text-center mt-32 px-5">

    <!-- page message -->
    @if($errors->any())
    <x-message :errors='$errors'></x-message>
    @else
    <x-message></x-message>
    @endif

    <form id='start-test-form' action="{{route('self-tests.store')}}" method='post' onsubmit="return validate(event)">
        @csrf

        <div class="grid md:grid-cols-2 items-end gap-4">
            <div class="flex flex-col md:flex-row gap-3 items-center md:items-end">
                <img src="{{url('images/small/mcqs-1.jpg')}}" alt="mcqs" class="w-24">
                <div class="flex flex-col">
                    <div class="flex text-left space-x-3">
                        <h2>{{ $book->name }} </h2>
                        <a href="{{route('self-tests.index')}}" class="btn-blue rounded-lg text-xs"><i class="bx bx-pencil"></i></a>
                    </div>
                    <p class="text-slate-600">Please select chapters</p>
                </div>
            </div>
            <div class="flex flex-col items-center md:items-end">
                <label for="" class="text-red-600">How many MCQs?</label>
                <input type="number" name="mcqs_count" class="custom-input w-24 text-center" min=1 max=50 value="20">
            </div>
        </div>

        <div class="leading-relaxed mt-6 text-left bg-teal-800 text-slate-300 p-5">
            <ul class="list-disc list-inline text-left text-sm pl-4">
                <li>You may select multiple chapters</li>
                <li>After selecting chapters, click on start now button</li>
            </ul>
        </div>

        <div class="mt-3">
            @foreach($book->chapters->sortBy('sr') as $chapter)
            <div class="flex items-center justify-between space-x-2 border-b">
                <label for="chapter{{$chapter->id}}" class="hover:cursor-pointer text-base text-slate-800 text-left py-3 flex-1">{{$chapter->sr}}. &nbsp {{$chapter->title}}</label>
                <input type="checkbox" id='chapter{{$chapter->id}}' name='chapter_ids_array[]' class="custom-input w-4 h-4" value="{{ $chapter->id }}">
            </div>
            @endforeach
        </div>
        <div class="my-8">
            <input type="hidden" name="book_id" value="{{ $book->id }}">
            <button type="submit" class=" btn-teal py-3 px-4 rounded" @disabled($book->chapters->count()==0)> Start Your Test Now</button>
        </div>
    </form>
</div>
@endsection

@section('footer')
<x-footer></x-footer>
@endsection
@section('script')
<script type="module">
    $('document').ready(function() {
        $('#start-test-form').submit(function(e) {
            var anyChecked = 0
            $('.custom-input').each(function() {
                if ($(this).is(':checked'))
                    anyChecked++;
            })
            if (anyChecked == 0) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Please select a chapter',
                    showConfirmButton: false,
                    timer: 1000,
                })

            }
        })
    })
</script>
@endsection