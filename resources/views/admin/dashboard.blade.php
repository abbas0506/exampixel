@extends('layouts.basic')

@section('header')
<x-headers.user page="Welcome back!" icon="<i class='bi bi-emoji-smile'></i>"></x-headers.user>
@endsection

@section('sidebar')
<x-sidebars.admin page='home'></x-sidebars.admin>
@endsection

@section('body')

<div class="responsive-container">
    <div class="container">
        <div class="flex flex-row justify-between items-center">
            <div class="bread-crumb">
                <div>Admin</div>
                <i class="bx bx-chevron-right"></i>
                <i class="bi-house"></i>
            </div>
            <div class="md:hidden text-slate-500">Welcome back!</div>
        </div>

        <!-- pallets -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('admin.qbank-books.index') }}" class="pallet-box">
                <div class="flex-1">
                    <div class="title">Questions</div>
                    <div class="flex items-center space-x-4">
                        <div class="h2">{{$questions->count()}}</div>
                        @if($questions->where('created_at', today())->count())
                        <div><i class="bi-arrow-up"></i>{{ $questions->where('created_at', today())->count() }}</div>
                        @endif

                    </div>
                </div>
                <div class="ico bg-green-100 text-green-600">
                    <i class="bi bi-question text-green-600"></i>
                </div>
            </a>
            <a href="{{ route('admin.users.index') }}" class="pallet-box">
                <div class="flex-1">
                    <div class="title">Users</div>
                    <div class="h2">{{$users['values'][0]}} <span class="text-slate-600 ml-4"><i class="bi-arrow-up"></i>{{ $users['values'][3] }}</span></div>
                </div>
                <div class="ico bg-indigo-100">
                    <i class="bi bi-people text-indigo-400"></i>
                </div>
            </a>
            <a href="" class="pallet-box">
                <div class="flex-1 ">
                    <div class="title">Recent Subscription</div>
                    <div class="h2">%</div>
                </div>
                <div class="ico bg-teal-100">
                    <i class="bi bi-card-checklist text-teal-600"></i>
                </div>
            </a>
            <a href="" class="pallet-box">
                <div class="flex-1">
                    <div class="title">Recent Payments</div>
                    <div class="h2"> %</div>
                </div>
                <div class="ico bg-sky-100">
                    <i class="bi bi-graph-up text-sky-600"></i>
                </div>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 mt-8 gap-4 rounded">
            <!-- middle panel  -->
            <div class="md:col-span-3">
                <!-- update news  -->
                <div class="p-4 bg-white border rounded-lg">
                    <h2>Graphical Analysis</h2>
                    <div class="divider my-3 border-slate-200"></div>
                    <!-- <div class="divider my-3 border-slate-200"></div> -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="w-full h-full md:h-96">
                            <canvas id="userAnalysisChart"></canvas>
                        </div>
                        <div class="w-full h-full md:h-96">
                            <canvas id="questionAnalysisChart"></canvas>
                        </div>
                    </div>

                </div>

            </div>
            <!-- middle panel end -->
            <!-- right side bar starts -->
            <div class="">
                <div class="bg-white p-4 border rounded-lg">
                    <h2>Profile</h2>
                    <div class="flex flex-col">
                        <div class="flex text-sm mt-4">
                            <div class="w-8"><i class="bi-person"></i></div>
                            <div>{{ Auth::user()->name }}</div>
                        </div>
                        <div class="flex text-sm mt-2">
                            <div class="w-8"><i class="bi-envelope-at"></i></div>
                            <div>{{ Auth::user()->email }}</div>
                        </div>
                        <div class="divider border-blue-200 mt-4"></div>
                        <div class="flex text-sm mt-4">
                            <div class="w-8"><i class="bi-key"></i></div>
                            <a href="{{route('passwords.edit', Auth::user()->id)}}" class="link">Change Password</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('userAnalysisChart').getContext('2d');
        const userChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($users['labels']),
                datasets: [{
                    label: 'User Analysis',
                    data: @json($users['values']),
                    backgroundColor: @json($users['colors']),
                    // borderColor: ['gray'],
                    borderWidth: 1,
                    barPercentage: 0.5,
                    barThickness: 20,
                    maxBarThickness: 32,
                    minBarLength: 2,

                }]
            },
            options: {
                indexAxis: 'x',
                scales: {
                    x: {
                        stacked: true,
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        stacked: true,
                        grid: {
                            display: true
                        },
                        title: {
                            display: false,
                            text: 'Count',
                            padding: 50, // Adjust distance of title from the axis
                        },
                    },

                },
                // show values above bars
                responsive: true,
                plugins: {
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        formatter: (value) => value, // Customize the display format if needed
                        font: {
                            size: 12,
                            // weight: 'bold'
                        },
                        color: '#777'
                    },
                    legend: {
                        display: true,
                        labels: {
                            padding: 20, // Add padding between legend labels and the chart
                            boxWidth: 10, // Width of the legend color box
                            boxHeight: 10, // Height of the legend color box
                        }
                    }

                }

            },
            plugins: [ChartDataLabels] //active the plugin for top labels

        });

        // question analysis chart
        const questionCtx = document.getElementById('questionAnalysisChart').getContext('2d');
        const qChart = new Chart(questionCtx, {
            type: 'bar',
            data: {
                labels: @json($questionStat['labels']),
                datasets: [{
                    label: 'Question Analysis',
                    data: @json($questionStat['data']),
                    backgroundColor: @json($questionStat['colors']),
                    // borderColor: ['gray'],
                    borderWidth: 1,
                    barPercentage: 0.5,
                    barThickness: 20,
                    maxBarThickness: 32,
                    minBarLength: 2,

                }]
            },
            options: {
                indexAxis: 'x',
                scales: {
                    x: {
                        stacked: true,
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        stacked: true,
                        grid: {
                            display: true
                        }
                    },

                },
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            padding: 20, // Add padding between legend labels and the chart
                            boxWidth: 10, // Width of the legend color box
                            boxHeight: 10, // Height of the legend color box
                        }
                    }
                }


            }
        });

    });
</script>
@endsection