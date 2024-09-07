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
                $roman=new Roman;
                $QNo=1;

                @endphp
                <tbody>
                    @for($i=1; $i<=$rows;$i++) <tr>
                        @for($j=1; $j<=$columns;$j++) @php $QNo=1; @endphp <td class='@if($j!=1) pl-8 @endif'>

                            <table class="w-full">
                                <tbody>

                                    <tr>
                                        <td colspan="2" class="m-0 p-0 font-bold">Govt Higher Secondary School Chak Bedi</td>
                                    </tr>

                                    <tr>
                                        <td colspan="2" class="m-0 p-0">{{$paper->title}} Dated {{$paper->paper_date->format('d/m/Y')}}</td>
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

                                    @foreach($paper->paperQuestions as $paperQuestion)
                                    @if($paperQuestion->type_id==1)
                                    <tr>
                                        <td class="text-left font-bold">Q.{{$QNo++}} {{ $paperQuestion->question_title }}</td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td colspan="2" class="text-left">
                                            <ol class="lower-roman ml-4">
                                                @foreach($paperQuestion->paperQuestionParts as $paperQuestionPart)
                                                <li>
                                                    {{ $paperQuestionPart->question->statement }}
                                                    <ol class="list-horizontal lower-alpha pt-1">
                                                        <li class="text-left w-1-4">a. {{$paperQuestionPart->question->mcq->choice_a}}</li>
                                                        <li class="text-left w-1-4">b. {{$paperQuestionPart->question->mcq->choice_b}}</li>
                                                        <li class="text-left w-1-4">c. {{$paperQuestionPart->question->mcq->choice_c}}</li>
                                                        <li class="text-left w-1-4">d. {{$paperQuestionPart->question->mcq->choice_d}}</li>
                                                    </ol>
                                                </li>
                                                @endforeach
                                            </ol>
                                        </td>
                                    </tr>
                                    @endif <!-- end mcqs -->


                                    <!-- SHORT Questions -->
                                    @if($paperQuestion->type_id==2)
                                    <tr>
                                        <td class="text-left font-bold">Q.{{$QNo++}} {{ $paperQuestion->question_title }}</td>
                                        <td>{{$paperQuestion->necessary_parts}}x2={{$paperQuestion->necessary_parts*2}}</td>
                                    </tr>

                                    <tr>
                                        <td colspan="2" class="text-left">
                                            <ol class="lower-roman ml-4">
                                                @foreach($paperQuestion->paperQuestionParts as $paperQuestionPart)
                                                <li>{{ $paperQuestionPart->question->statement }}</li>
                                                @endforeach
                                            </ol>
                                        </td>
                                    </tr>

                                    @endif <!-- end short -->


                                    <!-- LONG Question -->
                                    @if($paperQuestion->type_id==3)

                                    @if($paperQuestion->display_style=='whole')

                                    @foreach($paperQuestion->paperQuestionParts as $paperQuestionPart)

                                    @if($loop->first)
                                    <tr>
                                        <td class="text-left" colspan="2">
                                            <ul class="list-horizontal w-full font-bold">
                                                <li class="w-8">Q.{{$QNo++}}</li>
                                                <li style='width:90%'>{{ $paperQuestionPart->question->statement }}</li>
                                                <li class="text-right">{{ $paperQuestion->marks }}</li>
                                            </ul>

                                        </td>
                                    </tr>

                                    @else
                                    <tr>
                                        <td class="text-left" colspan="2">
                                            <ul class="list-horizontal w-full">
                                                <li class="w-8"></li>
                                                <li style='width:90%'><span class="font-semibold">OR</span> {{ $paperQuestionPart->question->statement }}</li>
                                                <li class="w-4 text-right"></li>
                                            </ul>

                                        </td>
                                    </tr>
                                    @endif


                                    @endforeach

                                    @endif <!-- end whole long -->

                                    <!-- Partial starts -->
                                    @if($paperQuestion->display_style=='partial')

                                    @php
                                    $alphabets=range('a','z');
                                    @endphp

                                    @foreach($paperQuestion->paperQuestionParts as $paperQuestionPart)


                                    <tr>
                                        <td class="text-left" colspan="2">
                                            <ul class="list-horizontal w-full font-bold">
                                                <li class="w-8">@if($loop->first) Q. {{ $QNo++ }} @endif</li>
                                                <li style='width:90%'>{{ $alphabets[$loop->index] }}). {{ $paperQuestionPart->question->statement }} </li>
                                                <li class="text-right"></li>
                                            </ul>

                                        </td>
                                    </tr>

                                    @endforeach

                                    @endif <!-- end partial  -->


                                    @endif <!-- end long questions -->

                                    @endforeach <!-- end questions -->

                                </tbody>
                            </table>
                            @endif <!-- end if paper has questions -->

                            </td>
                            @endfor
                            </tr>
                            <!-- rowspacing between each row of papers -->
                            <tr>
                                <td class="py-4" colspan="{{$columns}}"></td>
                            </tr>
                            @endfor
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>