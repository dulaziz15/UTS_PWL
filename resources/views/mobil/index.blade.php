@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('mobil/create') }}')" class="btn btn-sm btn-info mt-1">Tambah</button>
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
                            <select class="form-control" id="kategori_id" name="kategori_id" required>
                                <option value="">- Semua -</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->kategori_id }}">{{ $item->nama_kategori }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Kategori Mobil</small>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-striped table-hover table-sm" id="table_mobil">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kategori</th>
                        <th>Merk</th>
                        <th>Tahun</th>
                        <th>Harga</th>
                        <th>Type</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Spesifikasi</th>
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

        var dataMobil;
        $(document).ready(function() {
            dataMobil = $('#table_mobil').DataTable({
                serverSide: true,
                ajax: {
                    'url': "{{ url('mobil/data') }}",
                    'dataType': "json",
                    'type': "POST",
                    'data': function(d) {
                        d.kategori_id = $('#kategori_id').val();
                    }
                },
                columns: [{
                    data: 'DT_RowIndex',
                    className: 'text-center',
                    orderable: false,
                    searchable: false
                }, {
                    data: "kategori.nama_kategori",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "merk",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "tahun",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "harga",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "type",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "image",
                    className: "",
                    orderable: true,
                    searchable: true,
                    render: function(data, type, row) {
                        if (data) {
                            return '<button onclick="modalAction(\'mobil/img/' + row.mobil_id +
                                '\')" class="btn btn-outline-primary btn-sm"><i class="fa fa-eye"></i> Show Image</button> ';
                        } else {
                            return 'No Image';
                        }
                    }
                }, {
                    data: "status",
                    className: "text-center",
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
                                case 'Tersedia':
                                    badgeClass = 'bg-success'; 
                                    break;
                                case 'Terjual':
                                    badgeClass = 'bg-danger'; 
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
                    data: "spesifikasi",
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

            $('#kategori_id').on('change', function() {
                dataMobil.ajax.reload();
            });
            
        });
    </script>
@endpush
