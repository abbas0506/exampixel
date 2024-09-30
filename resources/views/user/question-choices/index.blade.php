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


        <div class="content-section rounded-lg mt-8 text-sm ">
            <!-- page message -->
            @if ($errors->any())
            <x-message :errors='$errors'></x-message>
            @else
            <x-message></x-message>
            @endif

            <h1>Question Choices</h1>
            <div class="grid md:grid-cols-3 gap-8 mt-6">
                <a href="{{ route('user.papers.questionChoices.show',[$paper,1]) }}" class="bg-slate-100 hover:bg-slate-200 rounded p-4 relative text-xs">
                    <p class="absolute -top-3 left-4 text-sm font-semibold text-green-700">[ MCQ ]</p>
                    <h4 for="font-semibold">Q. Answer any three questions </h4>
                    <div>
                        <p class="mt-1">i. The capital of Pakistan is :</p>
                        <ul class=" flex gap-2 list-inside list-[lower-alpha]">
                            <li>Okara</li>
                            <li>Lahore</li>
                            <li>Islamabad</li>
                            <li>Karachi</li>
                        </ul>
                    </div>

                    <div>
                        <p class="mt-1">ii. The number of provinces are :</p>
                        <ul class=" flex gap-2 list-inside list-[lower-alpha]">
                            <li>Two</li>
                            <li>Three</li>
                            <li>Four</li>
                            <li>Five</li>
                        </ul>
                    </div>
                </a>
                <a href="{{ route('user.papers.questionChoices.show',[$paper,2]) }}" class="bg-slate-100 hover:bg-slate-200 rounded p-4 relative text-xs">
                    <p class="absolute -top-3 left-4 text-sm font-semibold text-violet-600">[ Short ]</p>
                    <h4 for="font-semibold">Q. Answer any three short questions. </h4>
                    <ul class=" flex flex-col list-inside list-[lower-alpha]">
                        <li>Define chemistry?</li>
                        <li>Define organic chemistry?</li>
                        <li>Define molecule</li>
                        <li>Explain molecular forces</li>
                    </ul>

                </a>

                <!-- <a href="{{ route('user.papers.questionChoices.show',[$paper,3]) }}" class="bg-slate-100 hover:bg-slate-200 rounded p-4 relative text-xs">
                    <p class="absolute -top-3 left-4 text-sm">[ Short (double column) ]</p>
                    <h4 for="font-semibold">Q. Answer any five questions </h4>
                    <div class="grid grid-cols-2">
                        <div>
                            <div>a. Define chemistry</div>
                            <div>b. Define molecule</div>
                            <div>c. Define atomic theory</div>
                            <div>d. Define atom</div>
                        </div>
                        <div>
                            <div>e. Define compund</div>
                            <div>f. Define mixture</div>
                            <div>g. Define orbital</div>

                        </div>
                    </div>
                </a> -->

                <a href="{{ route('user.papers.questionChoices.show',[$paper,3]) }}" class="bg-slate-100 hover:bg-slate-200 rounded p-4 relative text-xs">
                    <p class="absolute -top-3 left-4 text-sm font-semibold text-orange-600">[ Long : simple (title + statement) ]</p>
                    <h4 for="font-semibold">Q. Translate the following paragraph </h4>
                    <p>Quaid-e-Azam was a great leader. He was a truthful and brave leader who fought for his nation, sacrified his own career and finally won a separate piece of land. </p>
                </a>

                <a href="{{ route('user.papers.questionChoices.show',[$paper,4]) }}" class="bg-slate-100 hover:bg-slate-200 rounded p-4 relative text-xs">
                    <p class="absolute -top-3 left-4 text-sm font-semibold text-sky-600">[ Long : simple (statement only) ]</p>
                    <div>Q. Explain information network in detail</div>
                    <div>Q. Explain the component of computer in detail</div>
                    <div>Q. What do you know about intenet? Explain</div>
                </a>

                <a href="{{ route('user.papers.questionChoices.show',[$paper,5]) }}" class="bg-slate-100 hover:bg-slate-200 rounded p-4 relative text-xs">
                    <p class="absolute -top-3 left-4 text-sm font-semibold text-emerald-600">[ Long : Partial (optional) ]</p>
                    <div>Q. Write a letter to your father for money <span class="ml-3  font-semibold">OR</span></div>
                    <div class="ml-4">Write an application for fee concession<span class="ml-3  font-semibold">OR</span></div>
                    <div class="ml-4">Write a story on the title "Union is strength"</div>
                </a>

                <a href="{{ route('user.papers.questionChoices.show',[$paper,6]) }}" class="bg-slate-100 hover:bg-slate-200 rounded p-4 relative text-xs">
                    <p class="absolute -top-3 left-4 text-sm font-semibold text-pink-600">[ Long : Partial (mendatory) ]</p>
                    <div>Q. a) Write a note on solid state physics <span class="ml-3">(5)</span></div>
                    <div class="ml-4">b) Convert 2540m in to kilometers<span class="ml-3">(4)</span></div>
                </a>
                <a href="{{ route('user.papers.questionChoices.show',[$paper,7]) }}" class="bg-slate-100 hover:bg-slate-200 rounded p-4 relative text-xs">
                    <p class="absolute -top-3 left-4 text-sm font-semibold text-red-600">[ Long : Partial (vertical) ]</p>
                    <div class="font-semibold">Q. Change the narration of any three </div>
                    <ul class=" flex flex-col list-inside list-[lower-roman]">
                        <li>He eats an apple.</li>
                        <li>You buy a book.</li>
                        <li>Open the door.</li>
                        <li>He may win the match.</li>
                    </ul>
                </a>
                <a href="{{ route('user.papers.questionChoices.show',[$paper,8]) }}" class="bg-slate-100 hover:bg-slate-200 rounded p-4 relative text-xs">
                    <p class="absolute -top-3 left-4 text-sm font-semibold text-violet-600">[ Long : Partial(horizontal) ]</p>
                    <div class="font-semibold">Q. Use the follwoing pair of words into sentences </div>
                    <div class="flex flex-wrap gap-x-3 items-center list-[lower-roman]">
                        <div>i. soul, sole</div>
                        <div>ii. angel, angle</div>
                        <div>iii. root, route</div>
                        <div>iv. access, excess</div>
                    </div>
                </a>
                @if($paper->book->subject->name_en=='English' ||$paper->book->subject->name_en=='Urdu')
                <a href="" class="bg-slate-100 hover:bg-slate-200 rounded p-4 relative text-xs">
                    <p class="absolute -top-3 left-4 text-sm">[ Long : Paraphrasing ]</p>
                    <div class="font-semibold">Q. Paraphrase the following</div>
                    <div class="grid grid-cols-2 gap-x-3">
                        <div>A verse or poetry </div>
                        <div>A verse or poetry </div>
                        <div>A verse or poetry </div>
                        <div>A verse or poetry </div>
                        <div>A verse or poetry </div>
                        <div>A verse or poetry </div>
                        <div>A verse or poetry </div>
                        <div>A verse or poetry </div>
                    </div>
                </a>
                <a href="" class="bg-slate-100 hover:bg-slate-200 rounded p-4 relative text-xs">
                    <p class="absolute -top-3 left-4 text-sm">[ Long : Comprehension ]</p>
                    <div class="font-semibold">Q. Read the paragraph and answer the following</div>
                    <div class="ml-4">Quaid-e-Azam was a great leader. He was a truthful and brave leader who fought for his nation and won a separate piece of land. </div>
                    <ul class=" flex flex-col list-inside list-[lower-alpha]">
                        <li>Who was quaid?</li>
                        <li>Was he a good leader?</li>
                        <li>Was he a brave leader?</li>
                    </ul>
                </a>
                @endif
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