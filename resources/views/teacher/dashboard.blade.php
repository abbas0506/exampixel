@extends('layouts.basic')
@section('header')
<x-headers.user page="Welcome back!" icon="<i class='bi bi-emoji-smile'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.teacher page='home'></x-sidebars.teacher>
@endsection

@section('body')
<div class="responsive-container">
    <div class="container">
        <div class="flex flex-row justify-between items-center">
            <div class="bread-crumb">
                <div>Dashboard</div>
                <i class="bx bx-chevron-right"></i>
                <i class="bi-house"></i>
            </div>
            <div class="md:hidden text-slate-500">Welcome back!</div>
        </div>

        <!-- pallets -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-8">
            <a href="" class="pallet-box">
                <div class="flex-1">
                    <div class="title">Q. Bank</div>
                    <div class="h2"> <i class="bi-arrow-up"></i></span></div>
                </div>
                <div class="ico bg-green-100">
                    <i class="bi bi-question text-green-600"></i>
                </div>
            </a>
            <a href="{{route('teacher.papers.index')}}" class="pallet-box">
                <div class="flex-1">
                    <div class="title">My Papers</div>
                    <div class="h2">{{ Auth::user()->papers->count() }}</div>
                </div>
                <div class="ico bg-indigo-100">
                    <i class="bi bi-clipboard2 text-indigo-400"></i>
                </div>
            </a>
            <a href="" class="pallet-box">
                <div class="flex-1 ">
                    <div class="title">Course Allocations</div>
                    <div class="h2">%</div>
                </div>
                <div class="ico bg-teal-100">
                    <i class="bi bi-card-checklist text-teal-600"></i>
                </div>
            </a>
            <a href="" class="pallet-box">
                <div class="flex-1">
                    <div class="title">Results</div>
                    <div class="h2"> %</div>
                </div>
                <div class="ico bg-sky-100">
                    <i class="bi bi-graph-up text-sky-600"></i>
                </div>
            </a>
        </div>


        <div class="p-4 bg-white mt-6 w-full">
            @if(Auth::user()->papers->count()>0)
            <h2>Recent papers </h2>
            <div class="overflow-x-auto w-full mt-3">
                <table class="table-fixed xs">
                    <thead>
                        <tr>
                            <th class="w-10">Sr</th>
                            <th class="w-64">Title</th>
                            <th class="w-32">Date</th>
                            <th class="w-20">Q.Paper</th>
                            <th class="w-20">Ans Key</th>
                        </tr>
                    <tbody>
                        @php $sr=1; @endphp
                        @foreach(Auth::user()->papers->sortByDesc('id') as $paper)
                        <tr>
                            <td>{{$sr++}}</td>
                            <td class="text-left">
                                <a href="{{route('teacher.papers.show',$paper)}}" class="link">{{$paper->title}}</a>
                                <br>
                                <label>{{$paper->book->grade->name}}-{{$paper->book->name}}</label>
                            </td>
                            <td>{{$paper->paper_date->format('d/m/Y')}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    </thead>
                </table>
            </div>
            @else
            <div class="h-full flex flex-col justify-center items-center">
                <h3>Currently no paper found!</h3>
                <label for="">Start Now</label>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    function confirmDel(event) {
        event.preventDefault(); // prevent form submit
        var form = event.target; // storing the form

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
                form.submit();
            }
        })
    }
</script>

@endsection