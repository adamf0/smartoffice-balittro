<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            	<form action="/super_admin/jenis_anggaran/update" method="post">
            		    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    <label>Nama Jenis Anggaran</label>
            		    <input type="text" name="nama_anggaran" class="form-control" value="{{ $data->nama }}">
                    <label>Digunakan Untuk</label>
                    <div class="form-group clearfix">
                      <div class="icheck-warning d-inline">
                        <input type="radio" id="type_0" required="true" name="type" value="0" @if($data->type==0) {{ "checked='true'" }} @endif>
                        <label for="type_0">Orang Melakukan Perjalanan</label>
                      </div>
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="type_1" required="true" name="type" value="1" @if($data->type==1) {{ "checked='true'" }} @endif>
                        <label for="type_1">Kendaraan Umum</label>
                      </div>
                      <div class="icheck-success d-inline">
                        <input type="radio" id="type_2" required="true" name="type" value="2" @if($data->type==1) {{ "checked='true'" }} @endif>
                        <label for="type_2">Kendaraan Dinas/Pengemudi</label>
                      </div>
                    </div>
            		<button type="submit" name="simpan" class="btn btn-primary btn-block">Ubah Data</button>
            	</form>
           	</div>
        </div>
    </div>
</div>