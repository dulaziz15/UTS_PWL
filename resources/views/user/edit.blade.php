@empty($user)
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
                <a href="{{ url('/user') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/user/' . $user->user_id . '/update') }}" method="POST" id="form-tambah">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body ">
                    <div class="card m-4 p-2 bg-light">
                        <div class="form p-4">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input value="{{ $user->username }}" type="text" name="username" id="username"
                                            class="form-control" required>

                                        <small id="error-username" class="error-text form-text text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input value="{{ $user->email }}" type="email" name="email" id="email"
                                            class="form-control" required>

                                        <small id="error-email" class="error-text form-text text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Password</label>

                                        <input value="{{ $user->password }}" type="password" name="password" id="password"
                                            class="form-control">

                                        <small class="form-text text-muted">Abaikan jika tidak ingin ubah

                                            password</small>

                                        <small id="error-password" class="error-text form-text text-danger"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>No Telp</label>
                                        <input value="{{ $user->telp }}" type="number" name="telp" id="telp"
                                            class="form-control" required>

                                        <small id="error-telp" class="error-text form-text text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Tempat Lahir</label>
                                        <input value="{{ $user->tempat_lahir }}" type="text" name="tempat_lahir" id="tempat_lahir"
                                            class="form-control" required>

                                        <small id="error-tempat_lahir" class="error-text form-text text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Tanggal Lahir</label>
                                        <input value="{{ $user->tanggal_lahir }}" type="Date" name="tanggal_lahir" id="tanggal_lahir"
                                            class="form-control" required>

                                        <small id="error-tanggal_lahir" class="error-text form-text text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Role</label>
                                        <select name="role" id="role" class="form-control" required>
                                            <option value="{{ $user->role }}" selected>{{ $user->role }}</option>
                                            <option value="admin">Admin</option>
                                            <option value="user">User</option>
                                        </select>
                                        <small id="error-role" class="error-text form-text text-danger"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <textarea class="form-control" id="alamat" name="alamat" rows="10">{{ $user->alamat }}</textarea>
                                    </div>
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
                    username: {
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
                                dataUser.ajax.reload();
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
