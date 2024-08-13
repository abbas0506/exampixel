@extends('layouts.teacher')
@section('page-content')

<div class="custom-container">
    <h1>Question Structure</h1>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <div>Draft</div>
    </div>
    <div class="content-section">
        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <div class="flex flex-col items-center">
            <h2>{{$test->subject->name}} - {{$test->subject->grade->roman_name}}</h2>
            <label>{{$test->title}}</label>
        </div>

        <div class="divider my-3"></div>
        <form action="{{route('teacher.test-questions.store')}}" method='post' onsubmit="return validate(event)">
            @csrf
            <input type="hidden" name="test_id" value="{{$test->id}}">
            <input type="hidden" name="question_no" value="{{$test->questions->count()+1}}">
            <input type="hidden" name="question_type" value="{{$questionType}}">
            <div class="flex justify-between items-center">
                <label>Question # {{$test->questions->count()+1}}</label>
                <label class="w-16 text-center">{{ucwords($questionType)}}</label>
            </div>
            <div class="divider my-3"></div>
            <h3>Chapter wise distribution of parts / questions.</h3>

            @foreach($chapters as $chapter)
            <div class="flex items-baseline justify-between space-x-4">
                <label for="">Ch #{{$chapter->chapter_no}}. &nbsp {{$chapter->name}}</label>
                <input type="hidden" name='chapter_id_array[]' value="{{$chapter->id}}">
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
                <h3>How many to attempt? <span class="text-red-600">*</span></h3>
                <input type="text" id='necessary_parts' name='necessary_parts' class="custom-input w-16 h-8 text-center px-0" value="0">
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
            // var currentInput = $(this).val();
            // remove spaces from around
            // currentInput = $.trim(currentInput);
            $('.num-of-parts').each(function() {

                // alert($(this).val())
                // cellvalue = $.trim(this.val());
                if ($(this).val() == '') {
                    sumOfParts += 0;
                    $('#total_parts').html(sumOfParts);
                    $('#necessary_parts').val(sumOfParts);
                } else {
                    if ($.isNumeric($(this).val())) {
                        sumOfParts += parseInt($(this).val());
                        $('#total_parts').html(sumOfParts);
                        $('#necessary_parts').val(sumOfParts);
                    } else {
                        $(this).addClass('border-red-500');
                        $('#total_parts').html('');
                        $('#necessary_parts').val('');

                    }
                }

                // if ($.isNumeric(currentInput)) {
                //     $('.num-of-parts').each(function() {
                //         // update fields
                //         sumOfParts += parseInt($(this).val());
                //         $('#total_parts').html(sumOfParts);
                //         $('#necessary_parts').val(Math.ceil(2 / 3 * sumOfParts));
                //     });
                //     //clear previous error if any
                //     if ($(this).hasClass('border-red-500'))
                //         $(this).removeClass('border-red-500');
                // } else {
                //     // if (currentInput == '')
                //     // $(this).val(0)
                //     if (currentInput != '') {
                //         $(this).addClass('border-red-500');
                //         // $('#necessary_parts').val(0);
                //         $('#total_parts').html('');
                //     }
                // }
            });
        });

        $('form').submit(function(event) {
            var validated = true;
            var numOfNecessaryParts = $('#necessary_parts').val();

            if ($('#total_parts').html() == '')
                validated = false
            else if ($.isNumeric(numOfNecessaryParts)) {
                var totalParts = parseInt($('#total_parts').html())
                if (numOfNecessaryParts <= 0 || numOfNecessaryParts > totalParts)
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

        // $('.numOfParts').change(function() {

        // })
    });
</script>
@endsection