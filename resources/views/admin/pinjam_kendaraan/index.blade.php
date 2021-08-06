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
            	<a href="{{ url('/admin/cetak/pinjam_kendaraan') }}" class="btn btn-primary">Simpan Laporan Pinjam Kendaraan Digital</a><br><br>
	            <table id="table" class="table table-responsive table-normal">
	                <thead>
		                <tr>
		                  <th>#</th>
		                  <th>Peminjam</th>
		                  <th>Jenis Kendaraan</th>
		                  <th>Keperluan</th>
		                  <th>Tujuan</th>
		                  <th>Tanggal</th>
		                  <th>Jam</th>
		                  <th>Lama Keperluan</th>
		                  <th>Pengemudi</th>
		                  <th>Penumpang</th>
		                  <th>Status</th>
		                  <th>Aksi</th>
		                </tr>
	                </thead>
	                <tbody>
	                @php $i=1; @endphp
	                @foreach($datas as $data)
		               	<tr>
		               		<td>{{ $i }}</td>
		               		<td>
		               			@if($data['peminjam']==null)
		               				<label class="badge badge-danger">N/a</label>
		               			@else
		               				{{ $data['peminjam']['nama'] }}
		               			@endif
		               		</td>
		               		<td>
		               			@if($data['jenis_kendaraan']==1)
		               			<label class="badge badge-success">
		               				Dinas
		               			@else
		               			<label class="badge badge-primary">
		               				Umum
		               			@endif
		               			</label>
		               		</td>
		               		<td>
		               			@if($data['keperluan']==1)
		               			<label class="badge badge-success">
		               				Dinas
		               			@else
		               			<label class="badge badge-primary">
		               				Sosial
		               			@endif
		               			</label>
		               		</td>
		               		<td>
		               			@if($data['tujuan']==null)
		               				<label class="badge badge-danger">N/a</label>
		               			@else
		               				{{ $data['tujuan']['tujuan'] }}
		               			@endif
		               		</td>
		               		<td>{{ $data['tanggal'] }}</td>
		               		<td>{{ $data['jam'] }}</td>
		               		<td>{{ $data['lama'] }} Hari</td>
		               		<td>
		               			@if(count($data['pengemudi'])>0)
			               			<ul style="margin-left: -20px;">
			               				@foreach($data['pengemudi'] as $pengemudi)
			               				<li>
			               					{{ $pengemudi['nama'] }}
			               					@if($pengemudi['accept']==-1)
					               			<label class="badge badge-danger">
					               				Tolak Terima
					               			@elseif($pengemudi['accept']==0)
					               			<label class="badge badge-warning">
					               				Menunggu Terima
					               			@elseif($pengemudi['accept']==1)
					               			<label class="badge badge-success">
					               				Terima
					               			@else
					               			<label class="badge badge-warning">
					               				N/a
					               			@endif
					               			</label>
			               				</li>
			               				@endforeach
			               			</ul>
		               			@else
		               				<label class="badge badge-danger">Belum Ada Pengemudi</label> 
		               			@endif
		               		</td>
		               		<td>
		               			@if(count($data['penumpang']))
			               			<ul style="margin-left: -20px;">
			               				@foreach($data['penumpang'] as $penumpang)
			               				<li>{{ $penumpang['nip']."-".$penumpang['nama'] }}</li>
			               				@endforeach
			               			</ul>
		               			@else
		               				Belum Ada Penumpang 
		               			@endif
		               		</td>
		               			<td>
		               			@if($data['surat_perjalanan_dinas'] != null)
			               			@if($data['surat_perjalanan_dinas']['status_perjalanan_dinas']==-1)
			               			<label class="badge badge-danger">
			               				Tolak ACC Pengajuan Perjalanan Dinas
			               			@elseif($data['surat_perjalanan_dinas']['status_perjalanan_dinas']==0)
			               			<label class="badge badge-warning">
			               				Menunggu ACC Pengajuan Perjalanan Dinas
			               			@elseif($data['surat_perjalanan_dinas']['status_perjalanan_dinas']==1)
			               			<label class="badge badge-success">
			               				ACC Pengajuan Perjalanan Dinas
			               			@else
			               			<label class="badge badge-primary">
			               				Belum Lengkap Pengajuan Perjalanan Dinas
			               			@endif
			               			</label>
			               			<br>
			               		@endif

		               			@if($data['status_pinjam_kendaraan']==-1)
		               			<label class="badge badge-danger">
		               				Tolak ACC Pinjam Kendaraan
		               			@elseif($data['status_pinjam_kendaraan']==0)
		               			<label class="badge badge-warning">
		               				Menunggu ACC Pinjam Kendaraan
		               			@elseif($data['status_pinjam_kendaraan']==1)
		               			<label class="badge badge-success">
		               				ACC Pinjam Kendaraan
		               			@else
		               			<label class="badge badge-primary">
		               				Belum Lengkap Pinjam Kendaraan
		               			@endif
		               			</label>
		               		</td>
		               		<td>
		               			@php $id = $data['id'] @endphp
		               			<a href='{{ url("/admin/pinjam_kendaraan/reject/".$id) }}' class="btn btn-danger btn-block">Tolak Laporan</a><br><br>
			               		<a href='{{ url("/admin/pinjam_kendaraan/form/acc/".$id) }}' class="btn btn-success btn-block">ACC Laporan</a><br><br>
			               		<a href='{{ url("/admin/pinjam_kendaraan/invalid/".$id) }}' class="btn btn-info btn-block">Laporan Tidak Lengkap</a><br><br>
			               		@if($data['status_pinjam_kendaraan']==1)
			               		<a href='{{ url("/admin/pinjam_kendaraan/form/edit/".$id) }}' class="btn btn-warning btn-block">Ubah Pengemudi</a><br><br>
			               		<a href='{{ url("/admin/download/pinjam_kendaraan/".$id) }}' class="btn btn-secondary btn-block">Cetak Surat Pinjam Kendaraan</a>
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
