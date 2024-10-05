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
        <form action="{{ route('user.papers.multipart-multichapter-questions.store', $paper) }}" method="post" class="grid gap-6 md:w-3/4 mx-auto mt-6">
            @csrf
            <h2>{{ $questionTitle }}</h2>
            <input type="hidden" name="question_type" value="{{ $choice }}">

            <div class="md:w-1/3">
                <label>Importance Level</label>
                <select name="frequency" id="" class="custom-input-borderless text-sm">
                    <option value="1">Normal</option>
                    <option value="2">High</option>
                    <option value="3">Very High</option>
                </select>
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

            <div class="md:w-1/3">
                <label>Total Parts</label>
                <input type="number" id="total_parts" class="custom-input-borderless" value="0" disabled>
            </div>
            <div class="md:w-1/3">
                <label>Choices</label>
                <input type="number" id='choices' name="choices" class="custom-input-borderless text-red-600" value="0">
            </div>

            <div>
                <button type="submit" class="btn-blue px-5 py-2.5 rounded">Add Q.</button>
            </div>


            <!-- Modal footer -->

            <div class="flex flex-wrap items-center p-4 md:p-5 gap-6 border-t border-gray-200 rounded-b dark:border-gray-600">



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