<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto Paper</title>
    <link href="{{public_path('css/pdf_tw.css')}}" rel="stylesheet">
    <!-- <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script> -->

    <style>
        @page {
            margin: 30px 50px 30px 50px;
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
        <div class="custom-container">
            <!-- <div class="relative">
                <div class="absolute"><img alt="logo" src="{{public_path('/images/logo/school_logo.png')}}" class="w-8"></div>
            </div> -->
            <table class="{{$fontSize}} w-full">

                @php
                $i=1;
                $j=1;
                @endphp
                <tbody>
                    @for($i=1; $i<=$rows;$i++) <tr>
                        @for($j=1; $j<=$cols;$j++) @php $questionNo=1; @endphp <td class='@if($j!=1) pl-8 @endif'>

                            <table class="w-full">
                                <tbody>
                                    <!-- <tr>
                                        <td colspan="2" class="text-center font-bold m-0 p-0">{{$paper->title}}</td>
                                    </tr> -->
                                    <tr>
                                        <td colspan="2" class="m-0 p-0 font-bold">Govt Higher Secondary School Chak Bedi</td>
                                    </tr>

                                    <tr>
                                        <td colspan="2" class="m-0 p-0">Dated: {{$paper->paper_date->format('d/m/Y')}}</td>
                                    </tr>

                                    <tr>
                                        <td class="text-left">Subject: {{$paper->book->name}}</td>
                                        <td class="text-right">Roll # ______</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div style="border-style:solid; border-width:0px 0px 0.5px 0px;"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Allowed Time: </td>
                                        <td class="text-right">Max Marks: </td>
                                    </tr>

                                </tbody>
                            </table>
                            <div style="border-style:solid; border-width:0px 0px 0.5px 0px;"></div>

                            @if($paper->has('paperQuestions'))
                            <table class="table-auto w-full">
                                <thead>
                                    <tr>
                                        <th class=""></th>
                                        <th class="w-12"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($paper->paperQuestions()->mcqs()->get() as $paperQuestion)
                                    <tr>
                                        <td class="text-left font-bold">Q.{{$questionNo++}} {{ $paperQuestion->question_title }}
                                        </td>
                                        <td>{{$paperQuestion->paperQuestionParts()->count()- $paperQuestion->choices}}x1={{ $paperQuestion->paperQuestionParts()->count()- $paperQuestion->choices}}</td>
                                    </tr>

                                    <tr>
                                        <td colspan="2" class="text-left">
                                            <ol class="lower-roman ml-4">
                                                @foreach($paperQuestion->paperQuestionParts as $part)
                                                <li>
                                                    {{$part->question->statement}}
                                                    <ol class="list-horizontal lower-alpha pt-1">
                                                        <li class="text-left w-1-4">a. {{$part->question->mcq->choice_a}}</li>
                                                        <li class="text-left w-1-4">b. {{$part->question->mcq->choice_b}}</li>
                                                        <li class="text-left w-1-4">c. {{$part->question->mcq->choice_c}}</li>
                                                        <li class="text-left w-1-4">d. {{$part->question->mcq->choice_d}}</li>
                                                    </ol>
                                                </li>
                                                @endforeach
                                            </ol>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @if($paper->paperQuestions()->mcqs()->count()*$paper->paperQuestions()->shorts()->count())
                                    <tr style="border-style:dotted; border-width:0px 0px 1px 0px;">
                                        <td colspan="2"></td>
                                    </tr>
                                    @endif
                                    <!-- SHORT Questions -->
                                    @foreach($paper->paperQuestions()->shorts()->get() as $paperQuestion)

                                    <tr>
                                        <td class="text-left font-bold">Q.{{$questionNo++}} {{ $paperQuestion->question_title }}</td>
                                        <td>marks</td>
                                    </tr>

                                    <tr>
                                        <td colspan="2" class="text-left">
                                            <ol class="lower-roman ml-4">
                                                @foreach($paperQuestion->paperQuestionParts as $part)
                                                <li>{{$part->question->statement}}</li>
                                                @endforeach
                                            </ol>
                                        </td>
                                    </tr>
                                    @endforeach

                                    <!-- LONG Question -->
                                    @foreach($paper->paperQuestions()->longs()->get() as $paperQuestion)

                                    @if($paperQuestion->paperQuestionParts->count()==1)
                                    <tr>
                                        <td class="text-left" colspan="2">

                                            <ul class="list-horizontal w-full font-bold">
                                                <li style='width:90%'>Q.{{$questionNo}} {{$paperQuestion->paperQuestionParts->first()->question->statement}}</li>
                                                <li class="w-4 text-right">{{$paperQuestion->paperQuestionParts->first()->marks}}</li>
                                            </ul>

                                        </td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td class="text-left font-bold" colspan="2">Q.{{$paperQuestion->question_no}} Answer the following</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-left">
                                            <ol class="lower-alpha ml-4">
                                                @foreach($paperQuestion->paperQuestionParts as $part)
                                                <li>
                                                    <ul class="list-horizontal w-full">
                                                        <li style='width:90%'>{{$part->question->statement}}</li>
                                                        <li class="w-4 text-right">{{$part->marks_each}}</li>
                                                    </ul>
                                                </li>
                                                @endforeach
                                            </ol>

                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                            @endif

                            </td>
                            @endfor
                            </tr>
                            <!-- rowspacing between each row of papers -->
                            <tr>
                                <td class="py-4" colspan="{{$cols}}"></td>
                            </tr>
                            @endfor
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>