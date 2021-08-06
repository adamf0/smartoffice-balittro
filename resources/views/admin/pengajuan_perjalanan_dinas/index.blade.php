<div class="row">
	@if (Session::has('type_msg'))
	<div class="col-12">
		@if(Session::get('type_msg')==0)
		<div class="alert alert-danger alert-block notif">
		@else(Session::get('type_msg')==1)
		<div class="alert alert-success alert-block notif">
		@endif
		    <button type="button" class="close" data-dismiss="alert">×</button> 
		    <strong>{{ Session::get('msg') }}</strong>
		</div>
	</div>
	@endif

    <div class="col-12">
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
            	<a href="{{ url('/admin/cetak/pengajuan_perjalanan_dinas') }}" class="btn btn-primary">Simpan Laporan SPPD Digital</a><br><br>
	            <table id="table" class="table table-responsive table-normal">
	                <thead>
		                <tr>
		                  <th>#</th>
		                  <th>Nomor Perjalanan Dinas</th>
		                  <th>Pemohon</th>
		                  <th>Penanggung Jawab</th>
		                  <th>Judul Kegiatan</th>
		                  <th>Menugaskan</th>
		                  <th>Tujuan</th>
		                  <th>Maksud Perjalanan</th>
		                  <th>Tanggal</th>
		                  <th>Lama Perjalanan</th>
		                  <th>Kegiatan</th>
		                  <th>Kendaraan</th>
		                  <th>Surat Tugas</th>
		                  <th>Pagu Anggaran</th>
		                  <th>Biaya Telah Digunakan</th>
		                  <th>Biaya Akan Digunakan</th>
		                  <th>Sisa Anggaran</th>
		                  <th>Status</th>
		                  <th>Aksi</th>
		                </tr>
	                </thead>
	                <tbody>
                	@php $i=1; @endphp
                	@foreach($datas as $data)
	                	<tr>
	                		<td>{{ $i }}</td>
	                		<td>{{ $data['nomor_perjalanan_dinas'] }}</td>
	                		<td>{{ $data['pemohon']['nama'] }}</td>	          
	                		<td>{{ $data['penanggung_jawab']['nama'] }}</td>	          
		                	<td>{{ $data['judul_kegiatan'] }}</td>
		                	<td>
	                			<ul style="margin-left: -20px;">
	                				@foreach($data['menugaskan'] as $menugaskan)
	                				<li>{{ $menugaskan['nip']."-".$menugaskan['nama'] }}</li>
	                				@endforeach
	                			</ul>
	                		</td>
		                	<td>{{ $data['tujuan'] }}</td>
		                	<td>{{ $data['maksud_perjalanan'] }}</td>
		                	<td>{{ $data['tanggal'] }}</td>
		                	<td>{{ $data['lama_perjalanan'] }} Hari</td>
		                	<td>{{ $data['kegiatan'] }}</td>
		                	<td>
		                		@if($data['kendaraan']==0)
		                		<label class="badge badge-success">
		                		@else
		                		<label class="badge badge-primary">
		                		@endif
		                			{{ $data['kendaraan'] }}
		                		</label>
		                	</td>
		                	<td>
		                		@if($data['surat_tugas']==1)
		                		<label class="badge badge-success">
		                			Ya
		                		@else
		                		<label class="badge badge-danger">
		                			Tidak
		                		@endif
		                		</label>
		                	</td>
		                	<td>{{ "Rp " . number_format($data['pagu_anggaran'],0,'','.') }}</td>
		                	<td>{{ "Rp " . number_format($data['biaya_telah_digunakan'],0,'','.') }}</td>
		                	<td>{{ "Rp " . number_format($data['biaya_akan_digunakan'],0,'','.') }}</td>
		                	<td>{{ "Rp " . number_format( (($data['pagu_anggaran']-$data['biaya_telah_digunakan'])-$data['biaya_akan_digunakan']) ,0,'','.') }}</td>
		                	<td>
		                		@if($data['status_acc']==-1)
		               			<label class="badge badge-danger">
		               				Tolak Pengajuan Perjalanan Dinas
		               			@elseif($data['status_acc']==0)
		               			<label class="badge badge-warning">
		               				Menunggu Pengajuan Perjalanan Dinas
		               			@elseif($data['status_acc']==1)
		               			<label class="badge badge-success">
		               				ACC Pengajuan Perjalanan Dinas
		               			@else
		               			<label class="badge badge-primary">
		               				Belum Lengkap Pengajuan Perjalanan Dinas
		               			@endif
		               			</label>
		                	</td>
		                	<td>
		                		@php $id = $data['id'] @endphp
			               		<a href='{{ url("/admin/pengajuan_perjalanan_dinas/reject/".$id) }}' class="btn btn-danger btn-block">Tolak Laporan</a><br><br>
			               		<a href='{{ url("/admin/pengajuan_perjalanan_dinas/acc/".$id) }}' class="btn btn-success btn-block">ACC Laporan</a><br><br>
			               		<a href='{{ url("/admin/pengajuan_perjalanan_dinas/invalid/".$id) }}' class="btn btn-info btn-block">Laporan Tidak Lengkap</a><br><br>
			               		
			               		@if($data['status_acc']==1)
			               		<div class="dropdown show">
								  <a class="btn btn-secondary btn-block dropdown-toggle" href="#" id="btn-drop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								    Cetak
								  </a>

								  <div class="dropdown-menu" aria-labelledby="btn-drop">
								    <a class="dropdown-item" href="{{ url('/admin/download/pengajuan_perjalanan_dinas').'/'.$id }}" target="_blank">Cetak Surat Pengajuan Perjalanan Dinas</a>
								    @if($data['surat_tugas']==1)
								    <a class="dropdown-item" href="{{ url('/admin/download/surat_tugas').'/'.$id }}" target="_blank">Cetak Surat Tugas</a>
								    @endif
								  </div>
								</div>
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
