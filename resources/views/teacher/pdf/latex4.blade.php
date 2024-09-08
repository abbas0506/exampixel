\documentclass[addpoints,8pt]{exam}
\renewcommand{\thepartno}{\roman{partno}}
\renewcommand{\choicelabel}{\alph{choice})}
{{-- \qformat{\question \dotfill \thepoints} --}}
{{-- \renewcommand\partshook{\hspace{2em}} --}}
\usepackage{amsfonts}
\usepackage{mathrsfs}
\usepackage{amsmath}
\usepackage{adjustbox}
\usepackage[left=1cm,right=1cm,top=1cm,bottom=1cm,{{ $orientation }},{{ $pageSize }}paper]{geometry}
\usepackage{polyglossia}
\usepackage{fontspec}
\usepackage{bidi}
\setmainlanguage{english}
\setotherlanguage{urdu}
\setmainfont{Jameel Noori Nastaleeq.ttf}[Path=/latex/fonts/]
{{-- \setmainfont{Jameel Noori Nastaleeq.ttf}[Path=D:/] --}}
\begin{document}
{{-- \newcommand{\numRows}{3} % Number of rows
\newcommand{\numCols}{4} % Number of columns --}}
{{-- \begin{tabular}{|*{\numCols}{c|}} --}}
{{-- @for ($i = 1; $i <= 3; $i++)
    @for ($j = 1; $j <= 4; $j++) --}}
\begin{center} \large{\uppercase{GHSS Chak Bedi, Pakpattan}}\\ \small {{ $test->paper_date->format('d/m/Y') }}
\end{center} Subject :{{ $test->book->name }} \hfill Roll \# : \_\_\_\_\_\_\_\_\_ \hfill Name: \_\_\_\_\_\_\_\_\_\_\_
\vspace{2mm} \hrule \vspace{2mm} Marks : {{ 100 }} \hfill Time : {{ '02 hours' }} \vspace{2mm}
\hrule \vspace{1mm}
\begin{questions}
@foreach ($test->paperQuestions as $paperQuestion)
    @if ($paperQuestion->type_id == 1)
        \question{ {{ $paperQuestion->question_title }} \dotfill {{ $paperQuestion->paperQuestionParts->count() }}
        marks}
        \begin{parts}
        @foreach ($paperQuestion->paperQuestionParts as $part)
            @if (Helper::hasUrdu($part->question->statement))
                \begin{RTL}
            @endif
            \part
            {!! Helper::parseTex($part->question->statement, true) !!}\\
            \begin{oneparchoices}
            \choice {!! Helper::parseAnswer($part->question->mcq->choice_a) !!}
            \choice {!! Helper::parseAnswer($part->question->mcq->choice_b) !!}
            \choice {!! Helper::parseAnswer($part->question->mcq->choice_c) !!}
            \choice {!! Helper::parseAnswer($part->question->mcq->choice_d, true) !!}
            \end{oneparchoices}
            @if (Helper::hasUrdu($part->question->statement))
                \end{RTL}
            @endif
        @endforeach
        \end{parts}
    @endif
    @if ($paperQuestion->type_id == 2)
        \question{ {{ $paperQuestion->question_title }} \dotfill
        ({{ $paperQuestion->necessary_parts }}x2={{ $paperQuestion->necessary_parts * 2 }}) marks }

        \begin{parts}
        @foreach ($paperQuestion->paperQuestionParts as $part)
            @if (Helper::hasUrdu($part->question->statement))
                \begin{RTL}
            @endif
            \part
            {!! Helper::parseTex($part->question->statement) !!}
            @if (Helper::hasUrdu($part->question->statement))
                \end{RTL}
            @endif
        @endforeach
        \end{parts}

        \hspace{0.5mm}
    @endif
    @if ($paperQuestion->type_id == 3)
        @if ($paperQuestion->display_style == 'whole')
            \question{
            {{-- \begin{parts} --}}
            @foreach ($paperQuestion->paperQuestionParts as $part)
                @if (Helper::hasUrdu($part->question->statement))
                    \begin{RTL}
                @endif
                {{-- \part --}}
                @if (!$loop->first)
                    \textbf{OR}
                @endif
                {!! Helper::parseTex($part->question->statement) !!}
                @if (Helper::hasUrdu($part->question->statement))
                    \end{RTL}
                @endif
            @endforeach
            }

            {{-- \end{parts} --}}
        @elseif ($paperQuestion->display_style == 'partial')
            \titledquestion{Answer the Questions. \dotfill}
            \begin{parts}
            @foreach ($paperQuestion->paperQuestionParts as $part)
                @if (Helper::hasUrdu($part->question->statement))
                    \begin{RTL}
                @endif
                \part
                {!! Helper::parseTex($part->question->statement) !!}
                @if (Helper::hasUrdu($part->question->statement))
                    \end{RTL}
                @endif
            @endforeach
            \end{parts}
        @endif
    @endif
@endforeach
{{-- @foreach ($test->paperQuestions()->long()->get() as $paperQuestion)
    
@endforeach --}}
\end{questions}
{{-- @if ($j < 4)
    &
@else
    \\
@endif
@endfor
@endfor --}}
{{-- \end{tabular} --}}
\end{document}
