<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            	<form action="/super_admin/jenis_pangkat/store" method="post">
                    {{ csrf_field() }}
            		<label>Nama Pangkat</label>
            		<input type="text" name="nama_pangkat" class="form-control" required>
            		<button type="submit" name="simpan" class="btn btn-primary btn-block">Tambah Data</button>
            	</form>
           	</div>
        </div>
    </div>
</div>