<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
           		<label>Cetak Berdasarkan</label>
           		<select id="filter" class="form-control" onchange="run()">
                    <option value="" selected="true">Pilih Filter</option>
                    <option value="nama">Nama</option>
                    <option value="tanggal">Tanggal</option>
                </select>
          		<div id='nama' style="display: none;">
                    <label>Nama</label>
             		<select name="nama" data-placeholder="Pilih Nama" id="filter_nama" class="form-control chosen-select">
                        <option value=""></option>
                        @foreach($pengguna as $pengguna)
                            <option value="{{ $pengguna->id_user }}">{{ $pengguna->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div id='tanggal' style="display: none;">
                    <label>Tanggal</label>
                    <input type="text" name="tanggal" id="filter_tanggal" class="form-control datemask" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm" data-mask>
                </div>

          		<button type="submit" name="simpan" class="btn btn-primary btn-block" onclick="filter()">Cetak</button>
           	</div>
        </div>
    </div>
</div>
<script>
    function filter(){
        var filter = document.getElementById("filter").value;
        var nama = document.getElementById("filter_nama").value;
        var tanggal = document.getElementById("filter_tanggal").value;
        if(filter == "nama"){
            window.location.href = "{{ url('/admin/cetak/surat_cuti/') }}/"+filter+"/"+nama;
        }
        else if(filter == "tanggal"){
            window.location.href = "{{ url('/admin/cetak/surat_cuti/') }}/"+filter+"/"+tanggal;
        }
    }
    function run() {
        var pilih = document.getElementById("filter").value;
        console.log(pilih);
        if(pilih == "nama"){
            $("#nama").show();
            $("#tanggal").hide();
        }
        else{
            $("#nama").hide();
            $("#tanggal").show();
        }
    }
</script>