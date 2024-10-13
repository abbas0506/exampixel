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


        <div class="content-section mt-12 text-sm md:w-3/4 mx-auto">
            <!-- page message -->
            @if ($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            <h2 class="text-center bg-slate-100">Click on a type</h2>
            <div class="grid md:grid-cols-3 gap-4 mt-8 place-items-center">
                @foreach($questionTypes as $type)
                @if($type->display_style=='simple')
                <a href="{{ route('user.papers.question-types.simple-questions.create', [$paper, $type]) }}" class="bg-{{$colors[$loop->index%5]}}-100 hover:bg-{{$colors[$loop->index%5]}}-200 rounded-md py-3 w-full text-center">{{ $type->name }}</a>
                @else
                <a href="{{ route('user.papers.question-types.partial-questions.create', [$paper, $type]) }}" class="bg-{{$colors[$loop->index%5]}}-100 hover:bg-{{$colors[$loop->index%5]}}-200 rounded-md py-3 w-full text-center">{{ $type->name }}</a>
                @endif
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