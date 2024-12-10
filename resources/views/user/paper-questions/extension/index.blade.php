@extends('layouts.basic')

@section('header')
<x-headers.user page="New Paper" icon="<i class='bi bi-file-earmark-text'>
</i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.user page='paper'></x-sidebars.user>
@endsection

@php
$colors = config('globals.colors');
$roman = new Roman();
$QNo = 1;
@endphp

@section('body')
<div class="responsive-container">
    <div class="container">
        <div class="flex flex-row justify-between items-center">
            <div class="bread-crumb">
                <a href="{{ url('/') }}">Home</a>
                <div>/</div>
                <a href="{{ route('user.papers.show', $paper) }}">Paper</a>
                <div>/</div>
                <div>Question Choices</div>
            </div>
        </div>


        <div class="content-section mt-6">
            <div class="flex items-center justify-between flex-wrap  gap-2">
                <div class="flex flex-row items-center gap-3">
                    <img src="{{ url('images/small/pdf.png') }}" alt="paper" class="w-12">
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
            <div class="divider my-3"></div>
            <div class="grid gap-6 md:w-3/4 mx-auto  mt-4">
                <h2 class="text-lg">Question Extension</h2>

                <p class="relative p-2 bg-teal-50 border border-teal-100 rounded text-sm text-teal-600"> Please specify the type of question.</p>

                <div class="grid md:grid-cols-3 gap-4 mt-4 place-items-center">
                    @foreach($questionTypes as $type)
                    <a href="{{ route('user.paper-question.type.extensions.create', [$paperQuestion, $type]) }}" class="bg-{{$colors[$loop->index%5]}}-100 hover:bg-{{$colors[$loop->index%5]}}-200 rounded-md py-3 w-full text-center">{{ $type->name }}</a>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
    @endsection

    @section('script')
    <script type="module">
        $('document').ready(function() {

            $('.confirm-del').click(function(event) {
                var form = $(this).closest("form");
                // var name = $(this).data("name");
                event.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        //submit corresponding form
                        form.submit();
                    }
                });
            });

        });
    </script>
    @endsection