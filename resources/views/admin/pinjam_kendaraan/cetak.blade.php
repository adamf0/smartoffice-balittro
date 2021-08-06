<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <label>Filter</label>
                <input type="text" class="form-control" disabled="true" value="@if($data['filter']=='nama') {{ $data['nama'] }}  @elseif($data['filter']=='tujuan') {{ $data['tujuan'] }} @else {{ $data['tanggal'] }} @endif">
           		<label>Download Berkas</label>
                <ul class="list-group list_data">
                    @foreach($data['data'] as $list)    
                    <li class="list-group-item" data-id="{{ $list['id'] }}" data-filter="{{ $data['filter'] }}">
                        <div class="row">
                            <div class="col-7">
                                <div class="row">
                                    <div class="col-1">
                                        <div class="spinner-border text-primary loading">
                                            <span class="sr-only">Loading...</span>
                                        </div>  
                                    </div>
                                    <div class="col-6 text-left">
                                        <p class="ml-2"></p>{{ $list['nomor_laporan'] }}</p>
                                    </div>
                                    <div class="col-5">
                                        <button class="btn btn-primary btn-sm btn-reload" style="display: none;">unduh ulang</button>
                                    </div> 
                                </div>
                            </div>
                            <div class="col-5 text-right">
                                @if($list['download']==-1)    
                                <h5 class="badge badge-danger badge-lg status">
                                    Gagal Menyimpan
                                </h5>
                                @elseif($list['download']==0)    
                                <h5 class="badge badge-warning status">
                                    Sedang Menyimpan
                                </h5>
                                @else    
                                <h5 class="badge badge-success status">
                                    Tersimpan
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
            var filter = node.getAttribute('data-filter');
            var url = '{{ url("/admin/cetak/pinjam_kendaraan") }}/filter/'+filter+'/'+id;
            
            $.ajax({
                url: url,
                success: function (response) {
                    if(response=="1"){
                        node.querySelector(".status").classList.remove("badge-warning");
                        node.querySelector(".status").textContent = 'Tersimpan';
                        node.querySelector(".status").classList.add("badge-success");
                    }
                    else{
                        node.querySelector(".status").classList.remove("badge-warning");
                        node.querySelector(".status").textContent = 'Gagal Tersimpan';
                        node.querySelector(".status").classList.add("badge-danger");
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

                    node.querySelector(".status").classList.remove("badge-warning");
                    node.querySelector(".status").textContent = msg;
                    node.querySelector(".status").classList.add("badge-danger");

                    node.querySelector(".loading").style.display = "none";
                    node.querySelector(".btn-reload").style.display = "block";
                    
                    node.querySelector('.btn-reload').onclick = function() { 
                        node.querySelector(".status").classList.remove("badge-danger");
                        node.querySelector(".status").textContent = "Sedang Menyimpan";
                        node.querySelector(".status").classList.add("badge-warning");

                        node.querySelector(".loading").style.display = "block";
                        node.querySelector(".btn-reload").style.display = "none";

                        $.ajax({
                            url: url,
                            success: function (response) {
                                if(response=="1"){
                                    node.querySelector(".status").classList.remove("badge-warning");
                                    node.querySelector(".status").textContent = 'Tersimpan';
                                    node.querySelector(".status").classList.add("badge-success");
                                }
                                else{
                                    node.querySelector(".status").classList.remove("badge-warning");
                                    node.querySelector(".status").textContent = 'Gagal Tersimpan';
                                    node.querySelector(".status").classList.add("badge-danger");
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

                                node.querySelector(".status").classList.remove("badge-warning");
                                node.querySelector(".status").textContent = msg;
                                node.querySelector(".status").classList.add("badge-danger");

                                node.querySelector(".loading").style.display = "none";
                                node.querySelector(".btn-reload").style.display = "block";
                            },
                        });

                    }
                },
            });
        });
    });
</script>