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
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/user') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail transaksi</h5>

                <button type="button" class="close" data-dismiss="modal" aria- label="Close"><span
                        aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body text-center">
                <div class="card">
                    <div class="card-body d-flex justify-content-center">
                        <div class="row w-auto">
                            <div class="col-lg-6 d-flex align-items-center justify-content-center">
                                <img src="{{ asset('storage/' . $transaksi->mobil->image) }}" alt="" style="max-width: 100%;">
                            </div>
                            <div class="col-lg-6">
                                <table class="table table-bordered text-left table-sm table-striped">
                                    <tr>
                                        <th class="text-right">Merk :</th>
                                        <td>{{ $transaksi->mobil->merk }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-right">Type :</th>
                                        <td>{{ $transaksi->mobil->type }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-right">Sales :</th>
                                        <td>{{ $transaksi->user->username }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-right">Pembeli :</th>
                                        <td>{{ $transaksi->pembeli }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-right">No Telp Pembeli :</th>
                                        <td>{{ $transaksi->telp_pembeli }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-right">Harga :</th>
                                        <td>{{ $transaksi->mobil->harga }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-right">Status :</th>
                                        <td>{{ $transaksi->status }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">

                <button type="button" data-dismiss="modal" class="btn btn-warning">Tutup</button>
            </div>
        </div>
    </div>
@endempty
