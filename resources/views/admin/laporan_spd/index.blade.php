<style type="text/css">

</style>
<div class="row">
    @if (Session::has('type_msg'))
    <div class="col-12">
        @if(Session::get('type_msg')==0)
        <div class="alert alert-danger alert-block notif">
        @elseif(Session::get('type_msg')==1)
        <div class="alert alert-success alert-block notif">
        @endif
            <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>{{ Session::get('msg') }}</strong>
        </div>
    </div>
    @endif
    <div class="card">
        <div class="card-header ui-sortable-handle bg-primary" style="cursor: move;">
            <h3 class="card-title"> </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                   <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="col-12">
                <a href='{{ url("/admin/laporan_spd/add") }}' class="btn btn-info">Tambah Data</a>
                <a href="{{ url('/admin/cetak/surat_spd') }}" class="btn btn-primary">Simpan Laporan SPD Digital</a>
            </div>
            <div class="col-12 mt-2">
                    <table id="table" class="table table-responsive table-normal">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nomor Laporan</th>
                                <th>Biaya Perjalanan Dinas</th>
                                <th>Maksud Perjalanan</th>
                                <th>Angkutan</th>
                                <th>Tempat Berangkat</th>
                                <th>Tempat Tujuan</th>
                                <th>Lama Perjalanan</th>
                                <th>Tanggal Berangkat</th>
                                <th>Tanggal Akhir</th>
                                <th>Keterangan</th>
                                <th>Pengikut</th>
                                <th>Keterangan Lain</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1; @endphp
                            @foreach($datas as $data)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $data['nomor_laporan'] }}</td>
                                    <td>{{ $data['biaya_perjalanan_dinas'] }}</td>
                                    <td>{{ $data['maksud_perjalanan'] }}</td>
                                    <td>
                                    @if($data['angkutan']==1)
                                        <label class="badge badge-primary">Umum</label>
                                    @else($data['angkutan']==0)
                                        <label class="badge badge-success">Dinas</label>                 
                                    @endif
                                    </td>
                                    <td>
                                        @if($data['tempat_berangkat']==null)
                                            <label class="badge badge-danger">N/a</label> 
                                        @else
                                             {{ $data['tempat_berangkat'] }}          
                                        @endif
                                    </td>
                                    <td>{{ $data['tempat_tujuan'] }}</td>
                                    <td>{{ $data['lama_perjalanan'] }}</td>
                                    <td>{{ $data['tanggal_berangkat'] }}</td>
                                    <td>{{ $data['tanggal_akhir'] }}</td>
                                    <td>
                                        @if($data['keterangan']==1)
                                            <label class="badge badge-success">Tanggal harus kembali</label>
                                        @elseif($data['keterangan']==0)
                                            <label class="badge badge-primary">Tiba di tempat baru</label>   
                                        @elseif($data['keterangan']==-1)
                                             <label class="badge badge-danger">N/a</label>         
                                        @endif
                                    </td>
                                    <td>
                                        <ol>
                                            @foreach($data['pengikut'] as $pengikut)
                                                <li>{{ $pengikut['nama'] }}</li>
                                            @endforeach
                                        </ol>
                                    </td>
                                    <td>
                                        @if($data['keterangan_lain']==null)
                                            <label class="badge badge-danger">N/a</label> 
                                        @else
                                             {{ $data['keterangan_lain'] }}          
                                        @endif
                                    </td>
                                    <td>
                                        @if($data['status']==0)
                                            <label class="badge badge-danger">Laporan SPD Belum Ada</label>
                                        @elseif($data['status']==1)
                                            <label class="badge badge-success">Laporan SPD Sudah Ada</label>                 
                                        @endif
                                    </td>
                                    <td>
                                        @php $id = $data['id'];$id_sppd = $data['id_sppd']; @endphp
                                        @if($data['status']==1)
                                            <a href='{{ url("/admin/laporan_spd/delete/".$id) }}' class="btn btn-danger btn-block">Hapus</a>
                                            <a href='{{ url("/admin/laporan_spd/edit/".$id) }}' class="btn btn-warning btn-block mt-2">Ubah</a>             
                                            @if($id_sppd != -1)
                                            <a href='{{ url("/admin/download/surat_spd/$id_sppd") }}' class="btn btn-secondary btn-block mt-2" target="_blank">Cetak Laporan SPD</a>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @php $i++ @endphp
                            @endforeach
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
</div>