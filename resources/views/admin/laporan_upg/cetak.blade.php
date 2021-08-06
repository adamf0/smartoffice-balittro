<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <label>Filter</label>
                <input type="text" class="form-control" disabled="true" value="{{ $data['tanggal'] }}">
           		<label>Download Berkas</label>
                <ul class="list-group list_data">
                    <li class="list-group-item" data-filter="{{ $data['filter'] }}" data-id="{{ $data['data']['id'] }}"">
                        <div class="row">
                            <div class="col-7">
                                <div class="row">
                                    <div class="col-1">
                                        <div class="spinner-border text-primary loading">
                                            <span class="sr-only">Loading...</span>
                                        </div>  
                                    </div>
                                    <div class="col-6   ">
                                        <p class="float-left ml-2"></p>{{ $data['data']['nomor_laporan'] }}</p>
                                    </div>
                                    <div class="col-5">
                                        <button class="btn btn-primary btn-sm btn-reload-upg" style="display: none;">unduh ulang upg</button>
                                    </div> 
                                </div>
                            </div>
                            <div class="col-5 text-right">
                                @if($data['data']['download_upg']==-1)    
                                <h5 class="badge badge-danger badge-lg status_upg">
                                    Gagal Menyimpan UPG
                                </h5>
                                @elseif($data['data']['download_upg']==0)    
                                <h5 class="badge badge-warning status_upg">
                                    Sedang Menyimpan UPG
                                </h5>
                                @else    
                                <h5 class="badge badge-success status_upg">
                                    Tersimpan UPG
                                </h5>
                                @endif
                            </div>
                        </div>
                    </li>
                </ul>
           	</div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $.each($('ul.list_data>li'),function(index, node){
            var id = node.getAttribute('data-id');
            var filter = node.getAttribute('data-filter');

            var url = '{{ url("/admin/cetak/laporan_upg") }}/filter/'+filter+'/'+id;
            console.log(url);

            $.ajax({
                url: url,
                success: function (response) {
                    if(response=="1"){
                        node.querySelector(".status_upg").classList.remove("badge-warning");
                        node.querySelector(".status_upg").textContent = 'Tersimpan UPG';
                        node.querySelector(".status_upg").classList.add("badge-success");
                    }
                    else{
                        node.querySelector(".status_upg").classList.remove("badge-warning");
                        node.querySelector(".status_upg").textContent = 'Gagal Tersimpan UPG';
                        node.querySelector(".status_upg").classList.add("badge-danger");
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

                    node.querySelector(".status_upg").classList.remove("badge-warning");
                    node.querySelector(".status_upg").textContent = msg;
                    node.querySelector(".status_upg").classList.add("badge-danger");

                    node.querySelector(".loading").style.display = "none";
                    node.querySelector(".btn-reload-upg").style.display = "block";
                    
                    node.querySelector('.btn-reload-upg').onclick = function() { 
                        node.querySelector(".status_upg").classList.remove("badge-danger");
                        node.querySelector(".status_upg").textContent = "Sedang Menyimpan UPG";
                        node.querySelector(".status_upg").classList.add("badge-warning");

                        node.querySelector(".loading").style.display = "block";
                        node.querySelector(".btn-reload-upg").style.display = "none";

                        $.ajax({
                            url: url,
                            success: function (response) {
                                if(response=="1"){
                                    node.querySelector(".status_upg").classList.remove("badge-warning");
                                    node.querySelector(".status_upg").textContent = 'Tersimpan UPG';
                                    node.querySelector(".status_upg").classList.add("badge-success");
                                }
                                else{
                                    node.querySelector(".status_upg").classList.remove("badge-warning");
                                    node.querySelector(".status_upg").textContent = 'Gagal Tersimpan UPG';
                                    node.querySelector(".status_upg").classList.add("badge-danger");
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

                                node.querySelector(".status_upg").classList.remove("badge-warning");
                                node.querySelector(".status_upg").textContent = msg;
                                node.querySelector(".status_upg").classList.add("badge-danger");

                                node.querySelector(".loading").style.display = "none";
                                node.querySelector(".btn-reload-upg").style.display = "block";
                            },
                        });
                    }
                },
            });

        });
    });
</script>