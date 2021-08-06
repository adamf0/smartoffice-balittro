<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <label>Filter</label>
                <input type="text" class="form-control" disabled="true" value="@if($data['filter']=='nama') {{ $data['nama'] }}  @elseif($data['filter']=='tujuan') {{ $data['tujuan'] }} @else {{ $data['tanggal'] }} @endif">
           		<label>Download Berkas</label>
                <ul class="list-group list_data">
                    @foreach($data['data'] as $list)    
                    <li class="list-group-item" data-filter="{{ $data['filter'] }}" data-id="{{ $list['id'] }}" data-user="{{ $data['id_user'] }}" data-tujuan="{{ $data['id_tujuan'] }}" data-tanggal="{{ $data['id_tanggal'] }}">
                        <div class="row">
                            <div class="col-7">
                                <div class="row">
                                    <div class="col-1">
                                        <div class="spinner-border text-primary loading">
                                            <span class="sr-only">Loading...</span>
                                        </div>  
                                    </div>
                                    <div class="col-6   ">
                                        <p class="float-left ml-2"></p>{{ $list['nomor_laporan'] }}</p>
                                    </div>
                                    <div class="col-5">
                                        <button class="btn btn-primary btn-sm btn-reload-spd" style="display: none;">unduh ulang spd</button>
                                    </div> 
                                </div>
                            </div>
                            <div class="col-5 text-right">
                                @if($list['download_spd']==-1)    
                                <h5 class="badge badge-danger badge-lg status_spd">
                                    Gagal Menyimpan SPD
                                </h5>
                                @elseif($list['download_spd']==0)    
                                <h5 class="badge badge-warning status_spd">
                                    Sedang Menyimpan SPD
                                </h5>
                                @else    
                                <h5 class="badge badge-success status_spd">
                                    Tersimpan SPD
                                </h5>
                                @endif
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
           	</div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $.each($('ul.list_data>li'),function(index, node){
            var id = node.getAttribute('data-id');
            var user = node.getAttribute('data-user');
            var tujuan = node.getAttribute('data-tujuan');
            var tanggal = node.getAttribute('data-tanggal');
            var filter = node.getAttribute('data-filter');

            if(filter=='nama'){
                var url = '{{ url("/admin/cetak/surat_spd") }}/filter/'+filter+'/'+id+'/target/'+user;
            }
            else if(filter=='tujuan'){
                var url = '{{ url("/admin/cetak/surat_spd") }}/filter/'+filter+'/'+id+'/target/'+tujuan;
            }
            else if(filter=='tanggal'){
                var url = '{{ url("/admin/cetak/surat_spd") }}/filter/'+filter+'/'+id+'/target/'+tanggal;
            }   
            console.log(url);

            $.ajax({
                url: url,
                success: function (response) {
                    if(response=="1"){
                        node.querySelector(".status_spd").classList.remove("badge-warning");
                        node.querySelector(".status_spd").textContent = 'Tersimpan SPD';
                        node.querySelector(".status_spd").classList.add("badge-success");
                    }
                    else{
                        node.querySelector(".status_spd").classList.remove("badge-warning");
                        node.querySelector(".status_spd").textContent = 'Gagal Tersimpan SPD';
                        node.querySelector(".status_spd").classList.add("badge-danger");
                    }
                    node.querySelector(".loading").style.display = "none";
                },
                error: function (jqXHR, exception) {
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'tidak ada koneksi internet';
                    } else if (jqXHR.status == 404) {
                        msg = 'sumber tidak ditemukan';
                    } else if (jqXHR.status == 500) {
                        msg = 'sumber bermasalah';
                    } else if (exception === 'parsererror') {
                        msg = 'kesalahan parsing';
                    } else if (exception === 'timeout') {
                        msg = 'timeout';
                    } else if (exception === 'abort') {
                        msg = 'sistem batal paksa';
                    } else {
                        msg = 'Error:\n' + jqXHR.responseText;
                    }

                    node.querySelector(".status_spd").classList.remove("badge-warning");
                    node.querySelector(".status_spd").textContent = msg;
                    node.querySelector(".status_spd").classList.add("badge-danger");

                    node.querySelector(".loading").style.display = "none";
                    node.querySelector(".btn-reload-spd").style.display = "block";
                    
                    node.querySelector('.btn-reload-spd').onclick = function() { 
                        node.querySelector(".status_spd").classList.remove("badge-danger");
                        node.querySelector(".status_spd").textContent = "Sedang Menyimpan SPD";
                        node.querySelector(".status_spd").classList.add("badge-warning");

                        node.querySelector(".loading").style.display = "block";
                        node.querySelector(".btn-reload-spd").style.display = "none";

                        $.ajax({
                            url: url,
                            success: function (response) {
                                if(response=="1"){
                                    node.querySelector(".status_spd").classList.remove("badge-warning");
                                    node.querySelector(".status_spd").textContent = 'Tersimpan SPD';
                                    node.querySelector(".status_spd").classList.add("badge-success");
                                }
                                else{
                                    node.querySelector(".status_spd").classList.remove("badge-warning");
                                    node.querySelector(".status_spd").textContent = 'Gagal Tersimpan SPD';
                                    node.querySelector(".status_spd").classList.add("badge-danger");
                                }
                                node.querySelector(".loading").style.display = "none";
                            },
                            error: function (jqXHR, exception) {
                                var msg = '';
                                if (jqXHR.status === 0) {
                                    msg = 'tidak ada koneksi internet';
                                } else if (jqXHR.status == 404) {
                                    msg = 'sumber tidak ditemukan';
                                } else if (jqXHR.status == 500) {
                                    msg = 'sumber bermasalah';
                                } else if (exception === 'parsererror') {
                                    msg = 'kesalahan parsing';
                                } else if (exception === 'timeout') {
                                    msg = 'timeout';
                                } else if (exception === 'abort') {
                                    msg = 'sistem batal paksa';
                                } else {
                                    msg = 'Error:\n' + jqXHR.responseText;
                                }

                                node.querySelector(".status_spd").classList.remove("badge-warning");
                                node.querySelector(".status_spd").textContent = msg;
                                node.querySelector(".status_spd").classList.add("badge-danger");

                                node.querySelector(".loading").style.display = "none";
                                node.querySelector(".btn-reload-spd").style.display = "block";
                            },
                        });
                    }
                },
            });

        });
    });
</script>