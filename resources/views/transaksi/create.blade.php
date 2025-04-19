@if ($mobil->count() < 1)
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
                    Semua mobil sudah ditransaksikan input kembali data mobil
                </div>
                <a href="{{ url('/transaksi') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/transaksi/create') }}" method="POST" id="form-tambah">
        @csrf
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body ">
                    <div class="card m-4 p-2 bg-light">
                        <div class="form p-4">
                            <div class="col-lg-12">
                                <label>Mobil</label>
                                <select name="mobil_id" id="mobil" class="form-control" required>
                                    <option value="">- Pilih mobil -</option>
                                    @foreach ($mobil as $data)
                                        <option value="{{ $data->mobil_id }}">{{ $data->type }}
                                        </option>
                                    @endforeach
                                </select>
                                <small id="error-mobil" class="error-text form-text text-danger"></small>
                            </div>
                            <div class="col-lg-12">
                                <label>Keterangan</label>
                                <select name="keterangan" id="keterangan" class="form-control" required>
                                    <option value="">- Pilih Katerangan -</option>
                                    <option value="{{ \App\Enums\TransaksiEnum::booking }}">
                                        {{ \App\Enums\TransaksiEnum::booking }}</option>
                                    <option value="{{ \App\Enums\TransaksiEnum::lunas }}">
                                        {{ \App\Enums\TransaksiEnum::lunas }}</option>
                                </select>
                                <small id="error-keterangan" class="error-text form-text text-danger"></small>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Nama Pembeli</label>
                                    <input type="text" name="pembeli" id="pembeli" class="form-control" required>
                                    <small id="error-pembeli" class="error-text form-text text-danger"></small>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>No Telp Pembeli</label>
                                    <input type="text" name="telp_pembeli" id="telp_pembeli" class="form-control" required>
                                    <small id="error-telp_pembeli" class="error-text form-text text-danger"></small>
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
        </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            $("#form-tambah").validate({
                rules: {
                    mobil_id: {
                        required: true,
                    },
                    keterangan: {
                        required: true,
                    },
                    pembeli: {
                        required: true,
                    },
                    telp_pembeli: {
                        required: true,
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
                                dataTransaksi.ajax.reload();
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
@endif
