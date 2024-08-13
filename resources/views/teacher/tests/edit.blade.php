@extends('layouts.teacher')
@section('page-content')

<div class="custom-container">
    <h1>Edit Test Setting</h1>
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
                <label>{{$test->title}}</label>
                <h2>{{$test->subject->grade->roman_name}} - {{$test->subject->name}}</h2>
            </div>
            <div class="flex items-center justify-center space-x-4 w-8 h-8 rounded-full border border-slate-400">
                <i class="bx bx-pencil text-xs"></i>
            </div>
        </div>
        <div class="divider my-6"></div>
        <form action="{{route('teacher.tests.update', $test)}}" method='post'>
            @csrf
            @method('PATCH')

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                <div class="flex flex-col flex-1">
                    <label for="">Title</label>
                    <input name="title" class="custom-input" value="{{$test->title}}" required>
                </div>

                <div class="flex flex-col">
                    <label for="">Duration<span class="text-xs"></span></label>
                    @if($test->duration>0)
                    <input type="text" id='duration' name="duration" class="w-16 custom-input text-center" value="{{$test->duration}}">
                    @else
                    <input type="text" id='duration' name="duration" class="w-16 custom-input text-center" value="{{round($test->totalMarks()*1.5,0)}}">
                    @endif
                </div>

            </div>
            <div class="divider my-6"></div>
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
        $('#duration').change(function() {
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
            var duration = $('#duration').val();

            if ($.isNumeric(duration)) {
                if (duration <= 0 || duration > 240)
                    validated = false
            } else {
                validated = false
            }

            if (!validated) {
                event.preventDefault();
                Swal.fire({
                    title: "Warning",
                    text: "Review duration carefully!",
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