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
                    <div class="h2">{{$users['values'][0]}} <span class="text-slate-600 ml-4 text-sm"><i class="bi-arrow-up"></i>{{ $users['values'][2] }}</span></div>
                </div>
                <div class="ico bg-indigo-100">
                    <i class="bi bi-people text-indigo-400"></i>
                </div>
            </a>
            <a href="" class="pallet-box">
                <div class="flex-1 ">
                    <div class="title">Papers</div>
                    <div class="flex items-center space-x-4">
                        <div class="h2">120</div>
                        <div class="text-sm text-slate-600"><i class="bi-arrow-up"></i>{{ $paperCount['recent'] }}</div>
                    </div>

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


                <div class="p-4 bg-white border rounded-lg">
                    <h2>Graphical Analysis </h2>
                    <div class="divider my-3 border-slate-200"></div>
                    <!-- <div class="divider my-3 border-slate-200"></div> -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 place-items-center">
                        <div class="w-full h-48">
                            <canvas id="userAnalysisChart"></canvas>
                        </div>
                        <div class="w-full h-48">
                            <canvas id="questionAnalysisChart"></canvas>
                        </div>
                        <div class="w-full h-64">
                            <canvas id="papersLineChart"></canvas>
                        </div>
                        <div class="w-full h-64">
                            <canvas id="dailyPapersChart"></canvas>
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
        var ctx = document.getElementById('userAnalysisChart').getContext('2d');
        var userChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: @json($users['labels']),
                datasets: [{
                    label: 'User Analysis',
                    data: @json($users['values']),
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            boxWidth: 10, // Set the width of the legend box
                            boxHeight: 10, // Set the height of the legend box
                            padding: 16, // Optional: add some padding around the labels
                        }
                    },
                    title: {
                        display: true,
                        text: 'User Ratio'
                    },
                },
            },

        });

        // question analysis chart
        const questionCtx = document.getElementById('questionAnalysisChart').getContext('2d');
        const qChart = new Chart(questionCtx, {
            type: 'doughnut',
            data: {
                labels: @json($questionStat['labels']),
                datasets: [{
                    label: 'Question Analysis',
                    data: @json($questionStat['data']),

                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            boxWidth: 10, // Set the width of the legend box
                            boxHeight: 10, // Set the height of the legend box
                            padding: 16, // Optional: add some padding around the labels
                        }
                    },
                    title: {
                        display: true,
                        text: 'Class Wise Question Count'
                    },
                },

            }
        });

        // papers line chart
        var paperCtx = document.getElementById('papersLineChart').getContext('2d');

        var papersLineChart = new Chart(paperCtx, {
            type: 'line',
            data: {
                labels: @json($weeklyPapers['labels']), // x-axis labels (weeks)
                datasets: [{
                    label: 'Weekly Papers',
                    'data': @json($weeklyPapers['data']),
                    backgroundColor: 'green',
                    borderWidth: 2,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                borderColor: 'green',
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            boxWidth: 10, // Set the width of the legend box
                            boxHeight: 10, // Set the height of the legend box
                            padding: 16, // Optional: add some padding around the labels
                        }
                    },
                    title: {
                        display: true,
                        text: 'Last 8 Weeks Papers Count Analysis'
                    },
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Week'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Papers'
                        }
                    }
                }
            }
        });


        // daily papers chart
        var dailyPaperCtx = document.getElementById('dailyPapersChart').getContext('2d');

        var daily = new Chart(dailyPaperCtx, {
            type: 'line',
            data: {
                labels: @json($days), // Weekday labels (M, T, W, T, F, S, S)
                datasets: [{
                        label: 'Papers',
                        data: @json($paperCounts), // Paper count for each day
                        borderColor: 'rgb(75, 192, 192)',
                        fill: false,
                        backgroundColor: 'rgb(75, 192, 192)',
                        borderWidth: 2,
                        // tension: 0.4 smoothing effect
                    },
                    {
                        label: 'Users',
                        data: @json($registeredCounts), // Paper count for each day
                        borderColor: 'blue',
                        backgroundColor: 'blue',
                        fill: false,
                        borderWidth: 2,
                        // tension: 0.4 smoothing effect
                    },
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            boxWidth: 8, // Set the width of the legend box
                            boxHeight: 8, // Set the height of the legend box
                            padding: 20, // Optional: add some padding around the labels
                        }
                    },
                    title: {
                        display: true,
                        text: 'Last 15 Days Analysis'
                    },
                },

                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Day'
                        },
                        ticks: {
                            autoSkip: true, // Prevent overlapping labels
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Count'
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endsection