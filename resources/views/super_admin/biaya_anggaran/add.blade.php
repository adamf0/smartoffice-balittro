<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            	<form action="/super_admin/biaya_anggaran/store" method="post">
                    {{ csrf_field() }}
                    <div class="col-12">
            		    <label>Nama Tujuan</label>
                    </div>
                    <div class="col-12">
                		<select name="tujuan" data-placeholder="Pilih Tujuan" class="form-control chosen-select" required>
                            <option value=""></option>
                            @foreach($tujuan as $tujuan)
                                <option value="{{ $tujuan->id }}">{{ $tujuan->tujuan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="controls">
                        <div class="row entry mt-2">
                            <div class="col-6">
                                  <div class="input-group">
                                    <div class="col-12">
                                        <label>Nama Anggaran</label>    
                                    </div>
                                    <div class="col-12">
                                        <select name="anggaran[]" data-placeholder="Pilih Jenis Anggaran" class="form-control" required>
                                            <option value="-1"></option>
                                            @foreach($jenis_anggaran as $jenis_anggaran)
                                                <option value="{{ $jenis_anggaran->id }}">{{ $jenis_anggaran->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                  </div>
                            </div>
                            <div class="col-6">
                                <div class="col-12">
                                    <label>Biaya Anggaran</label>
                                </div>
                                <div class="col-12 input-group">
                                    <input class="form-control" name="biaya[]" type="text" placeholder="Masukkan biaya anggaran..."  required/>
                                    <span class="input-group-btn">
                                        <button class="btn btn-success btn-add" type="button">
                                            <span class="fa fa-plus"></span>
                                       </button>
                                   </span>
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