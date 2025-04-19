@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/transaksi/create') }}')"
                    class="btn btn-sm btn-info mt-1">Tambah</button>
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
                            <select class="form-control" id="level_id" name="level_id" required>
                                <option value="">- Semua -< /option>
                                        {{-- @foreach ($level as $item)
                                <option value="{{ $item->level_id }}">{{ $item->level_nama }}</option>
                                @endforeach --}}
                            </select>
                            <small class="form-text text-muted">Level Pengguna</small>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-striped table-hover table-sm" id="table-transaksi">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Type Mobil</th>
                        <th>Username Sales</th>
                        <th>Pembeli</th>
                        <th>No Telp Pembeli</th>
                        <th>Status</th>
                        <th>Aksi</th>
                        <th>Pembayaran</th>
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

        function lakukanPelunasan(id) {
            if (confirm('Apakah Anda yakin ingin melakukan pelunasan?')) {
                $.ajax({
                    url: '/' + id + '/pelunasan',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}' // <-- WAJIB untuk POST Laravel
                    },
                    success: function(response) {
                        if (response.status) {
                            alert(response.message);
                            $('#datatable-id').DataTable().ajax.reload(); // reload datatable
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan. Coba lagi.');
                    }
                });
            }
        }
    </script>
    <script>
        var dataTransaksi;
        $(document).ready(function() {
            dataTransaksi = $('#table-transaksi').DataTable({
                serverSide: true,
                ajax: {
                    'url': "{{ url('transaksi/data') }}",
                    'dataType': "json",
                    'type': "GET"
                },
                columns: [{
                    data: 'DT_RowIndex',
                    className: 'text-center',
                    orderable: false,
                    searchable: false
                }, {
                    data: "mobil.type",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "user.username",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "pembeli",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "telp_pembeli",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "status",
                    className: "",
                    orderable: true,
                    searchable: true,
                    render: function(data, type, row) {
                        if (data) {
                            let badgeClass = '';
                            let statusText = row.status;

                            switch (row.status) {
                                case 'Booking':
                                    badgeClass = 'bg-warning'; 
                                    break;
                                case 'Lunas':
                                    badgeClass = 'bg-success'; 
                                    break;
                                default:
                                    badgeClass =
                                    'bg-secondary'; 
                            }

                            return '<span class="badge ' + badgeClass + '">' + statusText +
                                '</span>';
                        } else {
                            return '<span class="text-muted">Belum Ada Status</span>';
                        }
                    }

                }, {
                    data: "aksi",
                    className: "",
                    orderable: false,
                    searchable: false
                }, {
                    data: "pembayaran",
                    className: "",
                    orderable: false,
                    searchable: false
                }]
            });
        });
    </script>
@endpush
