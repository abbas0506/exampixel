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
        <h1 class="text-xl md:text-3xl text-center mt-5">PAPER GENERATION</h1>
        <img src="{{url('images/small/paper.png')}}" alt="paper" class="w-24 mx-auto">
        <p class="text-slate-600 leading-relaxed mt-6 text-center">With our automated question paper generation system, educators can effortlessly generate fully customized question papers,
            aligned with curriculum standards and assessment objectives</p>
        <div class="h-1 w-24 bg-teal-800 mx-auto mt-6"></div>

        <h3 class="text-lg mt-8 text-center">Grades / Classes</h3>
        <div class="flex items-center justify-center gap-x-4 mt-5">
            @foreach($grades as $grade)
            <div data-bound='books-{{$grade->id}}' class="round-tab">{{ $grade->grade_no }}</div>
            @endforeach
        </div>
        <div id='messageBeforeGradeSelection' class="flex justify-center items-center text-center p-3 text-teal-500 border mt-8">
            Please select a grade for paper
        </div>

        @foreach($grades as $grade)
        <div id="books-{{$grade->id}}" class="books hidden">
            <div class="flex justify-center items-center text-center p-3 bg-teal-100 rounded-md mt-8 relative">
                Please select one of the following subjects
                <div class="absolute w-4 h-4 transform rotate-45 -bottom-2 left-5 bg-teal-100"></div>
            </div>
            @foreach($grade->books as $book)
            <a href="{{route('user.papers.edit',$book)}}" class="flex p-3 border-b">{{$book->subject->name_en}}</a>
            @endforeach
        </div>
        @endforeach


    </div>
    @endsection

    @section('script')
    <script type="module">
        $('.round-tab').click(function() {
            $('.round-tab').removeClass('active')
            $(this).addClass('active');
            $('#messageBeforeGradeSelection').hide();
            $('.books').hide();
            $('#' + $(this).attr('data-bound')).show()

            $('html, body').animate({
                scrollTop: 500
            }, 1000); // 1000 milliseconds = 1 second for the scroll duration

        })
    </script>
    @endsection