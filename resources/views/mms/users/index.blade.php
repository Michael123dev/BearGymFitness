@extends('mms.layout.main')

@section('title', 'Pengguna')
    
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Pengguna</h1>
            <button id="register_user_button" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Pengguna
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

                                        <!-- Nama -->
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label mb-0" for="name">Nama Lengkap</label>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <input id="name" name="name" type="text" class="form-control" placeholder="Nama Lengkap" autocomplete="off">
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>

                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label mb-0" for="birth_date_from">Tanggal Lahir Dari</label>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <input id="birth_date_from" name="birth_date_from" type="date" class="form-control">
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label mb-0" for="birth_date_to">Tanggal Lahir Sampai</label>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <input id="birth_date_to" name="birth_date_to" type="date" class="form-control">
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>

                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label mb-0" for="gender">Jenis Kelamin</label>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <select id="gender" name="gender" class="form-control">
                                                        <option value="ALL">-- Semua --</option>
                                                        <option value="L">LAKI-LAKI</option>
                                                        <option value="P">PEREMPUAN</option>
                                                    </select>
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>

                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label mb-0" for="email">Nomor HP</label>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <input id="phone" name="phone" type="text" class="form-control" placeholder="Nomor HP" autocomplete="off">
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>

                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label mb-0" for="expired_date_from">Tanggal Berakhir Dari</label>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <input id="expired_date_from" name="expired_date_from" type="date" class="form-control">
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label mb-0" for="expired_date_to">Tanggal Berakhir Sampai</label>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <input id="expired_date_to" name="expired_date_to" type="date" class="form-control">
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>

                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label mb-0" for="membership_status">Status Membership</label>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <select id="membership_status" name="membership_status" class="form-control">
                                                        <option value="ALL">-- Semua --</option>
                                                        <option value="MEMBER">MEMBER</option>
                                                        <option value="GUEST">GUEST</option>
                                                        <option value="EXPIRED">EXPIRED</option>
                                                    </select>
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col col-md-3">
                                                <button id="search_button" type="submit" class="btn btn-primary" title="search">
                                                    <i class="fas fa-search"></i> Cari
                                                </button>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>


                {{-- Main Table --}}
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Pengguna</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover compact table-condensed table-striped" id="main_table" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Aksi</th>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Jenis Kelamin</th>
                                        <th>No. HP</th>
                                        <th>Tanggal Bergabung</th>
                                        <th>Tanggal Berakhir Member</th>
                                        <th>Status Membership</th>
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
    <div class="modal fade" id="add_user_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <h5 class="modal-title" id="staticBackdropLabel">Tambah Pengguna</h5> --}}
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="add_user_form">
                        <div id="profile_section">
                            <h6>
                                <span class="badge badge-pill badge-secondary" style="font-size: 1rem;">
                                    DATA DIRI
                                </span>
                            </h6>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <!-- Nama -->
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="add_name">Nama Lengkap
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <input id="add_name" type="text" class="form-control" placeholder="Nama Lengkap" autocomplete="off">
                                            <small id="add_name_error_text" class="text-danger"></small>
                                        </div>
                                    </div>

                                    <!-- Tanggal Lahir -->
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="add_birth_date">Tanggal Lahir
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <input id="add_birth_date" type="date" class="form-control">
                                            <small id="add_birth_date_error_text" class="text-danger"></small>
                                        </div>
                                    </div>

                                    <!-- Gender -->
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="add_gender">Jenis Kelamin
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <select id="add_gender" class="form-control">
                                                <option value="">-- Pilih Jenis Kelamin --</option>
                                                <option value="L">LAKI-LAKI</option>
                                                <option value="P">PEREMPUAN</option>
                                            </select>
                                            <small id="add_gender_error_text" class="text-danger"></small>
                                        </div>
                                    </div>

                                    <!-- Nomor HP -->
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="add_phone">Nomor HP
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <input id="add_phone" type="text" class="form-control" placeholder="Nomor HP" autocomplete="off">
                                            <small id="add_phone_error_text" class="text-danger"></small>
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="add_email">Email
                                        </label>
                                        <div class="col-md-9">
                                            <input id="add_email" name="email" type="email" class="form-control" placeholder="Email" autocomplete="off">
                                            <small id="add_email_error_text" class="text-danger"></small>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <hr>
                        </div>

                        <div id="membership_section">
                            <h6>
                                <span class="badge badge-pill badge-secondary" style="font-size: 1rem;">
                                    PAKET MEMBERSHIP
                                </span>
                            </h6>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <!-- Paket -->
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="add_package">Pilihan Paket
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <select id="add_package" class="selectpicker form-control" data-live-search="true">
                                                <option value="">-- Pilih Paket --</option>
                                                @foreach ($packages as $package)
                                                    <option value="{{ $package->id }}">{{ $package->type }} - {{ $package->package_name }}</option>
                                                @endforeach
                                            </select>
                                            <small id="add_package_error_text" class="text-danger"></small>
                                        </div>
                                    </div>

                                    <!-- Jenis Paket -->
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="add_package">Jenis Paket
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <input id="add_package_type" type="text" class="form-control" name="" disabled>
                                            <small id="add_package_type_error_text" class="text-danger"></small>
                                        </div>
                                    </div>

                                    <!-- Tanggal Mulai -->
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="add_start_date">Tanggal Mulai
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-3">
                                            <input id="add_start_date" type="date" class="form-control">
                                            <small id="add_start_date_error_text" class="text-danger"></small>
                                        </div>
                                        <label class="col-md-3 col-form-label" for="add_end_date">Tanggal Selesai
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-3">
                                            <input id="add_end_date" type="date" class="form-control" readonly>
                                            <small id="add_end_date_error_text" class="text-danger"></small>
                                        </div>
                                    </div>

                                    <!-- Personal Trainer -->
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="add_trainer">Personal Trainer
                                        </label>
                                        <div class="col-md-9">
                                            <select id="add_trainer" class="selectpicker form-control" data-live-search="true">
                                                <option value="">-- Pilih Personal Trainer --</option>
                                                @foreach ($trainers as $trainer)
                                                    <option value="{{ $trainer->id }}">{{ $trainer->trainer_code }} - {{ $trainer->name }}</option>
                                                @endforeach
                                            </select>
                                            <small id="add_trainer_error_text" class="text-danger"></small>
                                        </div>
                                    </div>

                                    <!-- Trainer -->
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="add_is_special_discount">Ada Diskon Khusus
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <select id="add_is_special_discount" class="form-control">
                                                <option value="NO">TIDAK</option>
                                                <option value="YES">YA</option>
                                            </select>
                                            <small id="add_is_special_discount_error_text" class="text-danger"></small>
                                        </div>
                                    </div>

                                    <!-- Harga -->
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="add_price">Harga
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Rp.</span>
                                                </div>
                                                <input id="add_price" type="text" class="form-control">
                                            </div>
                                            <small id="add_price_error_text" class="text-danger"></small>
                                        </div>
                                        <label class="col-md-3 col-form-label" for="add_end_date">Diskon (%)
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <input id="add_discount" type="text" class="form-control" disabled>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                            <small id="add_discount_error_text" class="text-danger"></small>
                                        </div>
                                    </div>

                                    <!-- Metode Pembayaran -->
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="payment_method">Metode Pembayaran
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <select id="add_payment_method" name="payment_method" class="form-control">
                                                <option value="">-- Pilih Metode Pembayaran --</option>
                                                <option value="CASH">CASH</option>
                                                <option value="TRANSFER">TRANSFER</option>
                                            </select>
                                            <small id="add_payment_method_error_text" class="text-danger"></small>
                                        </div>
                                    </div>
                                    <hr>
                                    {{-- Total Bayar --}}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="d-flex justify-content-start">
                                                {{-- <h5 class="font-weight-bold">Total</h5> --}}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex justify-content-end">
                                                <h5 class="font-weight-bold">Total : 
                                                    <span id="add_total" class="badge badge-pill badge-warning" style="font-size: 1.5rem;">
                                                        Rp 0
                                                    </span>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                        {{-- <li class="nav-item">
                            <a class="nav-link" id="attendance_tab" data-toggle="pill" href="#attendance" role="tab" aria-controls="attendance" aria-selected="false">
                                Kehadiran
                            </a>
                        </li> --}}
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
                                            <button id="deactivate_membership_button" class="btn btn-sm badge p-2 px-3 btn-danger" style="display: none;">NON AKTIFKAN</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Attendance --}}
                        {{-- <div class="tab-pane fade" id="attendance" role="tabpanel" aria-labelledby="attendance_tab">
                            Attendance
                        </div> --}}

                        {{-- Membership --}}
                        <div class="tab-pane fade" id="membership" role="tabpanel" aria-labelledby="membership_tab">
                            <div class="table-responsive">
                                <table class="table table-hover compact table-condensed table-striped" id="membership_table" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Paket</th>
                                            <th>Jenis Paket</th>
                                            <th>Personal Trainer</th>
                                            <th>Tanggal Mulai</th>
                                            <th>Tanggal Selesai</th>
                                            <th>Status</th>
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
    let userId = 0;
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
                'url'       : '{{ route('users.data') }}',
                'type'      : 'POST',
                'headers'   : { 'X-CSRF-TOKEN': '{!! csrf_token() !!}' },
                'data': function (d) {
                    d.gender            =   $("#gender").val();
                    d.membership_status =   $("#membership_status :selected").val();
                    d.name              =   $("#name").val();
                    d.phone             =   $("#phone").val();
                    d.birth_date_from   =   $("#birth_date_from").val();
                    d.birth_date_to     =   $("#birth_date_to").val();
                    d.expired_date_from   =   $("#expired_date_from").val();
                    d.expired_date_to     =   $("#expired_date_to").val();
                }
            },
            columns: [
                { data: 'action', name: 'action', orderable: false, searchable: false },
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'birth_date', name: 'birth_date' },
                { data: 'gender', name: 'gender' },
                { data: 'phone', name: 'phone' },
                { data: 'created_at', name: 'created_at' },
                { data: 'expired_date', name: 'expired_date' },
                { data: 'membership_status', name: 'membership_status' }
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

    function membershipTable() 
    {
        var membershipTable = $("#membership_table").DataTable({
            retrieve: true,
            filter: true,
            processing: true,
            serverSide: false,
            stateSave: false,
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
                url: '{{ route('users.membership-history') }}',
                type: 'POST',
                headers: { 'X-CSRF-TOKEN': '{!! csrf_token() !!}' },
                data: function (d) {
                    d.user_id = userId;
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'package_name', name: 'package_name' },
                { data: 'package_type', name: 'package_type' },
                { data: 'trainer_name', name: 'trainer_name' },
                { data: 'start_date', name: 'start_date' },
                { data: 'end_date', name: 'end_date' },
                { data: 'status', name: 'status' }
            ],
            order: [[1, 'asc']]
            // If you want manual row numbering instead of DT_RowIndex, uncomment below:

            ,rowCallback: function(row, data, iDisplayIndex) {
                var api = this.api();
                var info = api.page.info();
                var index = info.start + iDisplayIndex + 1;
                $('td:eq(0)', row).html(index); // use first column
            }
        });
        return membershipTable;
    }


    function validateBirthDateTo()
    {
        let birthDateFrom = $("#birth_date_from").val();
        let birthDateTo = $("#birth_date_to").val();

        if (birthDateFrom && birth_date_from != "")
        {
            // show boo
            if (birthDateTo < birthDateFrom)
            {
                // createFlashMessage("Tanggal lahir sampai tidak valid", "alert-danger");
                showAlert("error", "Tanggal lahir sampai tidak valid")
                return false;
            }
        }

        return true;
    }

    function validateExpiredDateTo()
    {
        let expiredDateFrom = $("#expired_date_from").val();
        let expiredDateTo = $("#expired_date_to").val();

        if (expiredDateFrom && expiredDateTo != "")
        {
            // show boo
            if (expiredDateTo < expiredDateFrom)
            {
                // createFlashMessage("Tanggal berakhir sampai tidak valid", "alert-danger");
                showAlert("error", "Tanggal berakhir sampai tidak valid");
                return false;
            }
        }

        return true;
    }

    function clearValidationMessage()
    {
        $("#add_name").removeClass("is-invalid");
        $("#add_name_error_text").text("");

        $("#add_birth_date").removeClass("is-invalid");
        $("#add_birth_date_error_text").text("");

        $("#add_gender").removeClass("is-invalid");
        $("#add_gender_error_text").text("");

        $("#add_phone").removeClass("is-invalid");
        $("#add_phone_error_text").text("");

        $("#add_package").removeClass("is-invalid");
        $("#add_package_error_text").text("");

        $("#add_package_type").removeClass("is-invalid");
        $("#add_package_type_error_text").text("");

        $("#add_start_date").removeClass("is-invalid");
        $("#add_start_date_error_text").text("");

        $("#add_end_date").removeClass("is-invalid");
        $("#add_end_date_error_text").text(""); 

        $("#add_discount").removeClass("is-invalid");
        $("#add_discount_error_text").text("");

        $("#add_price").removeClass("is-invalid");
        $("#add_price_error_text").text("");

        $("#add_payment_method").removeClass("is-invalid");
        $("#add_payment_method_error_text").text("");

        $("#add_is_special_discount").removeClass("is-invalid");
        $("#add_is_special_discount_error_text").text("");
    }

    function validateData(action, userId = null)
    {
        clearValidationMessage();

        let status      =   true;
        let name        =   $("#add_name").val();
        let birthDate   =   $("#add_birth_date").val();
        let gender      =   $("#add_gender").val();
        let phone       =   $("#add_phone").val();
        let email       =   $("#add_email").val();
        let package     =   $("#add_package :selected").val();
        let packageType     =   $("#add_package_type").val();
        let startDate   =   $("#add_start_date").val();
        let endDate     =   $("#add_end_date").val();
        let discount    =   $("#add_discount").val();
        let price       =   $("#add_price").val();
        let paymentMethod     =   $("#add_payment_method").val();
        let isSpecialDiscount     =   $("#add_is_special_discount").val();

        if (action == "REGISTER" || action == "EDIT")
        {
            
            if (!name)
            {
                $("#add_name").addClass("is-invalid");
                $("#add_name_error_text").text("Harap isi filed ini");
                status = false;
            }
    
            if (!birthDate)
            {
                $("#add_birth_date").addClass("is-invalid");
                $("#add_birth_date_error_text").text("Harap isi filed ini");
                status = false;
    
            }
    
            if (!gender)
            {
                $("#add_gender").addClass("is-invalid");
                $("#add_gender_error_text").text("Harap isi filed ini");
                status = false;
            }
    
            if (!phone)
            {
                $("#add_phone").addClass("is-invalid");
                $("#add_phone_error_text").text("Harap isi filed ini");
                status = false;
            }
        }

        if (action == "REGISTER" || action == "RENEW_MEMBERSHIP")
        {
            if (!package)
            {
                $("#add_package").addClass("is-invalid");
                $("#add_package_error_text").text("Harap isi filed ini");
                status = false;
            }
    
            if (!packageType)
            {
                $("#add_package_type").addClass("is-invalid");
                $("#add_package_type_error_text").text("Harap isi filed ini");
                status = false;
            }
    
            if (!startDate)
            {
                $("#add_start_date").addClass("is-invalid");
                $("#add_start_date_error_text").text("Harap isi filed ini");
                status = false;
            }
    
            if (!endDate)
            {
                $("#add_end_date").addClass("is-invalid");
                $("#add_end_date_error_text").text("Harap isi filed ini");
                status = false;
            }
    
            if (!discount)
            {
                $("#add_discount").addClass("is-invalid");
                $("#add_discount_error_text").text("Harap isi filed ini");
                status = false;
            } 
    
            if (!price)
            {
                $("#add_price").addClass("is-invalid");
                $("#add_price_error_text").text("Harap isi filed ini");
                status = false;
            }
    
            if (!paymentMethod)
            {
                $("#add_payment_method").addClass("is-invalid");
                $("#add_payment_method_error_text").text("Harap isi filed ini");
                status = false;
            }

            if (isSpecialDiscount == "YES" && discount < 1)
            {
                $("#add_discount").addClass("is-invalid");
                $("#add_discount_error_text").text("Diskon wajib > 0 ketika ada diskon spesial");
                status = false;
            }
        }

        return status;
    }
    
    function showDetail(id)
    {
        userId = id;
        $("#loading_spiner").modal("show");

        // add delay to run this ajax
        setTimeout(() => {
            $.ajax({
                type: "GET",
                url: "{{ route('users.get-user-profile', ['id' => ':id']) }}".replace(':id', id),
                success: function (response) {
                    $("#loading_spiner").modal("hide");
                    $("#detail_membership").removeClass("badge-success badge-danger badge-warning");
                    
                    if (response.success)
                    {
                        let user = response.data;
                        $("#detail_name").text(user.name);
                        $("#detail_birth_date").text(formatDateYmdToDmy(user.birth_date));
                        $("#detail_gender").text(user.gender);
                        $("#detail_phone").text(user.phone);
                        $("#detail_package").text(user.package_type);
                        $("#detail_end_date").text(user.end_date);    
                        $("#detail_membership").text(user.membership_status);
                        $("#detail_membership").addClass(user.membership_status == 'GUEST' ? 'badge-warning' : (user.membership_status == 'MEMBER' ? 'badge-success' : 'badge-danger'));
                        if (user.membership_status == 'GUEST' || user.membership_status == 'MEMBER')
                        {
                            $("#deactivate_membership_button").val(user.membership_id);
                            $("#deactivate_membership_button").show();
                        } 
                        else
                        {
                            $("#deactivate_membership_button").val("");
                            $("#deactivate_membership_button").hide();
                        }
                            
                        $("#detail_user_modal").modal("show");
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

    function formatNumber(num) 
    {
        return num.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
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

    function createFlashMessage(message, color) 
    {
        $("#alert_message").text("");
        $("#alert_message").removeClass("alert-danger");
        $("#alert_message").removeClass("alert-warning");
        $("#alert_message").removeClass("alert-success");

        $("#alert_message").text(message);
        $("#alert").addClass(color).show();

        // Scroll to top
        $("html, body").animate({ scrollTop: 0 }, "fast");
    }

    function closeFlashMessage()
    {
        $("#alert").hide();
    }

    function refreshAddUserModal()
    {
        $("#add_name").prop("disabled", false);
        $("#add_birth_date").prop("disabled", false);
        $("#add_gender").prop("disabled", false);
        $("#add_phone").prop("disabled", false);
        $("#add_email").prop("disabled", false);

        $("#add_name").val("");
        $("#add_birth_date").val("");
        $("#add_gender").val("");
        $("#add_phone").val("");
        $("#add_email").val("");
        
        // $("#add_package").val("");
        $("#add_package").val("").selectpicker("refresh");
        $("#add_trainer").val("").selectpicker("refresh");
        $("#add_package_type").val("");
        $("#add_start_date").val("");
        $("#add_end_date").val("");
        $("#add_discount").val("");
        $("#add_price").val("");
        $("#add_payment_method").val("");
        $("#add_total").text("Rp 0");

        
    }

    function chooseMembershipPackage(userId)
    {
        userId = userId;
        action = "RENEW_MEMBERSHIP";

        refreshAddUserModal();
        clearValidationMessage();
        $("#save_button").val(userId);
        $("#profile_section").hide();
        $("#membership_section").show();
        $("#add_user_modal").modal("show");
    }

    function renewMembership(userId)
    {
        $.ajax({
            type: "POST",
            url: "{{ route('users.renew-membership') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                'user_id': userId,
                'package_id': $("#add_package").val(),
                'start_date': $("#add_start_date").val(),
                'end_date': $("#add_end_date").val(),
                'trainer_id': $("#add_trainer").val(),
                'payment_method': $("#add_payment_method").val(),
                'is_special_discount': $("#add_is_special_discount").val(),
                'price': $("#add_price").val().replace(/\./g, ''),
                'discount': $("#add_discount").val().replace(/\./g, ''),
                'total_price': $("#add_total").text().replace('Rp ', '').replace(/\./g, ''), // remove dots
            },
            dataType: "json",
            success: function (response) {

                $("#loading_spiner").modal("hide");
                if (response.success)
                {
                    $("#add_user_modal").modal("hide");
                    // createFlashMessage(response.message, "alert-success");
                    showAlert("success", response.message);
                    mainTable().ajax.reload();

                    // reset form
                    $("#add_user_form")[0].reset();
                    $("#add_package_type").val("");
                    $("#add_price").val("");
                    $("#add_discount").val("");
                    // $("#add_trainer").val("");
                    $("#add_package").val("").selectpicker("refresh");
                    $("#add_trainer").val("").selectpicker("refresh");
                    $("add_is_special_discount").val("NO");
                    $("#add_total").text("Rp 0");
                    durationInDays = 0;
                    clearValidationMessage();
                }
                else
                {
                    $("#add_user_modal").modal("hide");
                    // createFlashMessage(response.message, "alert-danger");
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
                    // createFlashMessage("Terjadi kesalahan pada server. Silakan coba lagi.", "alert-danger");
                    showAlert("error", "Terjadi kesalahan pada server. Silakan coba lagi.");
                }
            }

        });
    }

    function formatDateYmdToDmy(dateStr) 
    {
        let [year, month, day] = dateStr.split("-");
        return `${day}/${month}/${year}`;
    }

    function showEdit(userId)
    {
        userId = userId;
        action = "EDIT";

        refreshAddUserModal();
        clearValidationMessage();
        $("#save_button").val(userId);
        $("#profile_section").show();
        $("#membership_section").hide();

        $("#loading_spiner").modal("show");

        setTimeout(() => {
            $.ajax({
                type: "GET",
                url: "{{ route('users.get-user-profile', ['id' => ':user_id']) }}".replace(':user_id', userId),
                success: function (response) {
                    $("#loading_spiner").modal("hide");
                    if (response.success)
                    {
                        let user = response.data;
                        $("#add_name").val(user.name);
                        $("#add_birth_date").val(user.birth_date);
                        $("#add_gender").val(user.gender == "LAKI-LAKI" ? "L" : "P");
                        $("#add_phone").val(user.phone);
                        $("#add_email").val(user.email);
                        
                        $("#add_user_modal").modal("show");
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

    function saveEdit(userId)
    {
        $.ajax({
            type: "POST",
            url: "{{ route('users.update') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                'user_id': userId,
                'name': $("#add_name").val(),
                'gender': $("#add_gender").val(),
                'birth_date': $("#add_birth_date").val(),
                'phone': $("#add_phone").val(),
                'email': $("#add_email").val()
            },
            dataType: "json",
            success: function (response) {

                $("#loading_spiner").modal("hide");
                if (response.success)
                {
                    $("#add_user_modal").modal("hide");
                    // createFlashMessage(response.message, "alert-success");
                    showAlert("success", response.message);
                    mainTable().ajax.reload();

                    // reset form
                    $("#add_user_form")[0].reset();
                    $("#add_package_type").val("");
                    $("#add_price").val("");
                    $("#add_discount").val("");
                    $("#add_trainer").val("");
                    $("add_is_special_discount").val("NO");
                    $("#add_total").text("Rp 0");
                    durationInDays = 0;
                    clearValidationMessage();
                }
                else
                {
                    $("#add_user_modal").modal("hide");
                    // createFlashMessage(response.message, "alert-danger");
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
                    // createFlashMessage("Terjadi kesalahan pada server. Silakan coba lagi.", "alert-danger");
                    showAlert("error", "Terjadi kesalahan pada server. Silakan coba lagi.");
                }
            }

        });
    }

    function register()
    {
        $("#loading_spiner").modal("show");

        $.ajax({
            type: "POST",
            url: "{{ route('users.register') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                'name': $("#add_name").val(),
                'gender': $("#add_gender").val(),
                'birth_date': $("#add_birth_date").val(),
                'phone': $("#add_phone").val(),
                'email': $("#add_email").val(),
                'package_id': $("#add_package").val(),
                'start_date': $("#add_start_date").val(),
                'end_date': $("#add_end_date").val(),
                'trainer_id': $("#add_trainer").val(),
                'payment_method': $("#add_payment_method").val(),
                'is_special_discount': $("#add_is_special_discount").val(),
                'price': $("#add_price").val().replace(/\./g, ''),
                'discount': $("#add_discount").val().replace(/\./g, ''),
                'total_price': $("#add_total").text().replace('Rp ', '').replace(/\./g, ''), // remove dots
            },
            dataType: "json",
            success: function (response) {

                $("#loading_spiner").modal("hide");
                if (response.success)
                {
                    $("#add_user_modal").modal("hide");
                    // createFlashMessage(response.message, "alert-success");
                    showAlert("success", response.message);
                    mainTable().ajax.reload();

                    // reset form
                    $("#add_user_form")[0].reset();
                    $("#add_package_type").val("");
                    $("#add_price").val("");
                    $("#add_discount").val("");
                    // $("#add_trainer").val("");
                    $("#add_package").val("").selectpicker("refresh");
                    $("#add_trainer").val("").selectpicker("refresh");
                    $("add_is_special_discount").val("NO");
                    $("#add_total").text("Rp 0");
                    durationInDays = 0;
                    clearValidationMessage();
                }
                else
                {
                    $("#add_user_modal").modal("hide");
                    // createFlashMessage(response.message, "alert-danger");
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
                    // createFlashMessage("Terjadi kesalahan pada server. Silakan coba lagi.", "alert-danger");
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

    function checkIn(userId)
    {
        Swal.fire({
            title: "Apakah Anda yakin untuk melakukan check in atas pengguna ini?",
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
                
                $.ajax({
                    type: "POST",
                    url: "{{ route('users.check-in') }}",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'user_id': userId
                    },
                    dataType: "json",
                    success: function (response) {
        
                        $("#loading_spiner").modal("hide");
                        if (response.success)
                        {
                            // createFlashMessage(response.message, "alert-success");
                            showAlert("success", response.message)
                            mainTable().ajax.reload();
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
            }
        });
    }

    function deactivateMembership(membershipId)
    {
        Swal.fire({
            title: "Apakah Anda yakin untuk menonaktifkan member ini?",
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
                
                $.ajax({
                    type: "POST",
                    url: "{{ route('users.deactivate-membership') }}",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'membership_id': membershipId
                    },
                    dataType: "json",
                    success: function (response) {
        
                        $("#loading_spiner").modal("hide");
                        if (response.success)
                        {
                            // createFlashMessage(response.message, "alert-success");
                            showAlert("success", response.message)
                            $("#detail_user_modal").modal("hide");
                            mainTable().ajax.reload();
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
            }
        });
    }

    $(document).ready(function () {
        mainTable();

        $("#register_user_button").click(function () { 
            action = "REGISTER";

            refreshAddUserModal();
            clearValidationMessage();
            $("#save_button").val("");
            $("#profile_section").show();
            $("#membership_section").show();
            $("#add_user_modal").modal("show");
        });

        // Run once on load
        // toggleSidebarOnSmallScreens();

        // // Run when window is resized
        // $(window).resize(function () {
        //     toggleSidebarOnSmallScreens();
        // });

        
        let today = new Date().toISOString().split('T')[0]; 
        $('#add_start_date').attr('min', today);
        $('#add_end_date').attr('min', today);
        $('#add_birth_date').attr('max', today);

        $("#name").on("input", function () {
            this.value = this.value.toUpperCase();
        });
        
        $("#add_name").on("input", function () {
            this.value = this.value.toUpperCase();
        });

        $("#add_email").on("input", function () {
            this.value = this.value.toLowerCase();
        });

        $("#phone").on("input", function () {
            // keep only digits (0–9)
            this.value = this.value.replace(/\D/g, '');
        });

        $("#add_phone").on("input", function () {
            // keep only digits (0–9)
            this.value = this.value.replace(/\D/g, '');
        });

        $("#add_payment_method").change(function (e) { 
            e.preventDefault();
            clearValidationMessage();
            // validateData();
        });

        $("#add_is_special_discount").change(function (e) { 
            e.preventDefault();
            let isSpecialDiscount = $(this).val() == "YES" ? true : false;

            if (isSpecialDiscount)
            {
                $("#add_discount").prop("disabled", false);
            }
            else
            {
                $("#add_discount").prop("disabled", true);
            }
        });

        $("#add_price").on("input", function () {
            // Remove non-digit
            let value = this.value.replace(/\D/g, '');
            // Add thousand separator
            this.value = formatNumber(value);
            // get price (strip everything not a digit), then number
            let priceDigits = String($("#add_price").val() || '').replace(/[^\d]/g, '');
            let price = parseFloat(priceDigits) || 0;

            // calculate total
            let totalPrice = price;

            // format total as "Rp 1.234.567"
            let formattedTotal = "Rp " + Math.round(totalPrice).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            $("#add_total").text(formattedTotal);
        });

        // $("#add_discount").on("input", function() {
        //     let discount = $(this).val();
        //     if (discount == "") discount = 0;
        //     if (discount > 0)
        //     {
        //         let price = $("#add_price").val().replace(/\./g, '');
        //         let discount = $("#add_discount").val().replace(/\./g, '');
        //         let total = $("#add_total").text().replace('Rp ', '').replace(/\./g, '');
        //         let discountPrice = discount/100 * price
        //         let totalPrice = price - discountPrice;
        //         let formattedTotal = "Rp " + totalPrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        //         $("#add_total").text(formattedTotal);
        //     }
        // });

        $("#add_discount").on("input", function () {
            // get raw input as string and strip non-digits
            let raw = String(this.value || '').replace(/\D/g, '');

            // parse and clamp between 0 and 100
            let num = parseInt(raw || '0', 10);
            if (isNaN(num)) num = 0;
            num = Math.min(Math.max(num, 0), 100);

            // formatNumber expects a string -> pass a string
            this.value = formatNumber(String(num));

            // get price (strip everything not a digit), then number
            let priceDigits = String($("#add_price").val() || '').replace(/[^\d]/g, '');
            let price = parseFloat(priceDigits) || 0;

            // calculate total
            let totalPrice = price;
            if (num > 0 && price > 0) {
                totalPrice = price - (num / 100) * price;
            }

            // format total as "Rp 1.234.567"
            let formattedTotal = "Rp " + Math.round(totalPrice).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            $("#add_total").text(formattedTotal);
        });


        $(".selectpicker").selectpicker();
        $("#search_button").click(function (e) { 
            e.preventDefault();
            closeFlashMessage();
            
            if (validateBirthDateTo())
            {
                mainTable().ajax.reload()
            }
        });

        $("#add_package").change(function (e) { 
            e.preventDefault();
            let packageId   = $(this).val();

            // today as start date
            let today = new Date();
            let formatDate = (date) => {
                let y = date.getFullYear();
                let m = String(date.getMonth() + 1).padStart(2, '0');
                let d = String(date.getDate()).padStart(2, '0');
                return `${y}-${m}-${d}`;
            };

            $.ajax({
                type: "GET",
                url: "{{ route('packages.get-package-by-id', ['id' => ':id']) }}".replace(':id', packageId),
                success: function (response) {
                    if (response.success) {
                        durationInDays = response.data.duration_in_days;

                        // format today into Y-m-d first
                        let startDateFormatted = formatDate(today);

                        // parse into safe Date object
                        let [year, month, day] = startDateFormatted.split('-').map(Number);
                        let startDateObj = new Date(year, month - 1, day);

                        // calculate end date
                        let endDateObj = new Date(startDateObj);
                        endDateObj.setDate(endDateObj.getDate() + durationInDays);
                        let endDateFormatted = formatDate(endDateObj);

                        // fill form fields
                        $("#add_start_date").val(startDateFormatted);
                        $("#add_end_date").val(endDateFormatted);
                        $("#add_package_type").val(response.data.type);
                        $("#add_total").text("Rp " + response.data.total_price);
                        $("#add_discount").val(response.data.discount);
                        $("#add_price").val(response.data.price);

                        console.log(response.data.price + "OK");

                        clearValidationMessage();
                        // validateData();
                    }
                    else {
                        showAlert("error", response.message);
                    }
                }
            });
        });

        $("#add_start_date").change(function (e) { 
            e.preventDefault();
            let startDate = $(this).val(); // expected format: YYYY-MM-DD
            
            if (durationInDays > 0 && startDate) {
                let [year, month, day] = startDate.split('-').map(Number);
                let startDateObj = new Date(year, month - 1, day); // month is 0-based
                let endDateObj = new Date(startDateObj);
                endDateObj.setDate(endDateObj.getDate() + durationInDays);

                // format to Y-m-d
                let formatDate = (date) => {
                    let y = date.getFullYear();
                    let m = String(date.getMonth() + 1).padStart(2, '0');
                    let d = String(date.getDate()).padStart(2, '0');
                    return `${y}-${m}-${d}`;
                };

                $("#add_end_date").val(formatDate(endDateObj));
            } else {
                $("#add_end_date").val("");
            }
        });

        $("#save_button").click(function (e) { 
            e.preventDefault();
            let userId = $(this).val();

            // if (userId)
            // {
            //     if (validateData(userId))
            //     {
            //         $("#loading_spiner").modal("show");
            //         renewMembership(userId);
            //     }
            // }
            // else
            // {
            //     if (validateData())
            //     {
            //         $("#loading_spiner").modal("show");
            //         register();
            //     }
            // }
            
            
            // $("#loading_spiner").modal("show");

            if (action == "REGISTER")
            {
                if (validateData(action, userId))
                {
                    register();
                }

            }
            else if (action == "EDIT")
            {
                if (validateData(action, userId))
                {
                    saveEdit(userId);
                }
            }
            else
            {
                if (validateData(action, userId))
                {
                    renewMembership(userId);
                }

            }
        });

        $("#deactivate_membership_button").click(function (e) { 
            e.preventDefault();
            let membershipId = $(this).val();
            deactivateMembership(membershipId);
        });

        $("#birth_date_from").change(function () { 
            let birthDateFrom =  $(this).val();
            $("#birth_date_to").val(birthDateFrom);
        });

        $("#birth_date_to").change(function () { 
            validateBirthDateTo();
        });

        $("#expired_date_from").change(function () { 
            let expiredDateFrom =  $(this).val();
            $("#expired_date_to").val(expiredDateFrom);
        });

        $("#expired_date_to").change(function () { 
            validateExpiredDateTo();
        });

        $("#membership_tab").on("shown.bs.tab", function (e) {
            if (!$.fn.DataTable.isDataTable("#membership_table")) {
                membershipTable();
            }
        });

        $("#detail_user_modal").on("shown.bs.modal", function (e) {
            if ($.fn.DataTable.isDataTable("#membership_table")) {
                membershipTable().ajax.reload();
            }
        });
    });
</script>
@endpush