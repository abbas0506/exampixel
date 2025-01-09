@extends('layouts.basic')

@section('header')
<x-headers.user page="Users" icon="<i class='bi bi-person-gear'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.admin page='users'></x-sidebars.admin>
@endsection

@section('body')

<div class="responsive-container">
    <div class="container">
        <div class="bread-crumb">
            <a href="{{url('/')}}">Home</a>
            <i class="bx bx-chevron-right"></i>
            <div>User Papers</div>
        </div>

        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <div class="container-light overflow-x-auto px-0">
            <h2>{{ $user->name }}</h2>
            <lable>{{ $user->email }}</label>
                <div class="flex relative w-full md:w-1/3 my-4">
                    <input type="text" id='searchby' placeholder="Search ..." class="custom-search w-full" oninput="search(event)">
                    <i class="bx bx-search absolute top-2 right-2"></i>
                </div>

                <table class="table-fixed w-full text-sm">
                    <thead>
                        <tr>
                            <th class="w-12">Sr</th>
                            <th class="w-36">Subject</th>
                            <th class="w-12">Code</th>
                            <th class="w-12">Marks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($papers as $paper)
                        <tr class="text-sm tr">
                            <td>{{ $loop->index+1 }} </td>
                            <td class="text-left">
                                <a href="{{ route('admin.user.papers.show',[$user,$paper]) }}" class="link">{{ $paper->book->subject->name_en  }} - {{ $paper->book->grade->grade_no }}</a>
                                <br>
                                {{ $paper->created_at}}
                            </td>
                            <td>{{ $paper->id }}</td>
                            <td>{{ $paper->paperQuestions->sum('marks') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
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