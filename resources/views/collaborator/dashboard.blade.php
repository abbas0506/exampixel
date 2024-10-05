@extends('layouts.basic')
@section('header')
<x-headers.user page="Welcome back!" icon="<i class='bi bi-emoji-smile'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.collaborator page='home'></x-sidebars.collaborator>
@endsection

@section('body')
<div class="responsive-container">
    <div class="container">
        <div class="flex flex-row justify-between items-center">
            <div class="bread-crumb">
                <div>Collabrator</div>
                <i class="bx bx-chevron-right"></i>
                <i class="bi-house"></i>
            </div>
            <div class="md:hidden text-slate-500">Welcome back!</div>
        </div>

        <!-- pallets -->
        <div class="div mt-4">
            <a href="" class="pallet-box">
                <div class="flex-1">
                    <div class="title">Approved Questions</div>
                    <div class="flex items-center space-x-4">
                        <div class="h2">{{$questions->whereNotNull('approver_id')->count()}}</div>
                        <div class="text-xs text-slate-600"><i class="bi-arrow-up"></i>{{$questions->whereNotNull('approver_id')->where('approved_at', today())->count()}} </div>
                    </div>
                </div>
                <div class="ico bg-green-100">
                    {{ Auth::user()->coins() }}
                </div>
            </a>

        </div>

        <div class="grid mt-8">
            <div class="md:col-span-2">
                <div class="p-4 bg-white">
                    <div class="flex items-end space-x-4">
                        <img src="{{ asset('images/small/approval.png') }}" alt="approval" class="w-24">
                        <h2>Waiting for your approval</h2>
                    </div>
                    <div class="divider my-3 border-slate-200"></div>
                    <div class="overflow-x-auto mt-4">
                        <table class="table-fixed borderless w-full">
                            <thead>
                                <tr class="">
                                    <th class="w-8">Sr</th>
                                    <th class='w-60 text-left'>Question</th>
                                    <th class='w-6'>Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($questions->whereNull('approver_id')->take(5) as $question) <tr class="tr">
                                    <td>{{ $loop->index+1 }}</td>
                                    <td class=" text-left"><a href="{{route('collaborator.approvables.show',$question)}}" class="link">{{ $question->statement }}</a></td>
                                    <td>{{ $question->type->name }}</td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>
    @endsection