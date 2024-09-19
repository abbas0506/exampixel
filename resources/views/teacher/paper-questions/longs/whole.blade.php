@extends('layouts.basic')

@section('header')
<x-headers.user page="New Paper" icon="<i class='bi bi-file-earmark-text'></i>"></x-headers.user>
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
                <a href="{{ route('teacher.papers.show', $paper) }}">Paper</a>
                <div>/</div>
                <div>Add Long</div>
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
                    <img src="{{url('images/small/paper-0.png')}}" alt="paper" class="w-24">
                    <div class="flex flex-col">
                        <h2>{{ $paper->book->name }} </h2>
                        <label>{{$paper->title}}</label>
                    </div>
                </div>
                <h2 class="text-center md:text-right md:pr-5">Long Q.</h2>
            </div>

        </div>

        <div class="divider my-3"></div>

        <div class="flex flex-wrap items-center justify-between w-full mt-8 gap-y-4">
            <div class="flex items-center space-x-4 text-slate-600">
                <p class="tab active">Whole Q.</p>
                <a href="{{ route('teacher.papers.partialQuestions.create', $paper) }}" class="tab">Partial Q. (has parts)</a>
            </div>
        </div>

        <form id='data-form' action="{{ route('teacher.papers.wholeQuestions.store', $paper) }}" method="post">
            @csrf

            <input type="hidden" id='book_id' value="{{ $paper->book->id }}">
            <input type="hidden" name="question_nature" value="whole">
            <input type="hidden" name="chapter_id" id='chapter_id' value="">

            <div class="flex flex-col md:flex-row md:items-center gap-8 bg-slate-100 border border-dashed rounded-lg p-5 mt-5">
                <div class="flex flex-col md:w-1/4">
                    <label>Importance Level</label>
                    <select name="frequency" id="" class="custom-input-borderless text-sm">
                        <option value="1">Normal</option>
                        <option value="2">High</option>
                        <option value="3">Very High</option>
                    </select>
                </div>
                <div class="md:w-1/4" id='marks'>
                    <label>Marks</label>
                    <select name="marks" id="marks" class="custom-input-borderless text-sm">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </div>

                @if($paper->book->subtype_mappings->where('type_id', 3)->count()>0)
                <div class="">
                    <label>Sub Type</label>
                    <select name="subtype_id" id="subtype_id" class="custom-input-borderless text-sm">
                        @foreach($paper->book->subtypes(3) as $subtype)
                        <option value="{{ $subtype->id }}">{{ $subtype->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
            </div>

        </form>

        <!-- Chapters List -->
        <div class="flex flex-col p-4 md:p-8">
            <label class="text-teal-600 mb-3">Click on any chapter</label>
            @foreach($chapters->sortBy('chapter_no') as $chapter)
            <div data-val='{{$chapter->id}}' class="manual-form-submition text-sm even:bg-slate-100  text-slate-800 py-3 hover:cursor-pointer w-full text-left">{{ $chapter->chapter_no}}. &nbsp {{ $chapter->name }} </div>
            @endforeach
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