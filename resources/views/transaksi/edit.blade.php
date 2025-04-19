@empty($transaksi)
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
    <form action="{{ url('/transaksi/' . $transaksi->transaksi_id . '/update') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Transaksi</h5>
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
                                        <option {{ $data->mobil_id == $transaksi->mobil_id ? 'selected' : '' }}
                                            value="{{ $data->mobil_id }}">
                                            {{ $data->type }}</option>
                                    @endforeach
                                </select>
                                <small id="error-mobil" class="error-text form-text text-danger"></small>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Nama Pembeli</label>
                                    <input type="text" name="pembeli" id="pembeli" class="form-control"
                                        value="{{ $transaksi->pembeli }}" required>
                                    <small id="error-pembeli" class="error-text form-text text-danger"></small>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>No Telp Pembeli</label>
                                    <input type="text" name="telp_pembeli" id="telp_pembeli" class="form-control"
                                        value="{{ $transaksi->telp_pembeli }}" required>
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
            $("#form-edit").validate({
                rules: {
                    mobil_id: {
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
                    var formData = new FormData(form); // Gunakan FormData, bukan serialize
                    formData.append('_method', 'PUT');

                    $.ajax({
                        url: form.action,
                        type: 'POST',
                        data: formData,
                        processData: false, // Penting! Biar jQuery tidak serialize formData
                        contentType: false, // Penting! Biar jQuery set content-type multipart/form-data
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
@endempty
