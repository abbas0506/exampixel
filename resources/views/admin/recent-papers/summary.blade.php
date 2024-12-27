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
            <a href="{{url('admin')}}">Home</a>
            <i class="bx bx-chevron-right"></i>
            <p>Recent Papers</p>
            <i class="bx bx-chevron-right"></i>
            <p>Summary</p>
        </div>

        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <div class="container-light overflow-x-auto px-0">
            <div class="flex flex-wrap items-center gap-3 text-slate-600 text-sm">
                <a href="{{ route('admin.recent-papers.index') }}" class="tab">Recent</a>
                <div class="flex items-center space-x-1">
                    <p class="tab active">Summary</p>
                </div>
            </div>
            <div class="flex relative w-full md:w-1/3 my-4">
                <input type="text" id='searchby' placeholder="Search ..." class="custom-search w-full" oninput="search(event)">
                <i class="bx bx-search absolute top-2 right-2"></i>
            </div>

            <table class="table-fixed w-full text-sm">
                <thead>
                    <tr>
                        <th class="w-12">Sr</th>
                        <th class="w-48">User Name</th>
                        <th class="w-12">#</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr class="text-sm tr">
                        <td>{{$user->id}}</td>
                        <td class="text-left px-3">
                            <div class="relative">
                                @php $today = Carbon::now()->startOfDay(); @endphp
                                {{$user->name}}
                                @if($user->created_at->gte($today))
                                <div class="absolute top-0 -left-1 w-2 h-2 rounded-full bg-green-500"></div>
                                @endif
                            </div>
                            {{ $user->email }}
                        </td>
                        <td>{{ $user->papers->count() }} <span class="ml-1 text-xs text-green-600"><i class="bi-arrow-up"></i>{{ $user->papers()->today()->count() }}</span></td>
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