@extends('layouts.basic')

@section('header')
<x-headers.user page="Welcome back!" icon="<i class='bi bi-emoji-smile'></i>"></x-headers.user>
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
                <div>New Paper</div>
            </div>
        </div>
        <div class="md:w-4/5 mx-auto">
            <h1 class="text-xl md:text-3xl text-center mt-5">Paper Generation</h1>
            <img src="{{url('images/small/paper.png')}}" alt="paper" class="w-24 mx-auto mt-3">
            <p class="text-slate-600 leading-relaxed mt-6 text-center">With our automated question paper generation system, educators can effortlessly generate fully customized question papers,
                aligned with curriculum standards and assessment objectives</p>
            <div class="h-1 w-24 bg-teal-800 mx-auto mt-6"></div>

            <h3 class="text-lg mt-8 text-center">Grades / Classes</h3>
            <div class="flex items-center justify-center gap-x-4 mt-5">
                @foreach($grades as $grade)
                <div data-bound='div-{{$grade->id}}' class="round-tab">{{ $grade->grade_no }}</div>
                @endforeach
            </div>
            <div id='messageBeforeGradeSelection' class="flex justify-center items-center text-center p-3 text-teal-500 border mt-8">
                Please select a grade for paper
            </div>

            @if($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            @foreach($grades as $grade)
            <form action="{{ route('user.papers.store') }}" id="div-{{$grade->id}}" class="fold hidden my-5" method="post">
                @csrf
                <div class="grid grid-cols-1 md:w-2/3 mx-auto gap-4">
                    <div>
                        <label for="">Select a book</label>
                        <select name="book_id" id="" class="custom-input-borderless py-1 rounded">
                            @foreach($grade->books as $book)
                            <option value="{{ $book->id }}">{{$book->subject->name_en}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="">Paper Title</label>
                        <input type="text" name="title" class="custom-input-borderless" placeholder="Series Test">
                    </div>
                    <div>
                        <label for="">Paper Date</label>
                        <input type="date" name="paper_date" id='paper_date' class="custom-input-borderless" placeholder="Paper Date" value="{{today()}}->format('m/d/Y')">
                    </div>
                    <div>
                        <button type="submit" class="btn-teal">Next</button>
                    </div>
                </div>
            </form>
            @endforeach

        </div>
    </div>
    @endsection

    @section('script')
    <script type="module">
        $('.round-tab').click(function() {
            $('.round-tab').removeClass('active')
            $(this).addClass('active');
            $('#messageBeforeGradeSelection').hide();
            $('.fold').hide();
            $('#' + $(this).attr('data-bound')).show()

            $('html, body').animate({
                scrollTop: 200
            }, 1000); // 1000 milliseconds = 1 second for the scroll duration

        })
    </script>
    @endsection