@extends('layouts.teacher')
@section('page-content')

<div class="custom-container">
    <h1>Print Setting</h1>
    <div class="bread-crumb">
        <a href="/">Home</a>
        <div>/</div>
        <div>Draft</div>
        <div>/</div>
        <div>Print Setting</div>
    </div>

    <div class="content-section">
        <!-- page message -->
        @if($errors->any())
        <x-message :errors='$errors'></x-message>
        @else
        <x-message></x-message>
        @endif


        <div class="flex flex-col items-center gap-y-2">
            <h2>{{$test->subject->name}} - {{$test->subject->grade->roman_name}} </h2>
            <label>{{$test->title}}</label>

        </div>
        @if($test->questions->count())
        <div class="divider my-3"></div>
        <div class="flex flex-row justify-between items-center w-full">
            <label>Allowed Time: {{$test->getDuration()}}</label>
            <label>Max marks: {{$test->totalMarks()}}</label>
        </div>
        <div class="divider my-3"></div>
        <p class="w-full md:w-3/4 md:text-center mx-auto mb-3 text-sm text-gray-600">Do you know that a careful selction of the following options can save your printing cost by more than 50%. Choose the most appropriate options and optimize your printing cost.</p>
        @endif
        @if($test->questions->count()>0)
        <form action="{{route('teacher.tests.pdf.store',$test)}}" method="post">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-orange-50 rounded p-4">
                    <h3 class="pb-4">Page Size</h3>
                    <div class="flex justify-center items-start gap-x-4">
                        <div class="w-16 h-20 flex justify-center items-center bg-orange-100 border  border-gray-400 relative">
                            <input type="checkbox" name="page_size" value="a4" class="absolute top-1 left-1 page-size" checked>
                            <div class="text-xs">A4</div>
                        </div>
                        <div class="w-16 h-24 flex justify-center items-center bg-orange-100 border border-gray-400 relative">
                            <input type="checkbox" name="page_size" value="legal" class="absolute top-1 left-1 page-size">
                            <div class="text-xs">Legal</div>
                        </div>
                    </div>
                </div>
                <div class="bg-emerald-50 rounded p-4">
                    <h3 class="pb-4">Page Orientation</h3>
                    <div class="flex justify-center items-start gap-x-4">
                        <div class="w-16 h-20 flex justify-center items-center bg-green-100 border border-gray-400 relative">
                            <input type="checkbox" name="page_orientation" value="portrait" class="absolute top-1 left-1 page-orientation">
                            <div class="text-xs">Portrait</div>
                        </div>
                        <div class="w-24 h-16 flex justify-center items-center bg-green-100 border border-gray-400 relative">
                            <input type="checkbox" name="page_orientation" value="landscape" class="absolute top-1 left-1 page-orientation" checked>
                            <div class="text-xs">Landscape</div>
                        </div>
                    </div>
                </div>

                <div class="bg-orange-50 rounded p-4">
                    <h3 class="pb-4">Font Size</h3>
                    <div class="flex justify-center gap-x-4">
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" name="font_size" value="text-base" class="font-size">
                                <div class="text-base">Normal</div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" name="font_size" value="text-sm" class="font-size">
                                <div class="text-sm">Medium</div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" name="font_size" value="text-xs" class="font-size" checked>
                                <div class="text-xs">Small</div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" name="font_size" value="text-xxs" class="font-size">
                                <div class="text-xxs">Extra Small</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 60 25 852 0000 -->
                <div class="bg-emerald-50 rounded p-4">
                    <h3 class="">Question Papers Per Page</h3>
                    <div class="flex flex-col md:flex-row-reverse items-center">
                        <div class="flex flex-col items-center justify-center p-2 w-36">
                            <p class="text-xs">For example</p>
                            <div class="grid grid-cols-3 w-24">
                                <div class="h-8 border"></div>
                                <div class="h-8 border"></div>
                                <div class="h-8 border"></div>
                                <div class="h-8 border"></div>
                                <div class="h-8 border"></div>
                                <div class="h-8 border"></div>
                            </div>
                            <p class="text-xs">3x2</p>
                        </div>
                        <div class="flex flex-1 justify-center items-center gap-x-4">
                            <input type="number" name="cols" id="" value="2" min=1 max=6 class="custom-input w-16" required>
                            <div>x</div>
                            <input type="number" name="rows" id="" value="1" min=1 max=6 class="custom-input w-16" required>
                        </div>
                    </div>

                </div>
                <div class="md:col-span-2 text-center">
                    <button type="submit" class="btn-green">Generate PDF</button>
                </div>
            </div>
        </form>
        @endif

    </div>
</div>
@endsection
@section('script')
<script type="module">
    $('.page-size').change(function() {
        $('.page-size').not(this).prop('checked', false);
    });
    $('.page-orientation').change(function() {
        $('.page-orientation').not(this).prop('checked', false);
    });
    $('.font-size').change(function() {
        $('.font-size').not(this).prop('checked', false);
    });
</script>
@endsection