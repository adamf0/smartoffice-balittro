<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            	<form action="/super_admin/potong_anggaran/store" method="post">
            		{{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    <label>Kode/MAK</label>
            		<input type="text" class="form-control" value="{{ $data->kode }}" disabled>
                    <label>Nama Kegiatan</label>
                    <input type="text" class="form-control" value="{{ $data->nama_kegiatan }}" disabled>
                    <label>Total Pagu Anggaran</label>
                    <input type="number" class="form-control total_biaya" value="{{ $data->total_biaya }}" disabled>
                    <div class="controls">
                        <div class="row entry mt-2">
                            <div class="col-6">
                                  <div class="input-group">
                                    <div class="col-12">
                                        <label>Keterangan Pemotongan</label>    
                                    </div>
                                    <div class="col-12">
                                        <input class="form-control" name="keterangan[]" type="text" placeholder="Masukkan Keterangan..." required />
                                    </div>
                                  </div>
                            </div>
                            <div class="col-6">
                                <div class="col-12">
                                    <label>Jumlah Biaya</label>
                                </div>
                                <div class="col-12 input-group">
                                    <input class="form-control" name="jumlah_biaya_potong[]" type="number" placeholder="Masukkan biaya..." required onchange="HitungUlangSisa(this)" required min="0" />
                                    <span class="input-group-btn">
                                        <button class="btn btn-success btn-add" type="button">
                                            <span class="fa fa-plus"></span>
                                       </button>
                                   </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <label>Sisa Pagu Anggaran</label>
                    <input type="number" class="form-control sisa_biaya disabled" value="{{ $data->sisa_biaya }}" min="0">

            		<button type="submit" name="simpan" class="btn btn-primary btn-block">Tambah Data</button>
            	</form>
           	</div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function HitungUlangSisa(selectObject){
        var sum=0;
        $('input[name="jumlah_biaya_potong[]"]').each(function(){
            if($(this).val()!=''){
                sum += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                console.log($(this).val());
            }
        });

        document.querySelector(".sisa_biaya").value = document.querySelector(".total_biaya").value - sum;           
    }
</script>