\documentclass[8pt]{exam}
\renewcommand{\thepartno}{\arabic{partno}}
\qformat{\thequestiontitle \dotfill \thepoints}
\renewcommand\partshook{\hspace{2em}}
\usepackage{amsfonts}
\usepackage{mathrsfs}
\usepackage{amsmath}
\usepackage{adjustbox}
\usepackage{multicol}
\usepackage[left=1cm,right=1cm,top=1cm,bottom=1cm,{{$orientation}},{{$pageSize}}paper]{geometry}
\usepackage{polyglossia}
\usepackage{fontspec}
\usepackage{bidi}
\setmainlanguage{english}
\setotherlanguage{urdu}
\setmainfont{Jameel Noori Nastaleeq.ttf}[Path=/latex/fonts/]
\begin{document}
\begin{multicols}{{!!$cols!!}}
@for($i = 1; $i <= $cols ; $i++)
    \begin{center} \large{\uppercase{GHSS Chak Bedi, Pakpattan}}\\ \small {{$paper->paper_date->format('d/m/Y')}} \end{center} Subject :{{$paper->book->name}} \hfill Roll \# : \_\_\_\_\_\_\_\_\_ \hfill Name: \_\_\_\_\_\_\_\_\_\_\_ \vspace{2mm} \hrule \vspace{2mm} Marks : 20 \hfill Time : 30 \vspace{2mm} \hrule \vspace{1mm} \begin{questions} @foreach($paper->paperQuestions()->mcqs()->get() as $paperQuestion)
    \titledquestion{Encircle the correct option}[{{$paperQuestion->question_title}}]
    {{$paperQuestion->question_title}}

    \begin{parts}
    @foreach($paperQuestion->paperQuestionParts as $part)

    @if(Helper::hasUrdu($part->question->statement)) \begin{RTL} @endif
    \part
    {!! Helper::parseTex($part->question->statement, true) !!}\\
    \begin{oneparchoices}
    \choice {!! Helper::parseAnswer($part->question->mcq->choice_a) !!}
    \choice {!! Helper::parseAnswer($part->question->mcq->choice_b) !!}
    \choice {!! Helper::parseAnswer($part->question->mcq->choice_c) !!}
    \choice {!! Helper::parseAnswer($part->question->mcq->choice_d,true) !!}
    \end{oneparchoices}
    @if(Helper::hasUrdu($part->question->statement)) \end{RTL} @endif
    @endforeach
    \end{parts}
    @endforeach

    @foreach($paper->paperQuestions()->shorts()->get() as $paperQuestion)
    \titledquestion{{$paperQuestion->question_title}}
    \begin{parts}
    @foreach($paperQuestion->paperQuestionParts as $part)
    @if(Helper::hasUrdu($part->question->statement)) \begin{RTL} @endif
    \part
    {!! Helper::parseTex($part->question->statement)!!}
    @if(Helper::hasUrdu($part->question->statement)) \end{RTL} @endif
    @endforeach
    \end{parts}
    @endforeach


    @if($i < $cols)
        \columnbreak
        @endif
        \end{questions}
        @endfor
        \end{multicols}
        \end{document}