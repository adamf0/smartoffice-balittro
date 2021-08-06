<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            	<form action="/admin/pinjam_kendaraan/store/{{$data->id}}" method="post">
                    {{ csrf_field() }}
                    <div class="col-12">
            		    <label>Nomor Laporan</label>
                        <input type="text" value="{{ $data->nomor_laporan }}" class="form-control" disabled="true">
                    </div>
                    <div class="col-12">
                        <label>Peminjam</label>
                        <input type="text" value="{{ $data->peminjam }}" class="form-control" disabled="true">
                    </div>
                    <div class="col-12">
                        <label>Tujuan</label>
                        <input type="text" value="{{ $data->tujuan }}" class="form-control" disabled="true">
                    </div>
                    <div class="controls">
                        <div class="row entry mt-2">
                            <div class="col-12">
                                  <div class="input-group">
                                    <div class="col-12">
                                        <label>Nama Pengemudi</label>    
                                    </div>
                                    <div class="col-12 input-group">
                                        <select name="pengemudi[]" data-placeholder="Pilih Pengemudi" class="form-control" required="true">
                                            <option value=""></option>
                                            @foreach($data_pengemudi as $pengemudi)
                                                <option value="{{ $pengemudi['id'] }}">{{ $pengemudi['nama'] }}</option>
                                            @endforeach
                                        </select>
                                        <span class="input-group-btn">
                                            <button class="btn btn-success btn-add" type="button">
                                                <span class="fa fa-plus"></span>
                                           </button>
                                       </span>

                                    </div>
                                  </div>
                            </div>
                        </div>
                    </div>
            		<button type="submit" name="simpan" class="btn btn-primary btn-block mt-3">Tambah Data</button>
            	</form>
           	</div>
        </div>
    </div>
</div>