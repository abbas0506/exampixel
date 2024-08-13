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

        </div>

        <div class="divider my-3"></div>
        <form action="{{ route('teacher.papers.shorts.store', $paper) }}" method="post">
            @csrf

            <input type="hidden" id='book_id' value="{{ $paper->book->id }}">

            <div class="flex flex-col md:flex-row md:items-center gap-8 bg-slate-100 border border-dashed rounded-lg p-5 mt-5">
                <div class="flex flex-col md:w-1/3">
                    <label>Importance Level</label>
                    <select name="frequency" id="" class="custom-input-borderless text-sm">
                        <option value="1">Normal</option>
                        <option value="2">High</option>
                        <option value="3">Very High</option>
                    </select>
                </div>

                <div class="md:w-1/3" id='display_style_cover'>
                    <label>Display Style</label>
                    <select name="display_style" id="display_style" class="custom-input-borderless text-sm">
                        <option value="vertical">Vertical</option>
                        <option value="horizontal">Horizontal</option>
                    </select>
                </div>
            </div>

            <!-- Chapters List -->
            <div class="p-4 md:p-8 h-[16rem] overflow-y-auto">
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 md:gap-x-16 text-left">

                    <div class="grid col-span-full text-sm">
                        @foreach($chapters->sortBy('chapter_no') as $chapter)
                        <div class="flex items-center odd:bg-transparent px-3">
                            <label for='chapter{{$chapter->id}}' class="flex-1 text-sm text-slate-800 py-3 hover:cursor-pointer">{{ $chapter->chapter_no}}. &nbsp {{ $chapter->name }} </label>
                            <input type="hidden" name='chapter_ids_array[]' value="{{$chapter->id}}">
                            <input type="number" name='num_of_parts_array[]' autocomplete="off" class="parts-count custom-input-borderless w-16 h-8 text-center px-0" min='0' value="0" oninput="syncNumOfParts()">

                        </div>
                        @endforeach
                    </div>

                </div>

            </div>
            <!-- Modal footer -->

            <div class="flex flex-wrap justify-center items-center p-4 md:p-5 gap-6 border-t border-gray-200 rounded-b dark:border-gray-600">

                <div class="flex flex-wrap gap-4">
                    <div>
                        <label>Total Parts</label>
                        <input type="number" id="total_parts" class="custom-input-borderless w-16 h-8 text-center font-bold" value="0" disabled>
                    </div>
                    <div> <label>Choices</label>
                        <input type="number" id='choices' name="choices" class="custom-input-borderless w-16 h-8 text-center font-bold text-red-600" value="0">
                    </div>
                </div>
                <div>
                    <button type="submit" class="btn-blue px-5 py-2.5 rounded-lg">Add Q.</button>
                </div>

            </div>

        </form>
    </div>
</div>
@endsection
@section('script')
<script type="module">
    $(document).ready(function() {

        $('.parts-count').click(function() {
            $(this).select();
        })
        $('#choices').click(function() {
            $(this).select();
        })

        $('.parts-count').bind('keyup mouseup', function() {
            var sumOfParts = 0;
            $('.parts-count').each(function() {
                sumOfParts += parseInt($(this).val());

            });

            sumOfParts = parseInt(sumOfParts);
            $('#total_parts').val(sumOfParts);
            // $('#choices').val(sumOfParts);
        });


        $('form').submit(function(event) {
            var validated = true;
            var choices = $('#choices').val();
            if ($('#total_parts').val() == '')
                validated = false
            else if ($.isNumeric(choices)) {
                var totalParts = $('#total_parts').val()
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