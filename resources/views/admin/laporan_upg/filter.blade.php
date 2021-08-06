<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <label>Tanggal</label>
                <input type="text" name="tanggal" id="filter_tanggal" class="form-control datemask" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm" data-mask>

          		<button type="submit" name="simpan" class="btn btn-primary btn-block" onclick="filter()">Cetak</button>
           	</div>
        </div>
    </div>
</div>
<script>
    function filter(){
        var filter = 'tanggal';
        // var nama = document.getElementById("filter_nama").value;
        // var tujuan = document.getElementById("filter_tujuan").value;
        var tanggal = document.getElementById("filter_tanggal").value;
        // if(filter == "nama"){
        //     window.location.href = "{{ url('/admin/cetak/surat_spd/') }}/"+filter+"/"+nama;
        // }
        // else if(filter == "tujuan"){
        //     window.location.href = "{{ url('/admin/cetak/surat_spd/') }}/"+filter+"/"+tujuan;
        // }
        // else if(filter == "tanggal"){
            window.location.href = "{{ url('/admin/cetak/laporan_upg') }}/"+filter+"/"+tanggal;
        // }
    }
    function run() {
        var pilih = document.getElementById("filter").value;
        console.log(pilih);
        // if(pilih == "nama"){
        //     $("#nama").show();
        //     $("#tujuan").hide();
        //     $("#tanggal").hide();
        // }
        // else if(pilih == "tujuan"){
        //     $("#nama").hide();
        //     $("#tujuan").show();
        //     $("#tanggal").hide();
        // }
        // else{
        //     $("#nama").hide();
        //     $("#tujuan").hide();   
        //     $("#tanggal").show();
        // }
    }
</script>