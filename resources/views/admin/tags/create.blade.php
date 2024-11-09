@extends('layouts.basic')
@section('header')
<x-headers.user page="Data" icon="<i class='bi bi-database-gear'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.admin page='qbank'></x-sidebars.admin>
@endsection

@section('body')
<div class="responsive-container">
    <div class="container">
        <div class="bread-crumb">
            <a href="/">Home</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('admin.packages.index')}}">Config</a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{route('admin.tags.index')}}">Tags</a>
            <i class="bx bx-chevron-right"></i>
            <div>New</div>
        </div>

        <div class="flex flex-wrap items-center gap-3 text-slate-600 mt-6">
            <a href="{{ route('admin.packages.index') }}" class="tab">Packages</a>
            <a href="{{ route('admin.types.index') }}" class="tab">Q. Types</a>
            <p class="tab active">Chapter Tags</p>
        </div>

        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <div class="container-light">
            <div class="flex items-center">
                <h3 class="text-green-600 bg-green-100 px-3 py-1 rounded-full">New Tag <i class="bx bx-paperclip"></i></h3>
            </div>
            <div class="flex justify-center items-center mt-12">
                <!-- page message -->
                <form action="{{route('admin.tags.store')}}" method='post' class="grid md:grid-cols-2 gap-x-12 gap-y-8 md:w-2/3">
                    @csrf
                    <div class="">
                        <label>Sr</label>
                        <input type="number" name='sr' class="custom-input-borderless" placeholder="Enter serial no." value="{{ $nextSr }}" min=0 required>
                    </div>
                    <div class="md:col-span-full">
                        <label>Name</label>
                        <input type="text" name='name' class="custom-input-borderless" placeholder="Enter tag name" value="" required>
                    </div>
                    <div class="md:col-span-full">
                        <button type="submit" class="btn-green rounded mt-6">Create</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
    @endsection