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
        <form action="{{ route('user.paper.question-type.partial-questions.store', [$paper, $type]) }}" method="post" class="grid gap-6 md:w-3/4 mx-auto mt-6">
            @csrf
            <h2 class="text-2xl">{{ $type->name }}</h2>
            <input type="hidden" name="type_name" value="{{ $type->display_style }}">

            <div class="grid md:grid-cols-3 gap-6 items-center">
                <div class="">
                    <label>Importance Level</label>
                    <select name="frequency" id="" class="custom-input-borderless text-sm py-1">
                        <option value="1">Normal</option>
                        <option value="2">High</option>
                        <option value="3">Very High</option>
                    </select>
                </div>

                <div class="" id='marks' @if(in_array($type->id,[1,2])) hidden @endif>
                    <label>Marks</label>
                    <input type="number" name="marks" class="custom-input-borderless" min=1 max=100 value="5">
                </div>
            </div>

            <div>
                <label for="">Question Title</label>
                <input type="text" name="question_title" value="{{ $type->default_title }}" class="custom-input-borderless">
            </div>


            <div class="grid text-sm border p-6">

                <table class="borderless">
                    <thead>
                        <tr>
                            <th>Sr</th>
                            <th class="text-left">Chapter</th>
                            <th>Parts</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($chapters->sortBy('sr') as $chapter)
                        <tr>
                            <td>{{ $chapter->sr}}.</td>
                            <td class="text-left">{{ $chapter->title }}</td>
                            <td>
                                <input type="hidden" name='chapter_ids_array[]' value="{{$chapter->id}}">
                                <input type="number" name='num_of_parts_array[]' autocomplete="off" class="parts-count custom-input-borderless w-16 h-8 text-center px-0" min='0' value="0" oninput="syncNumOfParts()">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="grid justify-end w-48 gap-6">
                <div class="">
                    <label>Total Parts</label>
                    <input type="number" id="total_parts" class="custom-input-borderless" value="0" disabled>
                </div>
                <div class="">
                    <label>Compulsory Parts</label>
                    <input type="number" id='compulsory_parts' name="compulsory_parts" class="custom-input-borderless text-red-600" value="" min=1>
                </div>
                <div class="">
                    <button type="submit" class="btn-blue px-5 py-2.5 rounded">Add Q.</button>
                </div>
            </div>

        </form>

    </div>
    @endsection
    @section('script')
    <script type="module">
        $(document).ready(function() {

            $('.parts-count').click(function() {
                $(this).select();
            })
            $('#compulsory_parts').click(function() {
                $(this).select();
            })

            $('.parts-count').bind('keyup mouseup', function() {
                var sumOfParts = 0;
                $('.parts-count').each(function() {
                    sumOfParts += parseInt($(this).val());

                });

                sumOfParts = parseInt(sumOfParts);
                $('#total_parts').val(sumOfParts);
                $('#compulsory_parts').val(sumOfParts);
            });


            $('form').submit(function(event) {
                var validated = true;
                var compulsory_parts = $('#compulsory_parts').val();
                if ($('#total_parts').val() == '')
                    validated = false
                else if ($.isNumeric(compulsory_parts)) {
                    var totalParts = $('#parts_count').val()
                    if (compulsory_parts <= 0 || compulsory_parts > totalParts)
                        validated = false
                } else {
                    validated = false
                }

                if (!validated) {
                    event.preventDefault();
                    Swal.fire({
                        title: "Warning",
                        text: "Review compulsory parts carefully!",
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