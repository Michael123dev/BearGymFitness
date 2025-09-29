@extends('mms.layout.main')

@section('title', 'Paket')
    
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Laporan Transaksi</h1>
        </div>

        <!-- Content Row -->
        <div class="row">
            <!-- Content Column -->
            <div class="col-lg-12 mb-4">

                {{-- Alert --}}
                <div id="alert" class="alert alert-dismissible fade show" role="alert" style="display: none">
                    <span id="alert_message"></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                {{-- Data Filter --}}
                <div class="card shadow mb-4">

                    <a href="#data_filter" class="d-block card-header py-3" data-toggle="collapse"
                        role="button" aria-expanded="true" aria-controls="data_filter">
                        <h6 class="m-0 font-weight-bold text-primary">Data Filter</h6>
                    </a>

                    <div class="collapse show" id="data_filter">
                        <div class="card-body">
                            <form id="search_user_form">
                                <div class="row g-3">
                                    <div class="col-12 col-md-12">

                                        <!-- Paket -->
                                        <div class="form-row align-items-center mb-3">
                                            <label class="col-md-3 col-form-label" for="document_number">No. Invoice
                                            </label>
                                            <div class="col-md-9">
                                                <select id="document_number" class="selectpicker form-control" data-live-search="true">
                                                    <option value="">-- Semua --</option>
                                                </select>
                                                <small id="document_number_error_text" class="text-danger"></small>
                                            </div>
                                        </div>

                                        <!-- Jenis Paket -->
                                        <div class="form-row align-items-center mb-3">
                                            <label class="col-md-3 col-form-label" for="package_type">Jenis Paket
                                            </label>
                                            <div class="col-md-9">
                                                <select id="package_type" class="selectpicker form-control" data-live-search="true">
                                                    <option value="">-- Semua --</option>
                                                </select>
                                                <small id="package_type_error_text" class="text-danger"></small>
                                            </div>
                                        </div>

                                        <!-- Nama Paket -->
                                        <div class="form-row align-items-center mb-3">
                                            <label class="col-md-3 col-form-label" for="package_name">Nama Paket
                                            </label>
                                            <div class="col-md-9">
                                                <select id="package_name" class="selectpicker form-control" data-live-search="true">
                                                    <option value="">-- Semua --</option>
                                                </select>
                                                <small id="package_name_error_text" class="text-danger"></small>
                                            </div>
                                        </div>

                                        <!-- Nama Member -->
                                        <div class="form-row align-items-center mb-3">
                                            <label class="col-md-3 col-form-label" for="member_name">Nama Member
                                            </label>
                                            <div class="col-md-9">
                                                <input id="member_name" type="text" class="form-control" autocomplete="off" placeholder="Nama Member">
                                                <small id="member_name_error_text" class="text-danger"></small>
                                            </div>
                                        </div>
                                        
                                        {{-- Tanggal Pembayaran --}}
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label mb-0" for="payment_date_from">Tanggal Transaksi Dari</label>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <input id="payment_date_from" name="payment_date_from" type="date" class="form-control" value="{{ $threeMonthsBefore }}">
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label mb-0" for="payment_date_to">Tanggal Transaksi Sampai</label>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <input id="payment_date_to" name="payment_date_to" type="date" class="form-control" value="{{ $today }}">
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>

                                        {{-- Metode Pembayaran --}}
                                        <div class="form-row align-items-center mb-3">
                                            <label class="col-md-3 col-form-label" for="payment_method">Metode Pembayaran
                                            </label>
                                            <div class="col-md-9">
                                                <select id="payment_method" class="selectpicker form-control" data-live-search="true">
                                                    <option value="">-- Semua --</option>
                                                    <option value="CASH">CASH</option>
                                                    <option value="TRANSFER">TRANSFER<option>
                                                </select>
                                                <small id="payment_method_error_text" class="text-danger"></small>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col col-md-3">
                                        <button id="search_button" type="submit" class="btn btn-primary" title="search">
                                            <i class="fas fa-search"></i> Cari
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>


                {{-- Main Table --}}
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Paket</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover compact table-condensed table-striped" id="main_table" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        {{-- <th>Aksi</th> --}}
                                        <th>No</th>
                                        <th>Nomor Invoice</th>
                                        <th>Jenis Paket</th>
                                        <th>Nama Paket</th>
                                        <th>Nama Member</th>
                                        <th>Tanggal Pembayaran</th>
                                        <th>Metode Pembayaran</th>
                                        <th>Harga</th>
                                        <th>Diskon (%)</th>
                                        <th>Total Bayar</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th colspan="7" class="text-right">Total:</th>
                                        <th class="text-right"><span id="total"></span></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
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
<script>
    let durationInDays = 0;
    let packageId = 0;
    let action = "";

    function validatePaymentDateTo()
    {
        let paymentDateFrom = $("#payment_date_from").val();
        let paymentDateTo = $("#payment_date_to").val();

        if (paymentDateFrom && paymentDateFrom != "")
        {
            // show boo
            if (paymentDateTo < paymentDateFrom)
            {
                // createFlashMessage("Tanggal lahir sampai tidak valid", "alert-danger");
                showAlert("error", "Tanggal transaksi sampai tidak valid");
                return false;
            }

            // validate payment date to is not more than 3 months from payment date from
            let dateFrom    =   new Date(paymentDateFrom);
            let dateTo      =   new Date(paymentDateTo);
            let diffTime    =   Math.abs(dateTo - dateFrom);
            let diffDays    =   Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 

            if (diffDays > 92) // approx 3 months
            {
                showAlert("error", "Rentang tanggal transaksi maksimal 3 bulan");
                return false;       
            }
        }

        return true;
    }

    // function getTotalPayment()
    // {
    //     $.ajax({
    //         type: "POST",
    //         url: "{{ route('transaction-report.get-total-payment') }}",
    //         data: {
    //             '_token': "{{ csrf_token() }}",
    //             'document_number' : $("#document_number :selected").val(),
    //             'package_type' :   $("#package_type :selected").val(),
    //             'package_name' :   $("#package_name :selected").val(),
    //             'member_name' : $("#member_name").val(),
    //             'payment_date_from' :   $("#payment_date_from").val(),
    //             'payment_date_to' :   $("#payment_date_to").val(),
    //             'payment_method' :   $("#payment_method").val(),
    //         },
    //         dataType: "json",
    //         success: function (response) {
    //             console.log(response)
    //             let total = response.total;
            
    //             // Update footer using DataTables API
    //             $(table.column(7).footer()).html(total);
    //         },
    //         error: function() {
    //             alert("Gagal memuat total pembayaran");
    //         }
    //     });
    // }

    function mainTable()
    {
        var mainTable = $("#main_table").DataTable({
            retrieve: true,
            filter: false,
            processing: true,
            serverSide: true,
            stateSave: false,
            ordering: false,
            scrollX: true,
            language: {
                paginate: {
                    first: "<i class='fa fa-step-backward'></i>",
                    last: "<i class='fa fa-step-forward'></i>",
                    next: "<i class='fa fa-caret-right'></i>",
                    previous: "<i class='fa fa-caret-left'></i>"
                },
                lengthMenu: "<div class=\"input-group\">_MENU_ &nbsp; / page</div>",
                info: "_START_ to _END_ of _TOTAL_ item(s)",
                infoEmpty: ""
            },
            ajax: {
                url: '{{ route('transaction-report.data') }}',
                type: 'POST',
                headers: { 'X-CSRF-TOKEN': '{!! csrf_token() !!}' },
                data: function (d) {
                    d.document_number = $("#document_number").val();
                    d.package_type    = $("#package_type").val();
                    d.package_name    = $("#package_name").val();
                    d.member_name     = $("#member_name").val();
                    d.payment_date_from = $("#payment_date_from").val();
                    d.payment_date_to   = $("#payment_date_to").val();
                    d.payment_method    = $("#payment_method").val();
                },
            },
            columns: [
                { data: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'document_number' },
                { data: 'package_type' },
                { data: 'package_name' },
                { data: 'member_name' },
                { data: 'payment_date' },
                { data: 'payment_method' },
                { data: 'price', className: 'text-right'},
                { data: 'discount', className: 'text-right'},
                { data: 'total_price', className: 'text-right'},
            ],
            order: [[ 1, 'asc' ]],
            rowCallback: function(row, data, iDisplayIndex) {
                var api = this.api();
                var info = api.page.info();
                var index = (info.page * info.length + (iDisplayIndex + 1));
                $('td:eq(0)', row).html(index);
            },
            drawCallback: function(settings) {
                var api = this.api();

                // hit your custom endpoint to get total
                $.ajax({
                    type: "POST",
                    url: "{{ route('transaction-report.get-total-payment') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        document_number: $("#document_number").val(),
                        package_type:    $("#package_type").val(),
                        package_name:    $("#package_name").val(),
                        member_name:     $("#member_name").val(),
                        payment_date_from: $("#payment_date_from").val(),
                        payment_date_to:   $("#payment_date_to").val(),
                        payment_method:    $("#payment_method").val(),
                    },
                    dataType: "json",
                    success: function (response) {
                        let total = response.total ?? 0;
                        // safer way: update footer via DataTables API
                        $(api.column(7).footer()).html(total);
                    }
                });
            }
        });

        return mainTable;
    }

    function getDocumentNumbers()
    {
        $.ajax({
            type: "POST",
            url: "{{ route('transaction-report.get-document-numbers') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                'payment_date_from': $("#payment_date_from").val(),
                'payment_date_to': $("#payment_date_to").val(),
            },
            dataType: "json",
            success: function (response) {
                console.log(response)
                let $select = $("#document_number");
                $select.empty(); // clear old options
                $select.append('<option value="">-- Semua --</option>');

                // Loop through the data and append options
                $.each(response.data, function(index, payment) {
                    $select.append('<option value="' + payment.document_number + '">' + payment.document_number + '</option>');
                });

                // Refresh the selectpicker UI
                $select.selectpicker("refresh");
            },
            error: function() {
                alert("Gagal memuat data nomor invoice");
            }
        });
    }

    function getPackageTypes()
    {
        $.ajax({
            type: "POST",
            url: "{{ route('transaction-report.get-package-types') }}",
            data: {
                '_token': "{{ csrf_token() }}",
            },
            dataType: "json",
            success: function (response) {
                console.log(response)
                let $select = $("#package_type");
                $select.empty(); // clear old options
                $select.append('<option value="">-- Semua --</option>');

                // Loop through the data and append options
                $.each(response.data, function(index, package) {
                    $select.append('<option value="' + package.type + '">' + package.type + '</option>');
                });

                // Refresh the selectpicker UI
                $select.selectpicker("refresh");
            },
            error: function() {
                alert("Gagal memuat jenis paket");
            }
        });
    }

    function getPackageNames()
    {
        $.ajax({
            type: "POST",
            url: "{{ route('transaction-report.get-package-names') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                'package_type': $("#package_type :selected").val()
            },
            dataType: "json",
            success: function (response) {
                console.log(response)
                let $select = $("#package_name");
                $select.empty(); // clear old options
                $select.append('<option value="">-- Semua --</option>');

                // Loop through the data and append options
                $.each(response.data, function(index, package) {
                    console.log(package)
                    $select.append('<option value="' + package.package_name + '">' + package.package_name + '</option>');
                });

                // Refresh the selectpicker UI
                $select.selectpicker("refresh");
            },
            error: function() {
                alert("Gagal memuat nama paket");
            }
        });
    }

    function toggleSidebarOnSmallScreens() 
    {
        if (window.innerWidth < 1024) {
            if (!$("body").hasClass("sidebar-collapsed")) { 
                $("#sidebarToggle").click();
                $(".detail-button").removeClass("mr-1");
            }
        }
        else 
        {
            if ($("body").hasClass("sidebar-collapsed")) 
            { 
                $("#sidebarToggle").click();
                $(".detail-button").addClass("mr-1");
            }
        }
    }
    
    function showAlert(type, message)
    {
        Swal.fire({
            title: message,
            icon: type,
            draggable: false
        });
    }

    function formatNumber(num) 
    {
        return num.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    $(document).ready(function () {
        // getTotalPayment();
        mainTable();
        // getAllPackages();
        getDocumentNumbers();
        getPackageTypes();
        getPackageNames();
        
        $(".selectpicker").selectpicker();

        // Run once on load
        // toggleSidebarOnSmallScreens();

        // // Run when window is resized
        // $(window).resize(function () {
        //     toggleSidebarOnSmallScreens();
        // });

        $("#payment_date_from").change(function () { 
            let paymentDateFrom =  $(this).val();
            $("#payment_date_to").val(paymentDateFrom);
            getDocumentNumbers();

        });

        $("#payment_date_to").change(function () { 
            if(validatePaymentDateTo())
            {
                getDocumentNumbers();
            }
        });

        $("#package_type").change(function (e) { 
            getPackageNames();
            
        });

        $("#search_button").click(function (e) { 
            e.preventDefault();
            console.log('ok')

            if (validatePaymentDateTo())
            {
                // getTotalPayment()
                mainTable().ajax.reload();
                // mainTable().draw();
            }
        });

    });
</script>
@endpush