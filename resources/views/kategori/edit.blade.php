@empty($kategori)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria- label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/kategori') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/kategori/' . $kategori->kategori_id . '/update') }}" method="POST" id="form-tambah">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body ">
                    <div class="card m-4 p-2 bg-light">
                        <div class="form p-4">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Kode kategori</label>
                                    <input value="{{ $kategori->kode_kategori }}" type="text" name="kode_kategori" id="kode_kategori"
                                        class="form-control" required>

                                    <small id="error-kode_kategori" class="error-text form-text text-danger"></small>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Nama Kategori</label>
                                    <input value="{{ $kategori->nama_kategori }}" type="nama_kategori" name="nama_kategori" id="nama_kategori"
                                        class="form-control" required>

                                    <small id="error-nama_kategori" class="error-text form-text text-danger"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            $("#form-tambah").validate({
                rules: {
                    kategoriname: {
                        required: true,
                        minlength: 3,
                        maxlength: 20
                    },
                    email: {
                        required: true
                    },
                    password: {
                        required: true,
                        minlength: 6,
                        maxlength: 20
                    },
                    telp: {
                        required: true,
                        minlength: 6,
                        maxlength: 20
                    },
                    alamat: {
                        required: true,
                        minlength: 3,
                        maxlength: 200,
                    },
                    tempat_lahir: {
                        required: true,
                        minlength: 3,
                        maxlength: 20
                    },
                    tanggal_lahir: {
                        required: true
                    },
                    role: {
                        required: true
                    }
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                dataKategori.ajax.reload();
                            } else {
                                $('.error-text').text('');
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        }
                    });
                    return false;
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endempty
