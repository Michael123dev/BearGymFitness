@extends('mms.layout.main')

@section('title', 'Dashboard')
    
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Welcome, {{ $nickName }}</h1>
        </div>

        @if ($level == 1 && $showAlert)
        <div class="alert {{ $alertColor }} alert-dismissible fade show" role="alert">
            <strong>Perhatian!</strong> {{ $alertMessage }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <!-- Content Row -->
        <div class="row">

            @if ($level > 1)
                
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Pengguna</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUser }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Pendapatan Bulan Ini</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. {{ $totalRevenue }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Member Aktif
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $totalMember }}</div>
                                    </div>
                                    <div class="col">
                                        {{-- <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-danger" role="progressbar"
                                                style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-id-card fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Kedatangan Bulan ini</div>
                                <div id="total_attendance" class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalAttendance }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-sign-in-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Paket</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $detailPackage }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-box fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Personal Trainer</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $trainerName }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dumbbell fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Tanggal Berakhir Member</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $membershipEndDate }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Kedatangan Bulan ini</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalAttendance }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-sign-in-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            @endif


        </div>

        <!-- Content Row -->

        <div class="row">

            @if ($level > 1)
            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Ringkasan Pendapatan</h6>
                        {{-- <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Dropdown Header:</div>
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div> --}}
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="revernue_chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Rentang Usia Pengunjung</h6>
                        {{-- <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Dropdown Header:</div>
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div> --}}
                    </div>

                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2">
                            <canvas id="myPieChart"></canvas>
                        </div>
                        <div class="mt-4 text-center small">
                            <span class="mr-2">
                                <i class="fas fa-circle text-primary"></i> 0-17
                            </span>
                            <span class="mr-2">
                                <i class="fas fa-circle text-info"></i> 18-25
                            </span>
                            <span class="mr-2">
                                <i class="fas fa-circle text-success"></i> 26-35
                            </span>
                            <span class="mr-2">
                                <i class="fas fa-circle text-warning"></i> 36-45
                            </span>
                            <span class="mr-2">
                                <i class="fas fa-circle text-danger"></i> 46+
                            </span>
                        </div>

                    </div>
                </div>
            </div>
            @else
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <!-- Card Header -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Absensi Kehadiran</h6>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body text-center">
                        <div class="mb-4">
                            <i class="fas fa-map-marker-alt fa-3x text-primary"></i>
                            <p class="mt-3 text-muted">Tap tombol di bawah untuk melakukan check-in dengan lokasi Anda saat ini</p>
                        </div>

                        <button id="check_in_button" class="btn btn-lg btn-primary px-4 py-2 shadow-sm">
                            <i class="fas fa-fingerprint mr-2"></i> Check-In Sekarang
                        </button>

                        <!-- Status Message -->
                        <div id="absen-status" class="mt-4"></div>
                    </div>
                </div>
            </div>

            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Ringkasan Kehadiran</h6>
                        {{-- <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Dropdown Header:</div>
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div> --}}
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="attendance_chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            @endif


        </div>

    </div>

    <!-- Loading Spiner -->
    <div id="loading_spiner" class="modal" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content d-flex align-items-center justify-content-center">
                <img src="{{ asset('mms/assets/img/loading-spiner.svg') }}" width="80" alt="">
            </div>
        </div>
    </div>
@endsection

@push('scripts')

@if ($level > 1)
<script>
    function revenueChart(months, revenues)
    {
        var ctxRevenue = document.getElementById("revernue_chart");
        var revenueChart = new Chart(ctxRevenue, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
            label: "Earnings",
            lineTension: 0.3,
            backgroundColor: "rgba(78, 115, 223, 0.05)",
            borderColor: "rgba(78, 115, 223, 1)",
            pointRadius: 3,
            pointBackgroundColor: "rgba(78, 115, 223, 1)",
            pointBorderColor: "rgba(78, 115, 223, 1)",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            data: revenues,
            }],
        },
        options: {
            maintainAspectRatio: false,
            layout: {
            padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0
            }
            },
            scales: {
            xAxes: [{
                time: {
                unit: 'date'
                },
                gridLines: {
                display: false,
                drawBorder: false
                },
                ticks: {
                maxTicksLimit: 7
                }
            }],
            yAxes: [{
                ticks: {
                maxTicksLimit: 2,
                padding: 10,
                // Include a dollar sign in the ticks
                callback: function(value, index, values) {
                    return 'Rp.' + number_format(value);
                }
                },
                gridLines: {
                color: "rgb(234, 236, 244)",
                zeroLineColor: "rgb(234, 236, 244)",
                drawBorder: false,
                borderDash: [2],
                zeroLineBorderDash: [2]
                }
            }],
            },
            legend: {
            display: false
            },
            tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            intersect: false,
            mode: 'index',
            caretPadding: 10,
            callbacks: {
                label: function(tooltipItem, chart) {
                var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                return datasetLabel + ': Rp.' + number_format(tooltipItem.yLabel);
                }
            }
            }
        }
        });
    }

    function ageRangeChart(ageRanges, totalPeople)
    {
        var ctx = document.getElementById("myPieChart");
        var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ageRanges,
            datasets: [{
                data: totalPeople,
                backgroundColor: [
                    '#4e73df', // blue
                    '#1cc88a', // green
                    '#36b9cc', // teal
                    '#f6c23e', // yellow
                    '#e74a3b'  // red
                ],
                hoverBackgroundColor: [
                    '#2e59d9', // darker blue
                    '#17a673', // darker green
                    '#2c9faf', // darker teal
                    '#dda20a', // darker yellow
                    '#be2617'  // darker red
                ],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
            },
            legend: {
                display: false
            },
            cutoutPercentage: 80,
        },
        });
    }

    $(document).ready(function () {
        $.ajax({
            type: "GET",
            url: "{{ route('dashboard.get-admin-dashboard-chart-data') }}",
            dataType: "json",
            success: function (response) {
                revenueChart(response.months, response.revenues);
                ageRangeChart(response.age_ranges, response.total_people);
            }
        });

    });
