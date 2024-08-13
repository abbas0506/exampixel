@extends('layouts.basic')

@section('header')
<x-header></x-header>
@endsection
@section('body')
<div class="w-full md:w-2/3 mx-auto text-center mt-32 px-5">

    <h1 class="text-3xl">SELF TEST</h1>
    <img src="{{url('images/small/mcqs-1.jpg')}}" alt="mcqs" class="w-24 mx-auto">
    <p class="text-slate-600 leading-relaxed mt-6">Self-testing is one of the most effective strategies for exam preparation, as it actively reinforces learning and helps identify areas needing improvement.</p>
    <div class="h-1 w-24 bg-teal-800 mx-auto mt-6"></div>

    <h3 class="text-lg mt-8">Grades / Classes</h3>
    <div class="flex items-center justify-center gap-x-4 mt-5">
        @foreach($grades as $grade)
        <div data-bound='books-{{$grade->id}}' class="round-tab">{{ $grade->grade_no }}</div>
        @endforeach
    </div>
    <div id='messageBeforeGradeSelection' class="flex justify-center items-center text-center p-3 text-teal-500 border mt-8">
        Please select a grade for your test
    </div>

    @foreach($grades as $grade)
    <div id="books-{{$grade->id}}" class="books hidden">
        <div class="flex justify-center items-center text-center p-3 bg-teal-100 rounded-md mt-8 relative">
            Please select one of the following subjects
            <div class="absolute w-4 h-4 transform rotate-45 -bottom-2 left-5 bg-teal-100"></div>
        </div>
        @foreach($grade->books as $book)
        <a href="{{route('self-tests.edit',$book)}}" class="flex p-3 border-b">{{$book->subject->name_en}}</a>
        @endforeach
    </div>
    @endforeach


</div>
@endsection
@section('footer')
<x-footer></x-footer>
@endsection
@section('script')
<script type="module">
    $('.round-tab').click(function() {
        $('.round-tab').removeClass('active')
        $(this).addClass('active');
        $('#messageBeforeGradeSelection').hide();
        $('.books').hide();
        $('#' + $(this).attr('data-bound')).show()

    })
</script>
@endsection