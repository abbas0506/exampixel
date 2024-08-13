@extends('layouts.teacher')
@section('page-content')

<div class="custom-container">
    <h1>Edit Marks</h1>
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

        <div class="flex justify-between items-center">
            <div>
                <label>{{$testQuestionPart->testQuestion->test->title}}</label>
                <h2>{{$testQuestionPart->testQuestion->test->subject->grade->roman_name}} - {{$testQuestionPart->testQuestion->test->subject->name}}</h2>
            </div>
            <div class="flex items-center justify-center space-x-4 w-8 h-8 rounded-full border border-slate-400">
                <i class="bx bx-pencil text-xs"></i>
            </div>
        </div>
        <div class="divider my-4"></div>
        <form action="{{route('teacher.question-parts.update', $testQuestionPart)}}" method='post' class="">
            @csrf
            @method('PATCH')
            <div class="flex items-center justify-between gap-2">
                <div class="flex flex-col flex-2">
                    <label for="">Q.{{$testQuestionPart->testQuestion->question_no}}</label>
                    <h3>{{$testQuestionPart->question->question}}</h3>
                </div>

                <div class="flex flex-col text-center">
                    <label for="">Marks</label>
                    <input type="text" id='marks' name="marks" class="w-16 custom-input text-center" value="{{$testQuestionPart->marks}}">
                </div>
            </div>
            <div class="divider my-4"></div>
            <div class="text-right">
                <button type="submit" class="btn-teal rounded px-4">Save Now</button>
            </div>
        </form>

    </div>
</div>
@endsection
@section('script')
<script type="module">
    $(document).ready(function() {
        $('#marks').change(function() {
            var currentInput = $(this).val();
            // remove spaces from around
            currentInput = $.trim(marks);
            if ($.isNumeric(currentInput)) {
                //clear previous error if any
                if ($(this).hasClass('border-red-500'))
                    $(this).removeClass('border-red-500');
            } else {
                if (currentInput == '')
                    $(this).val(0)
                else {
                    $(this).addClass('border-red-500');
                }
            }
        });

        $('form').submit(function(event) {
            var validated = true;
            var marks = $('#marks').val();

            if ($.isNumeric(marks)) {
                if (marks <= 0 || marks > 20)
                    validated = false
            } else {
                validated = false
            }

            if (!validated) {
                event.preventDefault();
                Swal.fire({
                    title: "Warning",
                    text: "Review marks carefully!",
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