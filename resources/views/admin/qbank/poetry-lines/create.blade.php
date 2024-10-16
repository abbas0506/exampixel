@extends('layouts.basic')
@section('header')
<x-headers.user page="Questions" icon="<i class='bi bi-database-gear'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.admin page='questions'></x-sidebars.admin>
@endsection

@section('body')
<div class="responsive-container">
    <div class="container">
        <div class="bread-crumb">
            <a href="{{url('/')}}">Home</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('admin.qbank-books.index',)}}">Books</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('admin.qbank-books.chapters.index',$chapter->book)}}">Chapters</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('admin.chapter.questions.index',$chapter)}}">Questions</a>
            <i class="bx bx-chevron-right"></i>
            <div>Create</div>
        </div>

        <div class="divider my-2"></div>

        <div class="md:w-3/4 mx-auto">
            <!-- page message -->
            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            <h2>{{ $chapter->book->name }}</h2>
            <label>Ch # {{ $chapter->sr }}. {{ $chapter->title }}</label>

            <form action="{{route('admin.chapter.poetry-lines.store', $chapter)}}" method='post' class="mt-6">
                @csrf
                <div class="grid gap-6 w-full">
                    <div class="md:w-1/2">
                        <label for="">Question Type</label>
                        <select name="type_id" id="type_id" class="custom-input-borderless">
                            @foreach($types as $type)
                            <option value="{{ $type->id }}" @selected($type->id==session('type_id'))>{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="">Line A</label>
                        <input type="text" name='line_a' class="custom-input-borderless" placeholder="Poetry line A" required>
                    </div>
                    <div>
                        <label for="">Line B</label>
                        <input type="text" name='line_b' class="custom-input-borderless" placeholder="Poetry line B" required>
                    </div>
                    <div class="text-right mt-6">
                        <button type="submit" class="btn-green rounded">Create Now</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection