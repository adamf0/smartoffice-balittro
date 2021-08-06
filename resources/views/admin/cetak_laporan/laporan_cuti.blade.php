<style type="text/css">
	tr{
		border: 1px solid #000;
	}
	td{
		border: 1px solid #000;
	}
</style>
<div style="width: 100%; font-size: 10px">
	<div style="float: right; margin-right: 20%">
		<p style="float: right; text-align: left; margin-right: 33%;line-height: normal;">
			PERATURAN BADAN KEPEGAWAIAN NEGARA <br>
			REPUBLIK INDONESIA <br>
			NOMOR 24 TAHUN 2017 <br>
			TENTANG PEMBERIAN CUTI PEGAWAI NEGERI SIPIL
		</p>
		<p style="clear: both; display: block; text-align: center;">Bogor,  {{ $data['create'] }}</p>
		<p style="clear: both; display: block; text-align: center;line-height: normal;">
			Kepada Yth, <br>
			Kepala Balai Penelitian Tanaman Rempah dan Obat <br>
			Di Bogor
		</p>
	</div>
	<div style="clear: both;">
		<table border="1" style="width: 100%">
			<tr>
				<td colspan="6">I. Badan Pegawai</td>
			</tr>
			<tr>
				<td style="width: 100px">Nama</td>
				<td style="width: 1px">:</td>
				<td> {{ $data['nama'] }}</td>
				<td style="width: 100px">NIP</td>
				<td style="width: 1px">:</td>
				<td> {{ $data['nip'] }}</td>
			</tr>
			<tr>
				<td style="width: 100px">Jabatan</td>
				<td style="width: 1px">:</td>
				<td> {{ $data['jabatan'] }}</td>
				<td style="width: 100px">Masa Kerja</td>
				<td style="width: 1px">:</td>
				<td> {{ $data['masa_kerja'] }} Hari</td>
			</tr>
			<tr>
				<td style="width: 100px">Unit Kerja</td>
				<td style="width: 1px">:</td>
				<td colspan="4"> {{ $data['unit'] }}</td>
			</tr>
		</table>
	</div>
	<div style="clear: both; margin-top:10px;">
		<table border="1" style="width: 100%">
			<tr>
				<td colspan="4">II. JENIS CUTI YANG DIAMBIL</td>
			</tr>
			<tr>
				<td style="width: 100%">1. Cuti Tahunan</td>
				<td style="width: 100%;">@if($data['jenis_cuti']==1) <center>&#10004</center> @endif</td>
				<td style="width: 100%">2. Cuti Besaran</td>
				<td style="width: 100%">@if($data['jenis_cuti']==4) <center>&#10004</center> @endif</td>
			</tr>
			<tr>
				<td>3. Cuti Sakit</td>
				<td style="width: 100%">@if($data['jenis_cuti']==2) <center>&#10004</center> @endif</td>
				<td style="width: 100%">4. Cuti Melahirkan</td>
				<td style="width: 100%">@if($data['jenis_cuti']==5) <center>&#10004</center> @endif</td>
			</tr>
			<tr>
				<td style="width: 100%">5. Cuti Karena Alasan Penting</td>
				<td style="width: 100%">@if($data['jenis_cuti']==3) <center>&#10004</center> @endif</td>
				<td style="width: 100%">6. Cuti Diluar Tanggungan Negara</td>
				<td style="width: 100%">@if($data['jenis_cuti']==6) <center>&#10004</center> @endif</td>
			</tr>

		</table>
	</div>
	<div style="clear: both; margin-top:10px;">
		<table border="1" style="width: 100%">
			<tr>
				<td colspan="6">III. ALASAN CUTI</td>
			</tr>
			<tr>
				<td colspan="6">
					 {{ $data['alasan'] }}
				</td>
			</tr>
		</table>
	</div>
	<div style="clear: both; margin-top:10px;">
		<table border="1" style="width: 100%">
			<tr>
				<td colspan="4">IV. LAMANYA CUTI</td>
			</tr>
			<tr>
				<td>Selama</td>
				<td style="width: 100px;text-align: center;"> {{ $data['selama'] }} Hari</td>
				<td>Mulai Tanggal</td>
				<td style="width: 300px;text-align: center;"> {{ $data['tanggal_awal'] }} sd  {{ $data['tanggal_akhir'] }}</td>
			</tr>
		</table>
	</div>
	<div style="clear: both; margin-top:10px;">
		<table border="1" style="width: 100%">
			<tr>
				<td colspan="5">V. CATATAN CUTI</td>
			</tr>
			<tr>
				<td colspan="3">1. Cuti Tahunan</td>
				<td>2. Cuti Besar</td>
				<td></td>
			</tr>
			<tr>
				<td style="width: 100px;text-align: center">Tahun</td>
				<td style="width: 100px;text-align: center">Sisa</td>
				<td style="text-align: center">Keterangan</td>
				<td>3. Cuti Sakit</td>
				<td></td>
			</tr>
			<tr>
				<td style="width: 100px;text-align: center">N.2</td>
				<td style="width: 100px;text-align: center"> {{ $data['data_cuti']['n2'] }} Hari</td>
				<td style="text-align: center"></td>
				<td>4. Cuti Melahirkan</td>
				<td></td>
			</tr>
			<tr>
				<td style="width: 100px;text-align: center">N.1</td>
				<td style="width: 100px;text-align: center"> {{ $data['data_cuti']['n1'] }} Hari</td>
				<td style="text-align: center"></td>
				<td>5. Cuti Karena Alasan Penting</td>
				<td></td>
			</tr>
			<tr>
				<td style="width: 100px;text-align: center">N</td>
				<td style="width: 100px;text-align: center"> {{ $data['data_cuti']['n'] }} Hari</td>
				<td style="text-align: center"></td>
				<td>6. Cuti Diluar Tanggungan Negara</td>
				<td></td>
			</tr>

		</table>
	</div>
	<div style="clear: both; margin-top:10px;">
		<table border="1" style="width: 100%">
			<tr>
				<td colspan="3">VI. ALAMAT SELAMA MENJALANKAN CUTI</td>
			</tr>
			<tr>
				<td rowspan="2" style="width: 300px;line-height: normal;">{{ $data['alamat_cuti'] }}</td>
				<td>Telepon</td>
				<td style="width: 250px">{{ $data['telp'] }}</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align: center;">
					Hormat Saya <br><br>
					<img src="{{ public_path('storage/'.$data['penerima']['tanda_tangan']) }}" width="100px" height="50px">
					<br>
					{{ $data['penerima']['nama'] }}<br>
					NIP {{ $data['penerima']['nip'] }}
				</td>
			</tr>
		</table>
	</div>
	<div style="clear: both; margin-top:10px;">
		<table border="1" style="width: 100%">
			<tr>
				<td colspan="4">VII. PERTIMBANAGAN ATASAN LANGSUNG</td>
			</tr>
			<tr>
				<td>DISETUI @if($data['acc1']['status']==1) &#10004 @endif</td>
				<td>PERUBAHAN @if($data['acc1']['status']==-1) &#10004 @endif</td>
				<td>DITANGGUHKAN @if($data['acc1']['status']==-2) &#10004 @endif</td>
				<td>TIDAK DISETUJUI @if($data['acc1']['status']==-3) &#10004 @endif</td>
			</tr>
			<tr>
				<td colspan="3" style="line-height: normal;">
					Alasan: {{ $data['acc1']['alasan'] }}
				</td>
				<td style="text-align: center; width: 300px;line-height: normal;">
					Kepala Subbag Tata Usaha <br> Kasie Yantek/Kasie Jaslit/Ketua Kelti<br><br>
					<img src="{{ public_path('storage/'.$data['acc1']['tanda_tangan']['tanda_tangan']) }}" width="100px" height="50px">
					<br>

					{{ $data['acc1']['tanda_tangan']['nama'] }}<br>
					NIP {{ $data['acc1']['tanda_tangan']['nip'] }}
				</td>
			</tr>

		</table>
	</div>
	<div style="clear: both; margin-top:10px;">
		<table border="1" style="width: 100%">
			<tr>
				<td colspan="4">VII. KEPUTUSAN PENJABAT YANG BERWENANG MEMBERIKAN CUTI</td>
			</tr>
			<tr>
				<td>DISETUI @if($data['acc2']['status']==1) &#10004 @endif</td>
				<td>PERUBAHAN @if($data['acc2']['status']==-1) &#10004 @endif</td>
				<td>DITANGGUHKAN @if($data['acc2']['status']==-2) &#10004 @endif</td>
				<td>TIDAK DISETUJUI @if($data['acc2']['status']==-3) &#10004 @endif</td>
			</tr>
			<tr>
				<td colspan="3" style="line-height: normal;">
					Alasan: {{ $data['acc2']['alasan'] }}				
				</td>
				<td style="text-align: center; width: 300px;line-height: normal;">
					Kepala Balai <br><br>
					<img src="{{ public_path('storage/'.$data['acc2']['tanda_tangan']['tanda_tangan']) }}" width="100px" height="50px">
					<br>

					{{ $data['acc2']['tanda_tangan']['nama'] }}<br>
					NIP {{ $data['acc2']['tanda_tangan']['nip'] }}
				</td>
			</tr>

		</table>
	</div>
</div>