</script>
@else
<script>
    function showAlert(type, message)
    {
        Swal.fire({
            title: message,
            icon: type,
            draggable: false
        });
    }

    function attendanceChart(months, attendances)
    {
        var ctxRevenue = document.getElementById("attendance_chart");
        var revenueChart = new Chart(ctxRevenue, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
            label: "Attendances",
            lineTension: 0.3,
            backgroundColor: "rgba(78, 115, 223, 0.05)",
            borderColor: "rgba(78, 115, 223, 1)",
            pointRadius: 3,
            pointBackgroundColor: "rgba(78, 115, 223, 1)",
            pointBorderColor: "rgba(78, 115, 223, 1)",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            data: attendances,
            }],
        },
        options: {
            maintainAspectRatio: false,
            layout: {
            padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0
            }
            },
            scales: {
            xAxes: [{
                time: {
                unit: 'date'
                },
                gridLines: {
                display: false,
                drawBorder: false
                },
                ticks: {
                maxTicksLimit: 7
                }
            }],
            yAxes: [{
                ticks: {
                maxTicksLimit: 2,
                padding: 10,
                // Include a dollar sign in the ticks
                callback: function(value, index, values) {
                    return '' + number_format(value);
                }
                },
                gridLines: {
                color: "rgb(234, 236, 244)",
                zeroLineColor: "rgb(234, 236, 244)",
                drawBorder: false,
                borderDash: [2],
                zeroLineBorderDash: [2]
                }
            }],
            },
            legend: {
            display: false
            },
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 14,
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                intersect: false,
                mode: 'index',
                caretPadding: 10,
                callbacks: {
                    label: function(tooltipItem, chart) {
                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                        // return raw attendance without Rp / money format
                        return datasetLabel + ': ' + tooltipItem.yLabel;
                    }
                }
            }

        }
        });
    }

    function checkIn()
    {
        Swal.fire({
            title: "Apakah Anda yakin untuk check-in?",
            text: "Proses ini tidak dapat dibatalkan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya",
            cancelButtonText: "Batal"
            }).then((result) => {
            if (result.isConfirmed) {
                $("#loading_spiner").modal("show");
                
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        $.ajax({
                            url: "{{ route('users.check-in') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                'user_id': null,
                                latitude: position.coords.latitude,
                                longitude: position.coords.longitude
                            },
                            success: function (response) {
        
                                $("#loading_spiner").modal("hide");
                                if (response.success)
                                {
                                    $("#total_attendance").text(response.total_attendance);
                                    showAlert("success", response.message)
                                }
                                else
                                {
                                    showAlert("error", response.message);
                                }
                            },
                            error: function (xhr) {
                                $("#loading_spiner").modal("hide");
                                if (xhr.status === 422) {
                                    let errors = xhr.responseJSON.errors;
                                    let errorMessages = Object.values(errors).map(errorArray => errorArray.join(' ')).join(' ');
                                    // createFlashMessage(errorMessages, "alert-danger");
                                    showAlert("error", errorMessages)
                                } else {
                                    // createFlashMessage("Terjadi kesalahan pada server", "alert-danger");
                                    showAlert("error", "Terjadi kesalahan pada server")
                                }
                            }
                        });
                    }, function (error) {
                        alert("Error getting location: " + error.message);
                    });
                } else {
                    alert("Geolocation is not supported by this browser.");
                }
            }
        });
    }

    $(document).ready(function () {
        $.ajax({
            type: "GET",
            url: "{{ route('dashboard.get-user-dashboard-chart-data') }}",
            dataType: "json",
            success: function (response) {
                attendanceChart(response.months, response.attendances);
            }
        });

        $("#check_in_button").click(function (e) { 
            e.preventDefault();
            checkIn();
        });

    });
</script>
@endif
@endpush
