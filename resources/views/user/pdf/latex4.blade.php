\documentclass{exam}
\renewcommand{\thepartno}{\roman{partno}}
\renewcommand{\choicelabel}{\alph{choice})}
\usepackage[{{ $fontSize }}pt]{extsizes}
\usepackage{amsfonts}
\usepackage{mathrsfs}
\usepackage{amsmath}
\usepackage{adjustbox}
\usepackage[left=0.5cm,right=0.5cm,top=0.5cm,bottom=0.5cm,{{ $orientation }},{{ $pageSize }}paper]{geometry}
\usepackage{polyglossia}
\usepackage{fontspec}
\usepackage{bidi}
\setmainlanguage{english}
{{-- @if ($paper->book->subject->text_direction == 'R') --}}
\setotherlanguage{urdu}
\setmainfont{Jameel Noori Nastaleeq.ttf}[Path=/latex/fonts/]
{{-- @endif --}}
\newcommand{\cellcontent}{
\begin{center} \large{\uppercase { @if($paper->institution){{ $paper->institution }}@else Institution Title @endif }}\\ \small {{ $paper->paper_date->format('d/m/Y') }}
\end{center} Subject :{{ $paper->book->name }} \hfill Roll \# : \_\_\_\_\_\_\_\_\_ \hfill Name: \_\_\_\_\_\_\_\_\_\_\_
\vspace{2mm} \hrule \vspace{2mm} Marks : {{ $paper->marks() }} \hfill Time : {{ '02 hours' }} \vspace{2mm}
\hrule \vspace{1mm}
\begin{questions}
@foreach ($paper->paperQuestions as $paperQuestion)
@if ($paperQuestion->type_id == 1)
\question{ {{ $paperQuestion->question_title }} \dotfill {{ $paperQuestion->compulsoryParts() }}
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
({{ $paperQuestion->compulsoryParts() }}x2={{ $paperQuestion->compulsoryParts() * 2 }}) marks }

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
@if ($paperQuestion->question_nature == 'whole')
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
@elseif ($paperQuestion->question_nature == 'partial')
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
\end{questions}
}
\begin{document}
@if ($rows == 1)
\cellcontent
@elseif($rows == 2)
\cellcontent \dotfill \cellcontent
@elseif($rows == 3)
\cellcontent \dotfill \cellcontent \dotfill \cellcontent
@endif
\end{document}