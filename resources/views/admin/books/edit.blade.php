@extends('layouts.basic')
@section('header')
<x-headers.user page="Q. Bank" icon="<i class='bi bi-database-gear'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.admin page='qbank'></x-sidebars.admin>
@endsection

@section('body')
<div class="responsive-container">
    <div class="container">
        <div class="bread-crumb">
            <a href="/">Home</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('admin.grade.books.index',$book->grade)}}"> {{ $book->grade->name }}</a>
            <i class="bx bx-chevron-right"></i>
            <div>Books</div>
            <i class="bx bx-chevron-right"></i>
            <div>Edit</div>
        </div>

        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif
        <div class="container-light">
            <div class="flex items-center">
                <h3 class="text-green-600 bg-green-100 px-3 py-1 rounded-full">Edit Book <i class="bx bx-book"></i></h3>
            </div>
            <div class="flex justify-center items-center mt-16">

                <form action="{{route('admin.grade.books.update', [$book->grade, $book])}}" method='post' class="md:w-2/3">
                    @csrf
                    @method('PATCH')
                    <div class="grid gap-8">
                        <div class="">
                            <label>Book Name</label>
                            <input type="text" name='name' class="custom-input-borderless" placeholder="Enter book name" value="{{ $book->name }}" required>
                        </div>
                        <div class="w-1/2">
                            <label>Grade</label>
                            <select name="grade_id" class="custom-input-borderless">
                                <option value="">...</option>
                                @foreach($grades as $grade)
                                <option value="{{ $grade->id }}" @selected($book->grade_id==$grade->id)>{{ $grade->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-1/2">
                            <label>Subject</label>
                            <select name="subject_id" class="custom-input-borderless" required>
                                <option value="">...</option>
                                @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" @selected($book->subject_id==$subject->id)>{{ $subject->name_en }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="btn-green rounded mt-6">Update</button>
                        </div>

                    </div>
                </form>

            </div>

        </div>
    </div>
</div>
@endsection