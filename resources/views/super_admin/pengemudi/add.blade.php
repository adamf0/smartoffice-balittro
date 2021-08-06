<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            	<form action="/super_admin/pengemudi/store" method="post">
                    {{ csrf_field() }}
            		<label>Nama Pengemudi</label>
                    <select name="pengguna" data-placeholder="Pilih Pengguna" class="form-control chosen-select" required>
                        <option value=""></option>
                        @foreach($pengguna as $pengguna)
                            <option value="{{ $pengguna->id_user }}">{{ $pengguna->nama }}</option>
                        @endforeach
                    </select>
                    <label>Jenis Kendaraan</label>
                    <input type="text" name="jenis_kendaraan" class="form-control" required>
                    <label>Nomor Polisi</label>
                    <input type="text" name="nomor_polisi" class="form-control" required>
                    <label>Status</label>
                    <div class="form-group clearfix">
                      <div class="icheck-success d-inline">
                        <input type="radio" id="status_1" name="status" value="1" required>
                        <label for="status_1">Aktif</label>
                      </div>
                      <div class="icheck-danger d-inline">
                        <input type="radio" id="status_0" name="status" value="0" required>
                        <label for="status_0">Tidak Aktif</label>
                      </div>
                    </div>
            		<button type="submit" name="simpan" class="btn btn-primary btn-block">Tambah Data</button>
            	</form>
           	</div>
        </div>
    </div>
</div>