@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('user/create') }}')" class="btn btn-sm btn-info mt-1">Tambah</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter :</label>
                        <div class="col-3">
                            <select class="form-control" id="role" name="role" required>
                                <option value="">- Semua -< /option>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                            </select>
                            <small class="form-text text-muted">Role Pengguna</small>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-striped table-hover table-sm" id="table_user">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>No Telepon</th>
                        <th>Alamat</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        var dataUser;
        $(document).ready(function() {
            dataUser = $('#table_user').DataTable({
                serverSide: true,
                ajax: {
                    'url': "{{ url('user/data') }}",
                    'dataType': "json",
                    'type': "POST",
                    'data': function(d) {
                        d.role = $('#role').val();
                    }
                },
                columns: [{
                    data: 'DT_RowIndex',
                    className: 'text-center',
                    orderable: false,
                    searchable: false
                }, {
                    data: "username",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "email",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "telp",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "alamat",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "tempat_lahir",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "tanggal_lahir",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "role",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "aksi",
                    className: "",
                    orderable: false,
                    searchable: false
                }]
            });
        });

        $('#role').on('change', function() {
            dataUser.ajax.reload();
        });
    </script>
@endpush
