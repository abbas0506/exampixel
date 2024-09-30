@extends('layouts.basic')

@section('header')
<x-headers.user page="New Paper" icon="<i class='bi bi-file-earmark-text'>
</i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.operator page='paper'></x-sidebars.operator>
@endsection

@section('body')
<div class="responsive-container">
    <div class="container">
        <div class="flex flex-row justify-between items-center">

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
                <a href="{{ route('operator.chapter.questionables.questions.create',[$chapter,1]) }}" class="bg-slate-100 hover:bg-slate-200 rounded p-4 relative text-xs">
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
                <a href="{{ route('operator.chapter.questionables.questions.create',[$chapter,2]) }}" class="bg-slate-100 hover:bg-slate-200 rounded p-4 relative text-xs">
                    <p class="absolute -top-3 left-4 text-sm font-semibold text-violet-600">[ Short ]</p>
                    <h4 for="font-semibold">Q. Answer any three short questions. </h4>
                    <ul class=" flex flex-col list-inside list-[lower-alpha]">
                        <li>Define chemistry?</li>
                        <li>Define organic chemistry?</li>
                        <li>Define molecule</li>
                        <li>Explain molecular forces</li>
                    </ul>

                </a>


                <a href="{{ route('operator.chapter.questionables.questions.create',[$chapter,3]) }}" class="bg-slate-100 hover:bg-slate-200 rounded p-4 relative text-xs">
                    <p class="absolute -top-3 left-4 text-sm font-semibold text-sky-600">[ Long : simple ]</p>
                    <div>Q. Explain information network in detail</div>
                    <div>Q. Explain the component of computer in detail</div>
                    <div>Q. What do you know about intenet? Explain</div>
                </a>

                <a href="{{ route('operator.chapter.questionables.questions.create',[$chapter,4]) }}" class="bg-slate-100 hover:bg-slate-200 rounded p-4 relative text-xs">
                    <p class="absolute -top-3 left-4 text-sm">[ Long : Poetry ]</p>
                    <div class="font-semibold">Q. Paraphrase the following</div>
                    <div class="grid grid-cols-2 gap-x-3">
                        <div>Poetry line or verse </div>
                        <div>Poetry line or verse </div>
                        <div>Poetry line or verse </div>
                        <div>Poetry line or verse </div>
                        <div>Poetry line or verse </div>
                        <div>Poetry line or verse </div>

                    </div>
                </a>
                <a href="{{ route('operator.chapter.questionables.questions.create',[$chapter,5]) }}" class="bg-slate-100 hover:bg-slate-200 rounded p-4 relative text-xs">
                    <p class="absolute -top-3 left-4 text-sm">[ Long : Comprehension ]</p>
                    <div class="font-semibold">Q. Read the paragraph and answer the following</div>
                    <div class="ml-4">Quaid-e-Azam was a brave leader who fought for his nation and won a separate piece of land. </div>
                    <ul class=" flex flex-col list-inside list-[lower-roman] pl-3 mt-1">
                        <li>Who was quaid?</li>
                        <li>Was he a good leader?</li>
                    </ul>
                </a>
            </div>

        </div>
    </div>
    @endsection