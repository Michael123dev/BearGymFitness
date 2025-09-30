@extends('mms.layout.main')

@section('title', 'Paket')
    
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Paket</h1>
            <button id="add_package_button" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Paket
            </button>
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
                                            <label class="col-md-3 col-form-label" for="package">Nama Paket
                                            </label>
                                            <div class="col-md-9">
                                                <select id="package_id" class="selectpicker form-control" data-live-search="true">
                                                    <option value="">-- Pilih Paket --</option>
                                                </select>
                                                <small id="package_error_text" class="text-danger"></small>
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
                                        <th>Aksi</th>
                                        <th>No</th>
                                        <th>Nama Paket</th>
                                        <th>Jenis</th>
                                        <th>Harga</th>
                                        <th>Diskon (%)</th>
                                        <th>Durasi (Hari)</th>
                                        <th>Tanggal Dibuat</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="add_package_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <h5 class="modal-title" id="staticBackdropLabel">Tambah Paket</h5> --}}
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="add_package_form">
                        <div id="package_section">
                            <h6>
                                <span class="badge badge-pill badge-secondary" style="font-size: 1rem;">
                                    PAKET GYM
                                </span>
                            </h6>
                            <hr>
                            <div class="row">
                                <div class="col-12">

                                    <!-- Jenis Paket -->
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="add_gender">Jenis Paket
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <select id="add_package_type" class="form-control">
                                                <option value="">-- Pilih Jenis Paket --</option>
                                                <option value="DAILY">HARIAN</option>
                                                <option value="MONTHLY">BULANAN</option>
                                            </select>
                                            <small id="add_package_type_error_text" class="text-danger"></small>
                                        </div>
                                    </div>

                                    <!-- Nama Paket -->
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="add_package_name">Nama Paket
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <input id="add_package_name" type="text" class="form-control" placeholder="Nama Paket" autocomplete="off">
                                            <small id="add_package_name_error_text" class="text-danger"></small>
                                        </div>
                                    </div>

                                    <!-- Deskripsi -->
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="add_description">Deskripsi
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <textarea id="add_description" class="form-control" cols="30" rows="10"></textarea>
                                            <small id="add_description_error_text" class="text-danger"></small>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <!-- Harga -->
                                        <label class="col-md-3 col-form-label" for="add_price">Harga
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Rp.</span>
                                                </div>
                                                <input id="add_price" type="text" class="form-control" autocomplete="off" value="0">
                                            </div>
                                            <small id="add_price_error_text" class="text-danger"></small>
                                        </div>

                                        <!-- Diskon -->
                                        <label class="col-md-3 col-form-label" for="add_discount">Diskon</label>
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <input id="add_discount" type="text" class="form-control" autocomplete="off" value="0">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                            <small id="add_discount_error_text" class="text-danger"></small>
                                        </div>
                                    </div>

                                    <!-- Durasi -->
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="add_duration">Durasi
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <input id="add_duration" type="text" class="form-control" autocomplete="off" value="">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Hari</span>
                                                </div>
                                            </div>
                                            <small id="add_duration_error_text" class="text-danger"></small>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <hr>
                        </div>

                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button id="save_button" type="submit" class="btn btn-primary" value="">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detail_user_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                
                <div class="modal-header">
                    <ul class="nav nav-pills card-header-pills" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="profile_tab" data-toggle="pill" href="#profile" role="tab" aria-controls="profile" aria-selected="true">
                                Profil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="attendance_tab" data-toggle="pill" href="#attendance" role="tab" aria-controls="attendance" aria-selected="false">
                                Kehadiran
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="membership_tab" data-toggle="pill" href="#membership" role="tab" aria-controls="membership" aria-selected="false">
                                Riwayat Membership
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="modal-body">
                    <div class="tab-content" id="pills-tabContent">

                        {{-- Profile --}}
                        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile_tab">
                            <div class="row mt-1">
                                <!-- Left Column -->
                                <div class="col-md-6">
                                    <div class="card shadow-xs mb-3 rounded">
                                        <div class="card-body">
                                            <p class="text-muted mb-1">
                                                <i class="fas fa-user mr-2"></i> Nama
                                            </p>
                                            <h5 id="detail_name" class="font-weight-bold text-dark"></h5>
                                        </div>
                                    </div>

                                    <div class="card shadow-xs mb-3 rounded">
                                        <div class="card-body">
                                            <p class="text-muted mb-1">
                                                <i class="fas fa-calendar-alt mr-2"></i> Tanggal Lahir
                                            </p>
                                            <h5 id="detail_birth_date" class="font-weight-bold text-dark"></h5>
                                        </div>
                                    </div>

                                    <div class="card shadow-xs mb-3 rounded">
                                        <div class="card-body">
                                            <p class="text-muted mb-1">
                                                <i class="fas fa-venus-mars mr-2"></i> Jenis Kelamin
                                            </p>
                                            <h5 id="detail_gender" class="font-weight-bold text-dark"></h5>
                                        </div>
                                    </div>

                                    <div class="card shadow-xs mb-3 rounded">
                                        <div class="card-body">
                                            <p class="text-muted mb-1">
                                                <i class="fas fa-phone mr-2"></i> No. HP
                                            </p>
                                            <h5 id="detail_phone" class="font-weight-bold text-dark"></h5>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-6">
                                    <div class="card shadow-xs mb-3 rounded">
                                        <div class="card-body">
                                            <p class="text-muted mb-1">
                                                <i class="fas fa-box-open mr-2"></i> Paket
                                            </p>
                                            <h5 id="detail_package" class="font-weight-bold text-dark"></h5>
                                        </div>
                                    </div>

                                    <div class="card shadow-xs mb-3 rounded">
                                        <div class="card-body">
                                            <p class="text-muted mb-1">
                                                <i class="fas fa-hourglass-end mr-2"></i> Tanggal Berakhir Member
                                            </p>
                                            <h5 id="detail_end_date" class="font-weight-bold text-danger"></h5>
                                        </div>
                                    </div>

                                    <div class="card shadow-xs mb-3 rounded">
                                        <div class="card-body">
                                            <p class="text-muted mb-1">
                                                <i class="fas fa-id-badge mr-2"></i> Status Membership
                                            </p>
                                            <h5 id="detail_membership" class="badge p-2 px-3"></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Attendance --}}
                        <div class="tab-pane fade" id="attendance" role="tabpanel" aria-labelledby="attendance_tab">
                            Attendance
                        </div>

                        {{-- Membership --}}
                        <div class="tab-pane fade" id="membership" role="tabpanel" aria-labelledby="membership_tab">
                            <div class="table-responsive">
                                <table class="table table-hover compact table-condensed table-striped" id="membership_table" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Paket</th>
                                            <th>Jenis Paket</th>
                                            <th>Tanggal Mulai</th>
                                            <th>Tanggal Selesai</th>
                                        </tr>
                                    </thead>
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
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

    function mainTable()
    {
        var mainTable = $("#main_table").DataTable({
            retrieve: true,
            filter: false,
            processing: true,
            serverSide: true,
            stateSave: false,
            ordering: false,
            // scrollY: 500,
            scrollX: true,
            language: {
                paginate: {
                    first: "<i class='fa fa-step-backward'></i>",
                    last: "<i class='fa fa-step-forward'></i>",
                    next: "<i class='fa fa-caret-right'></i>",
                    previous: "<i class='fa fa-caret-left'></i>"
                },
                lengthMenu:     "<div class=\"input-group\">_MENU_ &nbsp; / page</div>",
                info:           "_START_ to _END_ of _TOTAL_ item(s)",
                infoEmpty:      ""
            },
            ajax: {
                'url'       : '{{ route('packages.data') }}',
                'type'      : 'POST',
                'headers'   : { 'X-CSRF-TOKEN': '{!! csrf_token() !!}' },
                'data': function (d) {
                    d.package_id =   $("#package_id").val();
                }
            },
            columns: [
                { data: 'action', name: 'action', orderable: false, searchable: false },
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'package_name', name: 'package_name' },
                { data: 'type', name: 'type' },
                { data: 'price', name: 'price', className: 'text-right'},
                { data: 'discount', name: 'discount', className: 'text-right'},
                { data: 'duration_in_days', name: 'duration_in_days', className: 'text-right'},
                { data: 'created_at', name: 'created_at' }
                // { data: 'membership_status', name: 'membership_status' }
            ],
            order: [[ 1, 'asc' ]],
            rowCallback: function( row, data, iDisplayIndex ) {
                var api = this.api();    
                var info = api.page.info();
                var page = info.page;
                var length = info.length;
                var index = (page * length + (iDisplayIndex +1));
                $('td:eq(1)', row).html(index);
            }
        });
        return mainTable;
    }

    function getAllPackage()
    {
        $.ajax({
            url: "{{ route('packages.get-all-data') }}", // your Laravel route that returns packages as JSON
            type: "GET",
            success: function(response) {
                console.log(response)
                let $select = $("#package_id");
                $select.empty(); // clear old options
                $select.append('<option value="">-- Pilih Paket --</option>');

                // Loop through the data and append options
                $.each(response.data, function(index, package) {
                    $select.append('<option value="' + package.id + '">' + package.type + ' - ' + package.package_name + '</option>');
                });

                // Refresh the selectpicker UI
                $select.selectpicker("refresh");
            },
            error: function() {
                alert("Gagal memuat data paket");
            }
        });

    }

    function clearValidationMessage()
    {
        $("#add_package_name").removeClass("is-invalid");
        $("#add_package_name_error_text").text("");

        $("#add_package_type").removeClass("is-invalid");
        $("#add_package_type_error_text").text("");

        $("#add_description").removeClass("is-invalid");
        $("#add_description_error_text").text("");

        $("#add_price").removeClass("is-invalid");
        $("#add_price_error_text").text("");

        $("#add_discount").removeClass("is-invalid");
        $("#add_discount_error_text").text("");

        $("#add_duration").removeClass("is-invalid");
        $("#add_duration_error_text").text("");
    }

    function validateData(action, packageId = null)
    {
        clearValidationMessage();

        let status      =   true;
        let packageName =   $("#add_package_name").val();
        let packageType =   $("#add_package_type :selected").val();
        let description =   $("#add_description").val();
        let price       =   $("#add_price").val();
        let discount    =   $("#add_discount").val();
        let duration    =   $("#add_duration").val();

        if (!packageName)
        {
            $("#add_package_name").addClass("is-invalid");
            $("#add_package_name_error_text").text("Harap isi filed ini");
            status = false;
        }

        if (!packageType)
        {
            $("#add_package_type").addClass("is-invalid");
            $("#add_package_type_error_text").text("Harap isi filed ini");
            status = false;
        }

        if (!description)
        {
            $("#add_description").addClass("is-invalid");
            $("#add_description_error_text").text("Harap isi filed ini");
            status = false;
        }

        if (!price || price == 0)
        {
            $("#add_price").addClass("is-invalid");
            $("#add_price_error_text").text("Harap isi filed ini");
            status = false;
        }

        if (!duration || duration == 0)
        {
            $("#add_duration").addClass("is-invalid");
            $("#add_duration_error_text").text("Harap isi filed ini");
            status = false;
        }


        return status;
    }
    
    // function showDetail(id)
    // {
    //     packageId = id;
    //     $("#loading_spiner").modal("show");

    //     // add delay to run this ajax
    //     setTimeout(() => {
    //         $.ajax({
    //             type: "GET",
    //             url: "{{ route('users.get-user-profile', ['id' => ':id']) }}".replace(':id', id),
    //             success: function (response) {
    //                 $("#loading_spiner").modal("hide");
    //                 if (response.success)
    //                 {
    //                     let user = response.data;
    //                     $("#detail_name").text(user.name);
    //                     $("#detail_birth_date").text(user.birth_date);
    //                     $("#detail_gender").text(user.gender);
    //                     $("#detail_phone").text(user.phone);
    //                     $("#detail_package").text(user.package_type);
    //                     $("#detail_end_date").text(user.end_date);    
    //                     $("#detail_membership").text(user.membership_status);
    //                     $("#detail_membership").addClass(user.membership_status == 'GUEST' ? 'badge-warning' : (user.membership_status == 'MEMBER' ? 'badge-success' : 'badge-danger'));

    //                     $("#detail_user_modal").modal("show");
    //                 }
    //                 else
    //                 {
    //                     showAlert("error", response.message);
    //                 }
    //             },
    //             error: function (xhr) {
    //                 $("#loading_spiner").modal("hide");
    //                 if (xhr.status === 422) {
    //                     let errors = xhr.responseJSON.errors;
    //                     let errorMessages = Object.values(errors).map(errorArray => errorArray.join(' ')).join(' ');
    //                     // createFlashMessage(errorMessages, "alert-danger");
    //                     showAlert("error", errorMessages);
    //                 } else {
    //                     // createFlashMessage("Terjadi kesalahan pada server", "alert-danger");
    //                     showAlert("error", "Terjadi kesalahan pada server");
    //                 }
    //             }
    //         });
    //     }, 200);
    // }

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

    function refreshAddPackageModal()
    {
        $("#add_package_name").prop("disabled", false);
        $("#add_birth_date").prop("disabled", false);
        $("#add_gender").prop("disabled", false);
        $("#add_price").prop("disabled", false);
        $("#add_email").prop("disabled", false);

        $("#add_package_name").val("");
        $("#add_birth_date").val("");
        $("#add_gender").val("");
        $("#add_price").val("");
        $("#add_email").val("");
        
        // $("#add_package").val("");
        $("#add_package").val("").selectpicker("refresh");
        $("#add_package_type").val("");
        $("#add_start_date").val("");
        $("#add_end_date").val("");
        $("#add_discount").val(0);
        $("#add_price").val(0);
        $("#add_duration").val(0);
        $("#add_payment_method").val("");
        $("#add_total").text("Rp 0");

        
    }

    function showEdit(packageId)
    {
        packageId = packageId;
        action = "EDIT";

        refreshAddPackageModal();
        clearValidationMessage();
        $("#save_button").val(packageId);
        $("#package_section").show();
        $("#membership_section").hide();

        $("#loading_spiner").modal("show");

        setTimeout(() => {
            $.ajax({
                type: "GET",
                url: "{{ route('packages.get-package-by-id', ['id' => ':package_id']) }}".replace(':package_id', packageId),
                success: function (response) {
                    $("#loading_spiner").modal("hide");
                    
                    if (response.success)
                    {
                        let package = response.data;
                        console.log(package)
                        $("#add_package_type").val(package.type);
                        $("#add_package_name").val(package.package_name);
                        $("#add_description").val(package.description);
                        $("#add_description").text(package.description);
                        $("#add_price").val(package.price);
                        $("#add_discount").val(package.discount);
                        $("#add_duration").val(package.duration_in_days);
                        
                        $("#add_package_modal").modal("show");
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
                        showAlert("error", errorMessages);
                    } else {
                        // createFlashMessage("Terjadi kesalahan pada server", "alert-danger");
                        showAlert("error", "Terjadi kesalahan pada server");
                    }
                }
            });
        }, 0);
    }

    function saveEdit(packageId)
    {
        $("#loading_spiner").modal("show");

        $.ajax({
            type: "POST",
            url: "{{ route('packages.update', ':id') }}".replace(':id', packageId),
            data: {
                '_token': "{{ csrf_token() }}",
                '_method': "PUT",
                'package_name': $("#add_package_name").val(),
                'type': $("#add_package_type").val(),
                'description': $("#add_description").val(),
                'price': $("#add_price").val().replace(/\./g, ''),
                'discount': $("#add_discount").val().replace(/\./g, ''),
                'duration_in_days': $("#add_duration").val().replace(/\./g, '')
            },
            dataType: "json",
            success: function (response) {
                $("#loading_spiner").modal("hide");
                if (response.success) {
                    $("#add_package_modal").modal("hide");
                    showAlert("success", response.message);
                    mainTable().ajax.reload();
                    $("#add_package_form")[0].reset();
                    clearValidationMessage();
                } else {
                    showAlert("error", response.message);
                }
            },
            error: function (xhr) {
                $("#loading_spiner").modal("hide");
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        let inputField = $("#add_" + key);
                        let errorTextField = $("#add_" + key + "_error_text");
                        if (inputField.length && errorTextField.length) {
                            inputField.addClass("is-invalid");
                            errorTextField.text(value[0]);
                        }
                    });
                } else {
                    showAlert("error", "Terjadi kesalahan pada server. Silakan coba lagi.");
                }
            }
        });
    }

    function deletePackage(packageId) {
        Swal.fire({
            title: "Yakin untuk hapus?",
            text: "Data paket ini akan dihapus permanen!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('packages.delete', ':id') }}".replace(':id', packageId),
                    data: {
                        '_token': "{{ csrf_token() }}",
                        '_method': "DELETE"
                    },
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            Swal.fire("Terhapus!", response.message, "success");
                            mainTable().ajax.reload();
                        } else {
                            Swal.fire("Gagal!", response.message, "error");
                        }
                    },
                    error: function () {
                        Swal.fire("Error!", "Terjadi kesalahan pada server. Silakan coba lagi.", "error");
                    }
                });
            }
        });
    }



    function addPackage()
    {
        $("#loading_spiner").modal("show");

        $.ajax({
            type: "POST",
            url: "{{ route('packages.store') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                'type': $("#add_package_type :selected").val(),
                'package_name': $("#add_package_name").val(),
                'description': $("#add_description").val(),
                'price': $("#add_price").val().replace(/\./g, ''),
                'discount': $("#add_discount").val().replace(/\./g, ''),
                'duration_in_days': $("#add_duration").val().replace(/\./g, '')
            },
            dataType: "json",
            success: function (response) {

                $("#loading_spiner").modal("hide");
                
                if (response.success)
                {
                    $("#add_package_modal").modal("hide");
                    // createFlashMessage(response.message, "alert-success");
                    showAlert("success", response.message);
                    mainTable().ajax.reload();

                    // reset form
                    $("#add_package_form")[0].reset();
                    clearValidationMessage();
                }
                else
                {
                    $("#add_package_modal").modal("hide");
                    showAlert("error", response.message);
                }
                
                
                
            },
            error: function (xhr) {
                $("#loading_spiner").modal("hide");
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    // Iterate through the errors object and display messages
                    $.each(errors, function (key, value) {
                        let inputField = $("#add_" + key);
                        let errorTextField = $("#add_" + key + "_error_text");
                        if (inputField.length && errorTextField.length) {
                            inputField.addClass("is-invalid");
                            errorTextField.text(value[0]); // Display the first error message
                        }
                    });
                } else {
                    showAlert("error", "Terjadi kesalahan pada server. Silakan coba lagi.");
                }
            }

        });
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
        mainTable();
        getAllPackage();
        
        $(".selectpicker").selectpicker();

        // Tambah Paket
        $("#add_package_button").click(function () { 
            action = "ADD_NEW";

            refreshAddPackageModal();
            clearValidationMessage();
            $("#save_button").val("");
            $("#package_section").show();
            $("#membership_section").hide();
            $("#add_package_modal").modal("show");
        });

        // Run once on load
        // toggleSidebarOnSmallScreens();

        // // Run when window is resized
        // $(window).resize(function () {
        //     toggleSidebarOnSmallScreens();
        // });

        // $("#add_price").val(0);
        // $("#add_discount").val(0);
        // $("#add_duration").val(0);

        $("#add_package_name").on("input", function () {
            this.value = this.value.toUpperCase();
        });

        $("#add_description").on("input", function () {
            this.value = this.value.toUpperCase();
        });

        $("#add_discount, #add_price, #add_duration").on("input", function () {
            // Remove non-digit
            let value = this.value.replace(/\D/g, '');
            // Add thousand separator
            this.value = formatNumber(value);
        });

        $("#search_button").click(function (e) { 
            e.preventDefault();
            closeFlashMessage();
            mainTable().ajax.reload()
        });

        $("#save_button").click(function (e) { 
            e.preventDefault();
            let packageId = $(this).val();
            console.log(packageId);
            console.log(validateData());

            if (action == "ADD_NEW")
            {
                if (validateData(action, packageId))
                {
                    addPackage();
                }

            }
            else
            {
                if (validateData(action, packageId))
                {
                    saveEdit(packageId);
                }

            }
        });

    });
</script>
@endpush