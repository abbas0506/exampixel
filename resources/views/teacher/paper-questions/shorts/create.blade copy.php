@extends('layouts.basic')

@section('header')
<x-headers.user page="Welcome back!" icon="<i class='bi bi-emoji-smile'></i>"></x-headers.user>
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
                <div>Add Short</div>
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

            </div>

            <div class="divider my-3"></div>
            <form action="{{route('teacher.papers.shorts.store', $paper)}}" method='post' onsubmit="return validate(event)">
                @csrf
                <input type="hidden" name="question_no" value="{{$paper->paperQuestions->count()+1}}">

                <div class="" id='display_style_cover'>
                    <label>Display Format</label>
                    <select name="display_style" id="display_style" class="custom-input-borderless text-sm">
                        <option value="compact">Compact Question</option>
                        <option value="vertical">Vertical List</option>
                        <option value="horizontal">Horizontal List </option>
                        <option value="alt">OR Separated Alternative</option>
                    </select>
                </div>

                <div class="">
                    <label>Importance Level</label>
                    <select name="frequency" id="" class="custom-input-borderless text-sm">
                        <option value="1">Normal</option>
                        <option value="2">High</option>
                        <option value="3">Very High</option>
                    </select>
                </div>

                <div class="flex justify-between items-center">
                    <label>Question # {{$paper->paperQuestions->count()+1}}</label>
                    <label class="w-16 text-center">Short</label>
                </div>
                <div class="divider my-3"></div>
                <h3>Chapter wise distribution of parts / questions.</h3>

                @foreach($chapters as $chapter)
                <div class="flex items-baseline justify-between space-x-4">
                    <label for="">Ch #{{$chapter->chapter_no}}. &nbsp {{$chapter->name}}</label>
                    <input type="hidden" name='chapter_ids_array[]' value="{{$chapter->id}}">
                    <input type="text" name='num_of_parts_array[]' autocomplete="off" class="num-of-parts custom-input w-16 h-8 text-center px-0" value="0" oninput="syncNumOfParts()">
                </div>
                @endforeach
                <!-- <div class="divider my-3"></div> -->
                <div class="flex items-baseline justify-between space-x-4 bg-green-50 text-green-600 my-3 border border-green-200">
                    <h3 class="text-green-600 pl-1">Total parts:</h3>
                    <h3 id='total_parts' class="flex justify-center items-center w-16 h-8 text-center px-0  text-green-600">0</h3>
                </div>
                <!-- <div class="divider my-3"></div> -->
                <div class="flex items-baseline justify-between space-x-4">
                    <h3>Number of choices? <span class="text-red-600">*</span></h3>
                    <input type="text" id='choices' name='choices' class="custom-input w-16 h-8 text-center px-0" value="0">
                </div>
                <div class="text-right">
                    <button type="submit" class="btn-teal rounded px-4 mt-4">Save Now</button>
                </div>
            </form>

        </div>
    </div>
    @endsection
    @section('script')
    <script type="module">
        $(document).ready(function() {
            $('.num-of-parts').click(function() {
                $(this).select();
            })
            $('.num-of-parts').keyup(function() {
                var sumOfParts = 0;
                $('.num-of-parts').each(function() {

                    if ($(this).val() == '') {
                        sumOfParts += 0;
                        $('#total_parts').html(sumOfParts);
                    } else {
                        if ($.isNumeric($(this).val())) {
                            sumOfParts += parseInt($(this).val());
                            $('#total_parts').html(sumOfParts);
                        } else {
                            $(this).addClass('border-red-500');
                            $('#total_parts').html('');
                            $('#choices').val('');

                        }
                    }

                });
            });

            $('form').submit(function(event) {
                var validated = true;
                var choices = $('#choices').val();
                if ($('#total_parts').html() == '')
                    validated = false
                else if ($.isNumeric(choices)) {
                    var totalParts = parseInt($('#total_parts').html())
                    if (choices < 0 || choices >= totalParts)
                        validated = false
                } else {
                    validated = false
                }


                if (!validated) {
                    event.preventDefault();
                    Swal.fire({
                        title: "Warning",
                        text: "Review number of parts carefully!",
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 1500

                    });

                }
                return validated;
            });

        });
    </script>
    @endsection