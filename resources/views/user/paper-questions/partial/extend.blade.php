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
                <div>Extend Q.</div>
            </div>
        </div>


        <div class="content-section rounded-lg mt-2">
            <!-- page message -->
            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            <div class="flex items-center justify-between flex-wrap  gap-2">
                <div class="flex flex-row items-center gap-3">
                    <img src="{{ url('images/icons/add-q.png') }}" alt="paper" class="w-12">
                    <div class="flex flex-col">
                        <h2>{{ $paper->book->name }} </h2>
                        <div class="flex items-center space-x-3">
                            <label>{{ $paper->title }}</label>
                        </div>
                    </div>
                </div>
                <div>
                    <p class="text-slate-500 text-sm text-center md:text-right md:pr-5">Step 3.2/4</p>
                </div>
            </div>
        </div>

        <div class="divider my-3"></div>

        <div class="grid gap-6 md:w-3/4 mx-auto mt-6">
            <h2 class="text-2xl">Question Extension</h2>
            <form id='data-form' action="{{ route('user.paper-question.type.extensions.store', [$paperQuestion, $typeId]) }}" method="post">
                @csrf
                <input type="hidden" name="chapter_id" id='chapter_id' value="">

                <div class="flex flex-col gap-5">
                    <div class="flex flex-col md:w-1/3">
                        <label>Importance Level</label>
                        <select name="frequency" id="" class="custom-input-borderless text-sm">
                            <option value="1">Normal</option>
                            <option value="2">High</option>
                            <option value="3">Very High</option>
                        </select>
                    </div>
                    <div class="md:w-1/3" id='marks'>
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