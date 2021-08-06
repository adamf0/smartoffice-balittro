<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            	<form action="/super_admin/jenis_anggaran/store" method="post">
                    {{ csrf_field() }}
            		    <label>Nama Jenis Anggaran</label>
            		    <input type="text" name="nama_anggaran" class="form-control">
                    <label>Digunakan Untuk</label>
                    <div class="form-group clearfix">
                      <div class="icheck-warning d-inline">
                        <input type="radio" id="type_0" name="type" value="0" required="true">
                        <label for="type_0">Orang Melakukan Perjalanan</label>
                      </div>
                      <div class="icheck-primary d-inline">
                        <input type="radio" id="type_1" name="type" value="1" required="true">
                        <label for="type_1">Kendaraan Umum</label>
                      </div>
                      <div class="icheck-success d-inline">
                        <input type="radio" id="type_2" name="type" value="2" required="true">
                        <label for="type_2">Kendaraan Dinas/Pengemudi</label>
                      </div>
                    </div>

            		<button type="submit" name="simpan" class="btn btn-primary btn-block">Tambah Data</button>
            	</form>
           	</div>
        </div>
    </div>
</div>