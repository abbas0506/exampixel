<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Answer Key</title>
    <link href="{{public_path('css/pdf_tw.css')}}" rel="stylesheet">
    <!-- <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script> -->

    <style>
        @page {
            margin: 50px 80px 50px 80px;
        }

        .footer {
            position: fixed;
            bottom: 50px;
            left: 30px;
            right: 50px;
            background-color: white;
            height: 50px;
        }

        .page-break {
            page-break-after: always;
        }

        .data tr th,
        .data tr td {
            font-size: 12px;
            text-align: center;
            /* padding-bottom: 2px; */
            border: 0.5px solid;
        }
    </style>
</head>
@php
$roman = config('global.romans');
@endphp

<body>
    <main>
        <div class="custom-container text-xs">
            <!-- <div class="relative">
                <div class="absolute"><img alt="logo" src="{{public_path('/images/logo/school_logo.png')}}" class="w-8"></div>
            </div> -->
            <table class="w-full">
                <tbody>
                    <tr>
                        <td colspan="2" class="text-center m-0 p-0">{{$test->title}}</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center m-0 p-0">{{$test->subject->grade->roman_name}} - {{$test->subject->name}}, Dated: {{$test->test_date->format('d/m/Y')}}</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div style="border-style:solid; border-width:0px 0px 0.5px 0px;"></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="py-2 font-bold">Answer Key</td>
                    </tr>

                </tbody>
            </table>
            <div style="border-style:solid; border-width:0px 0px 0.5px 0px;"></div>

            @if($test->questions->count()>0)
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th class=""></th>
                        <th class="w-12"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($test->questions()->mcqs()->get() as $testQuestion)
                    <tr>
                        <td colspan="2" class="text-left">
                            <ol class="lower-roman ml-4">
                                @foreach($testQuestion->parts as $part)
                                <li>
                                    {{$part->question->question}}
                                    <ol class="list-horizontal lower-alpha pt-1">
                                        <li class="text-left w-1-4 @if($part->question->answer=='a') font-bold @endif">a. {{$part->question->mcq->option_a}}</li>
                                        <li class="text-left w-1-4 @if($part->question->answer=='b') font-bold @endif">b. {{$part->question->mcq->option_b}}</li>
                                        <li class="text-left w-1-4 @if($part->question->answer=='c') font-bold @endif">c. {{$part->question->mcq->option_c}}</li>
                                        <li class="text-left w-1-4 @if($part->question->answer=='d') font-bold @endif">d. {{$part->question->mcq->option_d}}</li>
                                    </ol>
                                </li>
                                @endforeach
                            </ol>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </main>
</body>

</html>