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
            <div class="flex items-center gap-3">
                <div class="w-48">
                    <div class="flex justify-between items-center my-1">
                        <label class="">Profile Status</label>
                        <a href="#" class="link text-xs">Complete Now</a>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700">
                        <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full" style="width: 50%"> 50%</div>
                    </div>
                </div>

            </div>
            <!-- <div class="md:hidden text-slate-500">Welcome back!</div> -->
        </div>

        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <!-- pallets -->
        <div class="mt-4">
            <a href="" class="flex items-center pallet-box">
                <div class="flex flex-1 items-center space-x-3">
                    <div>
                        <img src="{{ url('images/small/wallet.png') }}" alt="" class="w-12 h-12">
                    </div>
                    <div>
                        <h2 class="text-slate-600">My Wallet</h2>
                        <label> Expires at: @if(Auth::user()->sales->count()) {{ Auth::user()->sales->max('expiry_at')->format('d/m/Y')}}@endif</label>
                    </div>

                </div>
                <div class="ico bg-green-100 text-green-600">
                    {{ Auth::user()->coins() }}
                </div>
            </a>
        </div>


        <div class="p-4 bg-white mt-6 w-full">
            @if(Auth::user()->papers->count()>0)
            <h2>Recent papers </h2>
            <div class="overflow-x-auto w-full mt-3">
                <table class="table-fixed sm">
                    <thead>
                        <tr>
                            <th class="w-16">Sr</th>
                            <th class="w-96">Title</th>
                            <th class="w-32">Date</th>
                            <th class="w-24">Q.Paper</th>
                            <th class="w-24">Ans Key</th>
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
                            <td><a href="{{route('teacher.papers.pdf.create',$paper)}}"><i class="bi-printer"></i></a></td>
                            <td><a href="{{route('teacher.papers.keys.show',$paper)}}"><i class="bi-key"></i></a></td>
                        </tr>
                        @endforeach
                    </tbody>
                    </thead>
                </table>
            </div>
            @else
            <div class="h-full flex flex-col justify-center items-center">
                <h3 class="text-slate-600">Currently no paper found!</h3>
                <a href="{{ route('teacher.papers.index') }}" class="btn-blue mt-6 rounded">Start Creating Now</a>
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