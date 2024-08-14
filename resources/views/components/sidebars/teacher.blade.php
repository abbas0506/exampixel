<aside aria-label="Sidebar" id='sidebar'>
    <div class="flex items-center justify-center w-full mt-16">
        <a href="{{url('/')}}" class="">
            <img alt="logo" src="{{asset('images/logo/exampixel.png')}}" class="w-16">
        </a>
    </div>
    <div class="mt-8 font-bold text-center text-orange-300 uppercase tracking-wide">Exampixel</div>
    <div class="text-xs text-center text-green-600">Teacher Panel</div>

    @if(Auth::user()->roles->count()>1)
    <div class="flex flex-col mt-4 text">
        @foreach(Auth::user()->roles as $role)
        @if($role->name!='teacher')
        <a href="{{ url('switch/as',$role->name) }}" class="btn-teal text-xs font-normal text-center rounded">Switch to {{ $role->name }} </a>
        @endif
        @endforeach

    </div>
    @endif

    <div class="mt-12">
        <ul class="space-y-2">
            <li>
                <a href="{{url('/')}}" class="flex items-center p-2">
                    <i class="bi-house @if($page=='home') current-page @endif"></i>
                    <span class="ml-3">Home</span>
                </a>
            </li>
            <li>
                <a href="" class="flex items-center p-2">
                    <i class="bi bi-calculator @if($page=='account') current-page @endif"></i>
                    <span class="ml-3">My Account</span>
                </a>
            </li>
            <li>
                <a href="{{ route('teacher.papers.index') }}" class="flex items-center p-2">
                    <i class="bi bi-file-earmark-pdf @if($page=='paper') current-page @endif"></i>
                    <span class="ml-3">Generate Paper</span>
                </a>
            </li>

            <li>
                <a href="" class="flex items-center p-2">
                    <i class="bi bi-laptop"></i>
                    <span class="ml-3 text-slate-500">Create Quiz</span>
                </a>
            </li>
            <li>
                <a href="" class="flex items-center p-2">
                    <i class="bi-file-medical"></i>
                    <span class="ml-3 text-slate-500">Feed Result</span>
                </a>
            </li>
            <li>
                <a href="" class="flex items-center p-2">
                    <i class="bi bi-graph-up"></i>
                    <span class="ml-3 text-slate-500">Progress Analysis</span>
                </a>
            </li>

    </div>
</aside>