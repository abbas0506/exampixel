@extends('layouts.teacher')
@section('page-content')
<div class="custom-container">
    <h2>My Tests</h2>
    <div class="bread-crumb">
        <a href="{{url('/')}}">Home</a>
        <div>/</div>
        <div>Tests</div>
        <div>/</div>
        <div>All</div>
    </div>

    <div class="mt-8">
        <!-- search -->
        <div class="flex relative w-full md:w-1/3">
            <input type="text" id='searchby' placeholder="Search ..." class="custom-search w-full" oninput="search(event)">
            <i class="bx bx-search absolute top-2 right-2"></i>
        </div>

        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <div class="flex flex-row items-center justify-between mt-8">
            <div class="text-gray-400">({{ $tests->count() }}) tests found</div>
            <a href="{{route('teacher.tests.create')}}" class="btn-teal rounded-sm">New</a>
        </div>
        @php $sr=1; @endphp
        <div class="overflow-x-auto w-full mt-3">
            <table class="table-fixed w-full">
                <thead>
                    <tr>
                        <th class="w-10">Sr</th>
                        <th class="w-64">Title</th>
                        <th class="w-24">Date</th>
                        <th class="w-24">Ans Key</th>
                        <th class="w-24">Actions</th>
                    </tr>
                <tbody>
                    @php $sr=1; @endphp
                    @foreach(Auth::user()->tests->sortByDesc('id') as $test)
                    <tr class="tr">
                        <td>{{$sr++}}</td>
                        <td class="text-left">
                            <a href="{{route('teacher.tests.show',$test)}}" class="link">{{$test->title}}</a>
                            <br>
                            <label class="text-xs">{{$test->subject->grade->roman_name}}-{{$test->subject->name}}</label>
                        </td>
                        <td>{{$test->test_date->format('d/m/Y')}}</td>
                        <td><a href="{{route('teacher.tests.anskey.show',$test)}}"><i class="bi-file-pdf text-red-400 hover:text-red-600"></i></a></td>
                        <td>
                            <div class="flex items-center justify-center space-x-2">
                                <a href="{{route('teacher.tests.show',$test)}}"><i class="bi-printer"></i></a>
                                <span class="text-slate-300">|</span>
                                <form action="{{route('teacher.tests.destroy',$test)}}" method="post" onsubmit="return confirmDel(event)">
                                    @csrf
                                    @method('DELETE')
                                    <button><i class="bx bx-trash text-red-600"></i></button>
                                </form>
                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    function search(event) {
        // var searchtext = event.target.value.toLowerCase();
        var searchtext = $('#searchby').val().toLowerCase();
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

    function toggleFilterSection() {
        $('#filterSection').slideToggle().delay(500);
    }
</script>
@endsection