\documentclass{exam}
\renewcommand{\thepartno}{\roman{partno}}
\usepackage[{{ $fontSize }}pt]{extsizes}
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
@if ($paper->book->subject->text_direction == 'R')
    \setmainfont{Jameel Noori Nastaleeq.ttf}[Path=/latex/fonts/]
    \renewcommand\thechoice{\ifcase\value{choice}\or ا\or ب\or ج\or د\fi}
    \renewcommand\choicelabel{(\thechoice)}
@else
    \renewcommand{\choicelabel}{(\alph{choice})}
@endif
\newcommand{\cellcontent}{

\begin{center} \large{\uppercase { @if ($paper->institution)
    {{ $paper->institution }}
@else
    Institution Title
@endif }}\\ \small {{ $paper->title }} {{ $paper->paper_date->format('d/m/Y') }}
\end{center} {{ $paper->book->subject->text_direction == 'R' ? $paper->book->subject->name_ur : $paper->book->name }}
\hfill
{{ __('messages.roll_number') }} \# : \_\_\_\_\_\_\_\_\_ \hfill
{{ __('messages.name') }}:
\_\_\_\_\_\_\_\_\_\_\_
\vspace{2mm} \hrule \vspace{2mm} {{ __('messages.marks') }} : {{ $paper->paperQuestions->sum('marks') }} \hfill
{{ __('messages.time') }} :
{{ $paper->suggestedTime() }}
\vspace{2mm}
\hrule \vspace{1mm}
\begin{questions}
@foreach ($paper->paperQuestions as $paperQuestion)
    @if ($paperQuestion->type_name == 'mcq')
        \question{ {{ __('messages.' . $paperQuestion->question_title) }} \hfill {{ $paperQuestion->marks }}
        {{ __('messages.marks') }} }
        \begin{parts}
        @foreach ($paperQuestion->paperQuestionParts as $part)
            \part
            {!! Helper::parseTex($part->question->statement, true) !!}\\
            \begin{oneparchoices}
            \choice {!! Helper::parseAnswer($part->question->mcq->choice_a) !!}
            \choice {!! Helper::parseAnswer($part->question->mcq->choice_b) !!}
            \choice {!! Helper::parseAnswer($part->question->mcq->choice_c) !!}
            \choice {!! Helper::parseAnswer($part->question->mcq->choice_d, true) !!}
            \end{oneparchoices}
        @endforeach
        \end{parts}
    @endif
    @if ($paperQuestion->type_name == 'partial')
        \question{ {{ $paperQuestion->question_title }} \hfill
        {{ $paperQuestion->marks }}
        {{ __('messages.marks') }} }
        \begin{parts}
        @foreach ($paperQuestion->paperQuestionParts as $part)
            \part
            {!! Helper::parseTex($part->question->statement) !!}
        @endforeach
        \end{parts}
        {{-- \hspace{0.5mm} --}}
    @endif
    @if ($paperQuestion->type_name == 3)
        \question{
        {!! Helper::parseTex($paperQuestion->question_title) !!}
        \hfill {{ $paperQuestion->marks }}
        {{ __('messages.marks') }}
        }
        \begin{parts}
        \part
        {!! Helper::parseTex($paperQuestion->paperQuestionParts()->first()->question->statement) !!}
        \end{parts}
    @endif

    @if ($paperQuestion->type_name == 'simple')
        \question{
        @if ($paperQuestion->question_title)
            {!! Helper::parseTex($paperQuestion->question_title) !!}
            \hfill {{ $paperQuestion->marks }}
            {{ __('messages.marks') }} \\
            {!! Helper::parseTex($paperQuestion->paperQuestionParts()->first()->question->statement) !!}
            \begin{parts}
            @foreach ($paperQuestion->paperQuestionParts->first()->question->comprehensions as $comprehension)
                \part
                {!! Helper::parseTex($comprehension->sub_question) !!}
            @endforeach
            \end{parts}
        @else
            {!! Helper::parseTex($paperQuestion->paperQuestionParts()->first()->question->statement) !!}
            \hfill {{ $paperQuestion->marks }}
            {{ __('messages.marks') }}
        @endif
        }
    @endif
    @if ($paperQuestion->type_name == 'simple-or')
        \question{
        @if ($paperQuestion->question_title)
            {!! Helper::parseTex($paperQuestion->question_title) !!}
        @endif
        {!! Helper::parseTex($paperQuestionPart->question->statement) !!}
        @foreach ($paperQuestion->paperQuestionParts as $paperQuestionPart)
            {!! Helper::parseTex($paperQuestionPart->question->statement) !!}
            @if (!$loop->last)
                \textbf{OR} \\
            @endif
        @endforeach
        }
    @endif
    @if ($paperQuestion->type_name == 'simple-and')
        \question{
        @if ($paperQuestion->question_title)
            {!! Helper::parseTex($paperQuestion->question_title) !!}
        @endif
        }
        \begin{parts}
        @forelse ($paperQuestion->paperQuestionParts as $paperQuestionPart)
            \part
            {!! Helper::parseTex($paperQuestionPart->question->statement) !!}
            \hfill {{ $paperQuestionPart->marks }}
        @endforeach
        \end{parts}
    @endif

    @if ($paperQuestion->type_name == 7)
        \question{
        {{ $paperQuestion->question_title }} \hfill
        {{ $paperQuestion->marks }}
        {{ __('messages.marks') }}
        }
        \begin{parts}
        @foreach ($paperQuestion->paperQuestionParts as $paperQuestionPart)
            \part
            {!! Helper::parseTex($paperQuestionPart->question->statement) !!}
            \dotfill {{ $paperQuestionPart->marks }}
        @endforeach
        \end{parts}
    @endif
    @if ($paperQuestion->type_name == 9)
        \question{
        {{ $paperQuestion->question_title }} \hfill
        {{ $paperQuestion->marks }}
        {{ __('messages.marks') }}
        }
        \begin{parts}
        @foreach ($paperQuestion->paperQuestionParts->first()->question->paraphrasings as $stanza)
            \part
            {!! Helper::parseTex($stanza->poetry_line) !!}
        @endforeach
        \end{parts}
    @endif

    @if ($paperQuestion->type_name == 10)
        \question{
        {{ $paperQuestion->question_title }} \hfill
        {{ $paperQuestion->marks }}
        {{ __('messages.marks') }}
        }
        {!! Helper::parseTex($paperQuestion->paperQuestionParts->first()->question->statement) !!}
        \begin{parts}
        @foreach ($paperQuestion->paperQuestionParts->first()->question->comprehensions as $comprehension)
            \part
            {!! Helper::parseTex($comprehension->sub_question) !!}
        @endforeach
        \end{parts}
    @endif
    @if ($paperQuestion->type_name == 'partial-x')
        \question{
        {{ $paperQuestion->question_title }} \hfill
        {{ $paperQuestion->marks }}
        {{ __('messages.marks') }}
        } \\
        \begin{oneparchoices}
        @foreach ($paperQuestion->paperQuestionParts as $paperQuestionPart)
            \choice
            {!! Helper::parseTex($paperQuestionPart->question->statement) !!}
        @endforeach
        \end{oneparchoices}
    @endif
    @if ($paperQuestion->type_name == 'poetry')
        \question{
        {{ $paperQuestion->question_title }} \hfill
        {{ $paperQuestion->marks }}
        {{ __('messages.marks') }}
        }
        \begin{parts}
        @foreach ($paperQuestion->paperQuestionParts->first()->question->paraphrasings as $stanza)
            \part
            {!! Helper::parseTex($stanza->poetry_line) !!}
        @endforeach
        \end{parts}
    @endif
@endforeach
\end{questions}
}
\begin{document}
@if ($paper->book->subject->text_direction == 'R')
    \begin{RTL}
@endif
@if ($rows == 1)
    \cellcontent
@elseif($rows == 2)
    \cellcontent \dotfill \cellcontent
@elseif($rows == 3)
    \cellcontent \dotfill \cellcontent \dotfill \cellcontent
@endif
@if ($paper->book->subject->text_direction == 'R')
    \end{RTL}
@endif
\end{document}
