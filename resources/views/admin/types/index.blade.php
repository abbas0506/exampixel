@extends('layouts.basic')
@section('header')
<x-headers.user page="Config" icon="<i class='bi bi-gear'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.admin page='config'></x-sidebars.admin>
@endsection

@section('body')
<div class="responsive-container">
    <div class="container">
        <div class="bread-crumb">
            <a href="{{url('/')}}">Home</a>
            <i class="bx bx-chevron-right"></i>
            <div>Config</div>
            <i class="bx bx-chevron-right"></i>
            <div>Types</div>
        </div>


        <div class="flex flex-wrap items-center gap-3 text-slate-600 mt-6">
            <a href="{{ route('admin.config.index') }}" class="tab">Packages</a>
            <p class="tab active">Question Types</p>
            <a href="" class="tab">Subtypes</a>
        </div>

        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <div class="overflow-x-auto w-full mt-6">
            <table class="w-full sm">
                <thead>
                    <tr>
                        <th>Sr</th>
                        <th>Question Type</th>
                    </tr>
                <tbody>
                    @php $sr=1; @endphp
                    @foreach($types as $type)
                    <tr class="text-sm tr">
                        <td>{{$sr++}}</td>
                        <td>{{ $type->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection