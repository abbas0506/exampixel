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
            <a href="{{route('admin.subjects.index')}}">Config</a>
            <i class="bx bx-chevron-right"></i>
            <div>Types</div>
        </div>


        <div class="flex flex-wrap items-center gap-3 text-slate-600 mt-6">
            <a href="{{ route('admin.subjects.index') }}" class="tab">Subjects</a>
            <a href="{{ route('admin.grades.index') }}" class="tab">Grades & Books</a>
            <p class="tab active">Q. Types</p>
            <a href="{{ route('admin.tags.index') }}" class="tab">Chapter Tags</a>
            <a href="{{ route('admin.packages.index') }}" class="tab">Packages</a>
        </div>


        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <div class="container-light">
            <div class="flex items-center">
                <h3 class="text-green-600 bg-green-100 px-3 py-1 rounded-full">Question Types <i class="bx bx-layer"></i></h3>
            </div>
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
</div>
@endsection