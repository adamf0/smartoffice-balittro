<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            	<form action="/super_admin/jenis_golongan/store" method="post">
                    {{ csrf_field() }}
            		<label>Nama Golongan</label>
            		<input type="text" name="nama_golongan" class="form-control" required>
            		<button type="submit" name="simpan" class="btn btn-primary btn-block">Tambah Data</button>
            	</form>
           	</div>
        </div>
    </div>
</div>