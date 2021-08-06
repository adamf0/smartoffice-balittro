<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
           		<label>Cetak Berdasarkan</label>
           		<select id="filter" class="form-control" onchange="run()">
                    <option value="" selected="true">Pilih Filter</option>
                    <option value="nama">Nama</option>
                    <option value="tujuan">Tujuan</option>
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
                <div id='tujuan' style="display: none;">
                    <label>Tujuan</label>
                    <select name="tujuan" data-placeholder="Pilih Tujuan" id="filter_tujuan" class="form-control chosen-select">
                        <option value=""></option>
                        @foreach($tujuan as $tujuan)
                            <option value="{{ $tujuan->id }}">{{ $tujuan->tujuan }}</option>
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
        var tujuan = document.getElementById("filter_tujuan").value;
        var tanggal = document.getElementById("filter_tanggal").value;
        if(filter == "nama"){
            window.location.href = "{{ url('/admin/cetak/surat_quitansi/') }}/"+filter+"/"+nama;
        }
        else if(filter == "tujuan"){
            window.location.href = "{{ url('/admin/cetak/surat_quitansi/') }}/"+filter+"/"+tujuan;
        }
        else if(filter == "tanggal"){
            window.location.href = "{{ url('/admin/cetak/surat_quitansi/') }}/"+filter+"/"+tanggal;
        }
    }
    function run() {
        var pilih = document.getElementById("filter").value;
        console.log(pilih);
        if(pilih == "nama"){
            $("#nama").show();
            $("#tujuan").hide();
            $("#tanggal").hide();
        }
        else if(pilih == "tujuan"){
            $("#nama").hide();
            $("#tujuan").show();
            $("#tanggal").hide();
        }
        else{
            $("#nama").hide();
            $("#tujuan").hide();   
            $("#tanggal").show();
        }
    }
</script>