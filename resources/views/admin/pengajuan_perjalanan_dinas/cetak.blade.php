<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <label>Filter</label>
                <input type="text" class="form-control" disabled="true" value="@if($data['filter']=='nama') {{ $data['nama'] }}  @elseif($data['filter']=='tujuan') {{ $data['tujuan'] }} @else {{ $data['tanggal'] }} @endif">
           		<label>Download Berkas</label>
                <ul class="list-group list_data">
                    @foreach($data['data'] as $list)    
                    <li class="list-group-item" data-id="{{ $list['id'] }}" data-filter="{{ $data['filter'] }}" data-st="{{ $list['surat_tugas'] }}">
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
                                        <button class="btn btn-primary btn-sm btn-reload-sppd" style="display: none;">unduh ulang sppd</button>
                                        @if($list['surat_tugas']==1)
                                        <button class="btn btn-primary btn-sm btn-reload-st" style="display: none;">unduh ulang surat tugas</button>
                                        @endif
                                    </div> 
                                </div>
                            </div>
                            <div class="col-5 text-right">
                                @if($list['download_sppd']==-1)    
                                <h5 class="badge badge-danger badge-lg status_sppd">
                                    Gagal Menyimpan SPPD
                                </h5>
                                @elseif($list['download_sppd']==0)    
                                <h5 class="badge badge-warning status_sppd">
                                    Sedang Menyimpan SPPD
                                </h5>
                                @else    
                                <h5 class="badge badge-success status_sppd">
                                    Tersimpan SPPD
                                </h5>
                                @endif
                                
                                @if($list['surat_tugas']==1)
                                    @if($list['download_st']==-1)    
                                    <h5 class="badge badge-danger badge-lg status_st">
                                        Gagal Menyimpan Surat Tugas
                                    </h5>
                                    @elseif($list['download_st']==0)    
                                    <h5 class="badge badge-warning status_st">
                                        Sedang Menyimpan Surat Tugas
                                    </h5>
                                    @else    
                                    <h5 class="badge badge-success status_st">
                                        Tersimpan Surat Tugas
                                    </h5>
                                    @endif
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
            var surat_tugas = node.getAttribute('data-st');
            var filter = node.getAttribute('data-filter');
            var url = '{{ url("/admin/cetak/pengajuan_perjalanan_dinas") }}/filter/'+filter+'/'+id;
            var url_st = '{{ url("/admin/cetak/surat_tugas") }}/filter/'+filter+'/'+id;

            $.ajax({
                url: url,
                success: function (response) {
                    if(response=="1"){
                        node.querySelector(".status_sppd").classList.remove("badge-warning");
                        node.querySelector(".status_sppd").textContent = 'Tersimpan SPPD';
                        node.querySelector(".status_sppd").classList.add("badge-success");

                        if(surat_tugas==1){
                            $.ajax({
                                url: url_st,
                                success: function (response) {
                                    if(response=="1"){
                                        node.querySelector(".status_st").classList.remove("badge-warning");
                                        node.querySelector(".status_st").textContent = 'Tersimpan Surat Tugas';
                                        node.querySelector(".status_st").classList.add("badge-success");
                                    }
                                    else{
                                        node.querySelector(".status_st").classList.remove("badge-warning");
                                        node.querySelector(".status_st").textContent = 'Gagal Tersimpan Surat Tugas';
                                        node.querySelector(".status_st").classList.add("badge-danger");
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

                                    node.querySelector(".status_st").classList.remove("badge-warning");
                                    node.querySelector(".status_st").textContent = msg;
                                    node.querySelector(".status_st").classList.add("badge-danger");

                                    node.querySelector(".loading").style.display = "none";
                                    node.querySelector(".btn-reload-st").style.display = "block";
                                    
                                    node.querySelector('.btn-reload-st').onclick = function() { 
                                        node.querySelector(".status_st").classList.remove("badge-danger");
                                        node.querySelector(".status_st").textContent = "Sedang Menyimpan Surat Tugas";
                                        node.querySelector(".status_st").classList.add("badge-warning");

                                        node.querySelector(".loading").style.display = "block";
                                        node.querySelector(".btn-reload-st").style.display = "none";

                                        $.ajax({
                                            url: url_st,
                                            success: function (response) {
                                                if(response=="1"){
                                                    node.querySelector(".status_st").classList.remove("badge-warning");
                                                    node.querySelector(".status_st").textContent = 'Tersimpan Surat Tugas';
                                                    node.querySelector(".status_st").classList.add("badge-success");
                                                }
                                                else{
                                                    node.querySelector(".status_st").classList.remove("badge-warning");
                                                    node.querySelector(".status_st").textContent = 'Gagal Tersimpan Surat Tugas';
                                                    node.querySelector(".status_st").classList.add("badge-danger");
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

                                                node.querySelector(".status_st").classList.remove("badge-warning");
                                                node.querySelector(".status_st").textContent = msg;
                                                node.querySelector(".status_st").classList.add("badge-danger");

                                                node.querySelector(".loading").style.display = "none";
                                                node.querySelector(".btn-reload-st").style.display = "block";
                                            },
                                        });
                                    }
                                },
                            });
                        }
                        else{
                            node.querySelector(".loading").style.display = "none";
                        }
                        
                    }
                    else{
                        node.querySelector(".status_sppd").classList.remove("badge-warning");
                        node.querySelector(".status_sppd").textContent = 'Gagal Tersimpan SPPD';
                        node.querySelector(".status_sppd").classList.add("badge-danger");

                        if(surat_tugas==1){
                            node.querySelector(".status_st").classList.remove("badge-warning");
                            node.querySelector(".status_st").textContent = 'Gagal Tersimpan Surat Tugas';
                            node.querySelector(".status_st").classList.add("badge-danger");
                        }
                        
                        node.querySelector(".loading").style.display = "none";
                    }
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

                    node.querySelector(".status_sppd").classList.remove("badge-warning");
                    node.querySelector(".status_sppd").textContent = msg;
                    node.querySelector(".status_sppd").classList.add("badge-danger");

                    if(surat_tugas==1){
                        node.querySelector(".status_st").classList.remove("badge-warning");
                        node.querySelector(".status_st").textContent = msg;
                        node.querySelector(".status_st").classList.add("badge-danger");
                    }

                    node.querySelector(".loading").style.display = "none";
                    node.querySelector(".btn-reload-sppd").style.display = "block";
                    
                    node.querySelector('.btn-reload-sppd').onclick = function() { 
                        node.querySelector(".status_sppd").classList.remove("badge-danger");
                        node.querySelector(".status_sppd").textContent = "Sedang Menyimpan SPPD";
                        node.querySelector(".status_sppd").classList.add("badge-warning");

                        if(surat_tugas==1){
                            node.querySelector(".status_st").classList.remove("badge-danger");
                            node.querySelector(".status_st").textContent = "Sedang Menyimpan Surat Tugas";
                            node.querySelector(".status_st").classList.add("badge-warning");
                        }

                        node.querySelector(".loading").style.display = "block";
                        node.querySelector(".btn-reload-sppd").style.display = "none";

                        $.ajax({
                            url: url,
                            success: function (response) {
                                if(response=="1"){
                                    node.querySelector(".status_sppd").classList.remove("badge-warning");
                                    node.querySelector(".status_sppd").textContent = 'Tersimpan SPPD';
                                    node.querySelector(".status_sppd").classList.add("badge-success");

                                    if(surat_tugas==1){
                                        $.ajax({
                                            url: url_st,
                                            success: function (response) {
                                                if(response=="1"){
                                                    node.querySelector(".status_st").classList.remove("badge-warning");
                                                    node.querySelector(".status_st").textContent = 'Tersimpan Surat Tugas';
                                                    node.querySelector(".status_st").classList.add("badge-success");
                                                }
                                                else{
                                                    node.querySelector(".status_st").classList.remove("badge-warning");
                                                    node.querySelector(".status_st").textContent = 'Gagal Tersimpan Surat Tugas';
                                                    node.querySelector(".status_st").classList.add("badge-danger");
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

                                                node.querySelector(".status_st").classList.remove("badge-warning");
                                                node.querySelector(".status_st").textContent = msg;
                                                node.querySelector(".status_st").classList.add("badge-danger");

                                                node.querySelector(".loading").style.display = "none";
                                                node.querySelector(".btn-reload-st").style.display = "block";
                                                
                                                node.querySelector('.btn-reload-st').onclick = function() { 
                                                    node.querySelector(".status_st").classList.remove("badge-danger");
                                                    node.querySelector(".status_st").textContent = "Sedang Menyimpan Surat Tugas";
                                                    node.querySelector(".status_st").classList.add("badge-warning");

                                                    node.querySelector(".loading").style.display = "block";
                                                    node.querySelector(".btn-reload-st").style.display = "none";

                                                    $.ajax({
                                                        url: url_st,
                                                        success: function (response) {
                                                            if(response=="1"){
                                                                node.querySelector(".status_st").classList.remove("badge-warning");
                                                                node.querySelector(".status_st").textContent = 'Tersimpan Surat Tugas';
                                                                node.querySelector(".status_st").classList.add("badge-success");
                                                            }
                                                            else{
                                                                node.querySelector(".status_st").classList.remove("badge-warning");
                                                                node.querySelector(".status_st").textContent = 'Gagal Tersimpan Surat Tugas';
                                                                node.querySelector(".status_st").classList.add("badge-danger");
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

                                                            node.querySelector(".status_st").classList.remove("badge-warning");
                                                            node.querySelector(".status_st").textContent = msg;
                                                            node.querySelector(".status_st").classList.add("badge-danger");

                                                            node.querySelector(".loading").style.display = "none";
                                                            node.querySelector(".btn-reload-st").style.display = "block";
                                                        },
                                                    });
                                                }
                                            },
                                        });
                                    }
                                    else{
                                        node.querySelector(".loading").style.display = "none";
                                    }
                                }
                                else{
                                    node.querySelector(".status_sppd").classList.remove("badge-warning");
                                    node.querySelector(".status_sppd").textContent = 'Gagal Tersimpan SPPD';
                                    node.querySelector(".status_sppd").classList.add("badge-danger");

                                    if(surat_tugas==1){
                                        node.querySelector(".status_st").classList.remove("badge-warning");
                                        node.querySelector(".status_st").textContent = 'Gagal Tersimpan Surat Tugas';
                                        node.querySelector(".status_st").classList.add("badge-danger");
                                    }

                                    node.querySelector(".loading").style.display = "none";
                                }
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

                                node.querySelector(".status_sppd").classList.remove("badge-warning");
                                node.querySelector(".status_sppd").textContent = msg;
                                node.querySelector(".status_sppd").classList.add("badge-danger");

                                if(surat_tugas==1){
                                    node.querySelector(".status_st").classList.remove("badge-warning");
                                    node.querySelector(".status_st").textContent = msg;
                                    node.querySelector(".status_st").classList.add("badge-danger");
                                }

                                node.querySelector(".loading").style.display = "none";
                                node.querySelector(".btn-reload-sppd").style.display = "block";
                            },
                        });
                    }
                },
            });

        });
    });
</script>