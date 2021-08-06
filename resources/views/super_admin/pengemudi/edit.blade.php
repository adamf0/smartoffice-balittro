<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            	<form action="/super_admin/pengemudi/update" method="post">
            		{{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    <label>Nama Pengemudi</label>
                    <select name="pengguna" data-placeholder="Pilih Pengguna" class="form-control chosen-select" required>
                        <option value=""></option>
                        @foreach($pengguna as $pengguna)
                            @if($data->id_user!=null)
                                <option value="{{ $pengguna->id_user }}" @if($pengguna->id_user==$data->id_user) {{ "selected='true'" }} @endif>{{ $pengguna->nama }}</option>
                            @else
                                <option value="{{ $pengguna->id_user }}">{{ $pengguna->nama }}</option>
                            @endif
                        @endforeach
                    </select>
                    <label>Jenis Kendaraan</label>
                    <input type="text" name="jenis_kendaraan" class="form-control" value="{{ $data->jenis_kendaraan }}" required>
                    <label>Nomor Polisi</label>
                    <input type="text" name="nomor_polisi" class="form-control" value="{{ $data->no_polisi }}" required>
                    <label>Status</label>
                    <div class="form-group clearfix">
                      <div class="icheck-success d-inline">
                        <input type="radio" id="status_1" name="status" required value="1" @if($data->status==1) {{ "checked='true'" }} @endif>
                        <label for="status_1">Aktif</label>
                      </div>
                      <div class="icheck-danger d-inline">
                        <input type="radio" id="status_0" name="status" required value="0" @if($data->status==0) {{ "checked='true'" }} @endif>
                        <label for="status_0">Tidak Aktif</label>
                      </div>
                    </div>
                    <button type="submit" name="simpan" class="btn btn-primary btn-block">Ubah Data</button>
            	</form>
           	</div>
        </div>
    </div>
</div>