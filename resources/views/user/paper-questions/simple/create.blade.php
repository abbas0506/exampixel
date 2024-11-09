@extends('layouts.basic')

@section('header')
<x-headers.user page="New Paper" icon="<i class='bi bi-file-earmark-text'></i>"></x-headers.user>
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
                <a href="{{ route('user.papers.show', $paper) }}">Paper</a>
                <div>/</div>
                <div>Add Q.</div>
            </div>
        </div>


        <div class="content-section rounded-lg mt-2">
            <!-- page message -->
            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            <div class="grid md:grid-cols-2 items-end gap-4">
                <div class="flex flex-col md:flex-row gap-3 items-center md:items-end">
                    <img src="{{url('images/icons/add-q.png')}}" alt="paper" class="w-12">
                    <div class="flex flex-col">
                        <h3>{{ $paper->book->name }} </h3>
                        <p>{{$paper->title}}</p>
                    </div>
                </div>
                <div class="text-center md:text-right md:pr-5"><label>Dated: {{ $paper->paper_date->format('d/m/Y') }}</label></div>
            </div>

        </div>

        <div class="divider my-3"></div>

        <div class="grid gap-6 md:w-3/4 mx-auto mt-6">
            <h2 class="text-2xl">{{ $type->name }}</h2>
            <form id='data-form' action="{{ route('user.paper.question-type.simple-questions.store', [$paper, $type]) }}" method="post">
                @csrf

                <input type="hidden" name="chapter_id" id='chapter_id' value="">
                <input type="text" id='simple' name="type_name" value="simple" hidden>
                <div class="grid md:grid-cols-3 gap-6 items-center">
                    <div class="">
                        <label>Importance Level</label>
                        <select name="frequency" id="" class="custom-input-borderless text-sm py-1">
                            <option value="1">Normal</option>
                            <option value="2">High</option>
                            <option value="3">Very High</option>
                        </select>
                    </div>

                    <div class="">
                        <label>Marks</label>
                        <input type="number" name="marks" class="custom-input-borderless" min=1 max=100 value="5">
                    </div>
                </div>

                <div class="mt-6"></div>
                <div>
                    <label for="">Question Title</label>
                    <input type="text" name="question_title" value="{{ $type->default_title }}" class="custom-input-borderless" placeholder="Question title here if any">
                </div>


            </form>

            <!-- Chapters List -->
            <div class="flex flex-col">
                <p class="mb-3 relative p-2 bg-gradient-to-r from-teal-300 to-teal-100">Please click on any of the following chapters to insert Q.</p>
                @foreach($chapters->sortBy('sr') as $chapter)
                <div data-val='{{$chapter->id}}' class="manual-form-submition text-sm even:bg-slate-100  text-slate-800 p-3 hover:cursor-pointer w-full text-left">{{ $chapter->sr}}. &nbsp {{ $chapter->title }} </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="module">
    $(document).ready(function() {

        $('.manual-form-submition').click(function() {
            $('#chapter_id').val($(this).attr('data-val'))
            $('form').submit();
        })



    });
</script>
@endsection