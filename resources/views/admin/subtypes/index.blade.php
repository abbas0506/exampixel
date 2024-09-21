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
            <div>Sub Types</div>
        </div>

        <div class="flex flex-wrap items-center gap-3 text-slate-600 mt-6">
            <a href="{{ route('admin.config.index') }}" class="tab">Packages</a>
            <a href="{{ route('admin.types.index') }}" class="tab">Question Types</a>
            <p class="tab active">Subtypes</p>
        </div>

        <a href="{{route('admin.subtypes.create')}}" class="fixed bottom-6 right-6 btn-green w-14 h-14 flex justify-center items-center rounded-full text-sm">New</a>
        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif

        <div class="grid grid-col-1 md:grid-cols-2 h-96 border mt-5">
            <div class="grid place-items-center bg-slate-200 p-8">
                <form action="{{ route('admin.book.type.subtypes.store',[0,0]) }}" class="grid gap-3 md:w-3/4">
                    @csrf
                    <select name="book_id" id="" class="custom-input">
                        @foreach($books as $book)
                        <option value="{{ $book->id }}">{{ $book->name }}</option>
                        @endforeach
                    </select>
                    <select name="type_id" id="" class="custom-input">
                        @foreach($types as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn-teal flex items-center"><i class="bi-search mr-2"></i> Search</button>

                </form>
            </div>
            @php $sr=1; @endphp

            <div class="overflow-auto p-4">
                <table class="table-fixed borderless w-full mt-3">
                    <thead>
                        <tr class="tr">
                            <th class="w-8">Sr</th>
                            <th class="w-48">Sub Type</th>
                            <th class="w-12">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($subtypes->sortByDesc('updated_at') as $subtype)
                        <tr class="tr">
                            <td>{{$sr++}}</td>
                            <td class="text-left">{{ $subtype->name }}</td>
                            <td>
                                <div class="flex justify-center items-center space-x-2">
                                    <a href="{{route('admin.subtypes.edit', $subtype)}}">
                                        <i class="bx bx-pencil text-green-600"></i>
                                    </a>
                                    <form action="{{route('admin.subtypes.destroy', $subtype)}}" method="POST" onsubmit="return confirmDel(event)">
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