@extends('admin.layouts.master')
@section('title')
    الرئيسية
@endsection

@section('content')
    <!-- ==================================================== -->
    <!-- Start right Content here -->
    <!-- ==================================================== -->
    <div class="page-content">

        <!-- Start Container Fluid -->
        <div class="container-xxl">
            <!-- Start here.... -->
            <div class="card">
                <div class="card-header">
                    <h4> خطط التداول </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-xl-3">
                            <a href="{{ url('admin/plans') }}">
                                <div class="card bg-warning text-white">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 text-start">
                                                <p class="mb-0"> خطط التداول </p>
                                                <h3 class=" mt-1 mb-0 text-white"> @php echo count(\App\Models\admin\Plan::all()); @endphp </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <a href="{{ url('admin/plans') }}">
                                <div class="card bg-primary text-white">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 text-start">
                                                <p class="mb-0"> عدد الاشتراكات الكلي </p>
                                                <h3 class="mt-1 mb-0 text-white"> {{ $countuserinvestments }} </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <div class="card bg-danger text-white">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 text-start">
                                            <p class="mb-0"> قيمة الاستثمارات الكلية </p>
                                            <h3 class="mt-1 mb-0 text-white"> {{ $totalplaninvestments }} دولار </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 text-start">
                                            <p class="mb-0"> نسبة الارباح الكلية </p>
                                            <h3 class="mt-1 mb-0 text-white"> {{ $allprofit__profit_percentage }} % </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row -->


                </div>
            </div>

            <div class="row">
                <!-- Chart 1: نسبة الربح اليومي -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>نسبة الربح اليومي [ اخر ٧ ايام ]</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="dailyProfitChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>نسبة العوائد لكل خطة</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="planReturnsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="card">
                <div class="card-header">
                    <h4> خطط التخزين </h4>
                </div>
                <div class="card-body">
                    <!--  Start Storage InvestMent  -->
                    <div class="row">
                        <div class="col-md-6 col-xl-3">
                            <div class="card bg-info text-light">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 text-start">
                                            <p class="mb-0"> عدد اشتراكات التخزين </p>
                                            <h3 class="mt-1 mb-0 text-light"> {{ $totalcountinvestmentstorage }} </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <div class="card bg-primary text-light">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 text-start">
                                            <p class=" mb-0"> عدد الاشتركات الفعالة </p>
                                            <h3 class=" text-light mt-1 mb-0"> {{ $totalcountinvestmentstorageactive }}
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-3">
                            <div class="card bg-secondary text-light">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 text-start">
                                            <p class="mb-0"> عدد الاشتراكات المنتهية </p>
                                            <h3 class="text-light mt-1 mb-0"> {{ $totalcountinvestmentstoragedisactive }}
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <div class="card bg-black text-light">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 text-start">
                                            <p class=" mb-0"> قيمة التخزين الكلي </p>
                                            <h3 class="text-light mt-1 mb-0"> {{ $suminvestmentstorage }} دولار </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <div class="card bg-blue text-light">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 text-start">
                                            <p class="mb-0"> قيمة التخزين الفعالة </p>
                                            <h3 class="text-light mt-1 mb-0"> {{ $suminvestmentstorageactive }} دولار </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <div class="card bg-danger text-light">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 text-start">
                                            <p class="mb-0"> قيمة التخزين المنتهية </p>
                                            <h3 class="text-light mt-1 mb-0"> {{ $suminvestmentstoragedisactive }} دولار
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row -->

                </div>
            </div>


            <div class="row">
                <!-- Chart 1: عدد اشتراكات التخزين -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>عدد اشتراكات التخزين</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="storageSubscriptionsChart"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Chart 2: قيمة التخزين -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>قيمة التخزين</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="storageValueChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>

    </div>
    <!-- ==================================================== -->
    <!-- End Page Content -->
    <!-- ==================================================== -->
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // تمرير البيانات من الـ Blade إلى الـ JavaScript
        const dailyProfitLabels = @json($dailyProfitLabels);
        const dailyProfitValues = @json($dailyProfitValues);

        // إنشاء الـ Chart
        const dailyProfitChart = new Chart(document.getElementById('dailyProfitChart'), {
            type: 'bar', // يمكنك تغيير النوع إلى 'bar' إذا كنت تريد مخططًا شريطيًا
            data: {
                labels: dailyProfitLabels,
                datasets: [{
                    label: 'نسبة الأرباح اليومية',
                    data: dailyProfitValues,
                    borderColor: '#e67e22',
                    backgroundColor: '#e67e22',
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'نسبة الأرباح اليومية'
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'اليوم'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'نسبة الربح'
                        }
                    }
                }
            }
        });
    </script>
    <script>
        // تمرير البيانات من الـ Blade إلى الـ JavaScript
        const planLabels = @json($planLabels);
        const planValues = @json($planValues);

        // إنشاء الـ Chart
        const planReturnsChart = new Chart(document.getElementById('planReturnsChart'), {
            type: 'pie', // يمكنك تغيير النوع إلى 'bar' إذا كنت تريد مخططًا شريطيًا
            data: {
                labels: planLabels,
                datasets: [{
                    label: 'نسبة العوائد',
                    data: planValues,
                    backgroundColor: [
                        '#36a2eb', // لون الخطة 1
                        '#ff6384', // لون الخطة 2
                        '#4bc0c0', // لون الخطة 3
                        '#ff9f40', // لون إضافي إذا كانت هناك خطط أكثر
                        '#9966ff' // لون إضافي إذا كانت هناك خطط أكثر
                    ],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'نسبة العوائد لكل خطة'
                    }
                }
            }
        });
    </script>
    <!------------------- Start Storage InvestMent  ------------------->
    <script>
        // Chart 1: عدد اشتراكات التخزين
        const storageSubscriptionsChart = new Chart(document.getElementById('storageSubscriptionsChart'), {
            type: 'bar',
            data: {
                labels: ['إجمالي الاشتراكات', 'اشتراكات فعالة', 'اشتراكات منتهية'],
                datasets: [{
                    label: 'عدد الاشتراكات',
                    data: [
                        {{ $totalcountinvestmentstorage }},
                        {{ $totalcountinvestmentstorageactive }},
                        {{ $totalcountinvestmentstoragedisactive }}
                    ],
                    backgroundColor: ['#36a2eb', '#4bc0c0', '#ff6384'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'عدد اشتراكات التخزين'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <script>
        // Chart 2: قيمة التخزين
        const storageValueChart = new Chart(document.getElementById('storageValueChart'), {
            type: 'bar',
            data: {
                labels: ['إجمالي القيمة', 'قيمة فعالة', 'قيمة منتهية'],
                datasets: [{
                    label: 'قيمة التخزين (دولار)',
                    data: [
                        {{ $suminvestmentstorage }},
                        {{ $suminvestmentstorageactive }},
                        {{ $suminvestmentstoragedisactive }}
                    ],
                    backgroundColor: ['#36a2eb', '#4bc0c0', '#ff6384'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'قيمة التخزين'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
