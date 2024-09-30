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
                <div>Add Long Q.</div>
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
            <h2>Long Q. Partial(title + vertical parts)</h2>
            <form id='data-form' action="{{ route('user.papers.partialQuestions.store', $paper) }}" method="post">
                @csrf

                <input type="hidden" name="question_type" value="7">
                <input type="hidden" name="chapter_id" id='chapter_id' value="">

                <div class="grid grid-cols-2 gap-6">
                    <div class="">
                        <label>Importance Level</label>
                        <select name="frequency" id="" class="custom-input-borderless text-sm">
                            <option value="1">Normal</option>
                            <option value="2">High</option>
                            <option value="3">Very High</option>
                        </select>
                    </div>
                    <div>
                        <label>Marks</label>
                        <select name="marks" id="marks" class="custom-input-borderless text-sm">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5" selected>5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                    </div>
                    <div>
                        <label for="">Total Parts</label>
                        <input type="number" name="num_of_parts" class="custom-input-borderless" value="2">
                    </div>
                    <div>
                        <label for="">Choices</label>
                        <input type="number" name="choices" class="custom-input-borderless" value="0">
                    </div>
                    <div class="col-span-2">
                        <label for="">Question Title</label>
                        <input type="text" name="question_title" value="" class="custom-input" placeholder="Qestion title please" required>
                    </div>
                </div>
            </form>

            <!-- Chapters List -->
            <div class="flex flex-col">
                <label class="text-teal-600 mb-3">Click on any chapter</label>
                @foreach($chapters->sortBy('sr') as $chapter)
                <div data-val='{{$chapter->id}}' class="manual-form-submition text-sm even:bg-slate-100  text-slate-800 py-3 hover:cursor-pointer w-full text-left">{{ $chapter->sr}}. &nbsp {{ $chapter->title }} </div>
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