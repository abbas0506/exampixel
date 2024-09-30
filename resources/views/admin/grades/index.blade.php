@extends('layouts.basic')
@section('header')
<x-headers.user page="Config" icon="<i class='bi bi-database-gear'></i>"></x-headers.user>
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
            <div>Tags</div>
        </div>

        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <div class="flex flex-wrap items-center gap-3 text-slate-600 mt-6">
            <a href="{{ route('admin.subjects.index') }}" class="tab">Subjects</a>
            <p class="tab active">Grades & Books</p>
            <a href="{{ route('admin.types.index') }}" class="tab">Q. Types</a>
            <a href="{{ route('admin.tags.index') }}" class="tab">Chapter Tags</a>
            <a href="{{ route('admin.packages.index') }}" class="tab">Packages</a>
        </div>

        <div class="container-light">
            <div class="flex items-center">
                <h3 class="text-green-600 bg-green-100 px-3 py-1 rounded-full">Grades <i class="bi-mortarboard"></i></h3>
            </div>
            <div class="flex items-center flex-wrap justify-between gap-3 mt-4">
                <!-- search -->
                <div class="flex relative w-full md:w-1/3">
                    <input type="text" id='searchby' placeholder="Search ..." class="custom-search w-full" oninput="search(event)">
                    <i class="bx bx-search absolute top-2 right-2"></i>
                </div>
                <a href="{{route('admin.grades.create')}}" class="btn-green rounded">New</a>
            </div>

            <div class="overflow-x-auto">
                <table class="table-fixed w-full mt-3">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="w-16">#</th>
                            <th class="w-40">Name</th>
                            <th class="w-40">Meta</th>
                            <th class="w-20">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($grades as $grade)
                        <tr class="tr">
                            <td>{{$grade->grade_no}}</td>
                            <td class="text-left"> <a href="{{ route('admin.grade.books.index', $grade) }}" class="link"> {{$grade->name}}</a></td>
                            <td class="text-xs font-thin">
                                <i class="bx bx-book"></i> {{ $grade->books->count() }} &nbsp
                                <i class="bi-question-circle"></i> {{ $grade->questions()->count() }}
                                <span class="text-green-600"> <i class="bi-arrow-up"></i>{{ $grade->questions()->today()->count() }}</span>
                            </td>
                            <td>
                                <div class="flex justify-center items-center space-x-3">
                                    <a href="{{route('admin.grades.edit', $grade)}}">
                                        <i class="bx bx-pencil text-green-600"></i>
                                    </a>
                                    <span class="text-slate-400">|</span>
                                    <form action="{{route('admin.grades.destroy',$grade)}}" method="POST" onsubmit="return confirmDel(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-transparent p-0 border-0">
                                            <i class="bx bx-trash text-red-600"></i>
                                        </button>
                                    </form>
                                </div>

                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
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

        function search(event) {
            var searchtext = event.target.value.toLowerCase();
            var str = 0;
            $('.tr').each(function() {
                if (!(
                        $(this).children().eq(1).prop('outerText').toLowerCase().includes(searchtext)
                    )) {
                    $(this).addClass('hidden');
                } else {
                    $(this).removeClass('hidden');
                }
            });
        }
    </script>

    @endsection