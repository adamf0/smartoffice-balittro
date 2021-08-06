<div class="row">
	<div class="col-md-12">
		<div class="alert alert-success">Selamat Datang Di Smart Office Balittro</div>
	</div>
	@if(Session::get('role')==1)
    	<div class="col-lg-4 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
     	           	<h3>{{$sppd}} Berkas</h3>
                    <p>Total Pengajuan Surat Perjalanan Dinas <small>(Menunggu Respon)</small></p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-purple">
                <div class="inner">
     	           	<h3>{{$cuti2}} Berkas</h3>
                    <p>Total Pengajuan Cuti <small>(Menunggu Respon)</small></p>
                </div>
            </div>
        </div>
    @elseif(Session::get('role')==5)
        <div class="col-lg-4 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
     	           	<h3>{{$spd}} Berkas</h3>
                    <p>Total Surat Perjalanan Dinas <small>(Belum Dibuat)</small></p>
                </div>
            </div>
        </div>
    @elseif(Session::get('role')==6)
        <div class="col-lg-4 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
     	           	<h3>{{$bendahara}} Berkas</h3>
                    <p>Total Surat Kwitansi Perjalanan Dinas<small>(Belum Dibuat)</small></p>
                </div>
            </div>
        </div>
    @elseif(Session::get('role')==7)
        <div class="col-lg-4 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
     	           	<h3>{{$kwitansi}} Berkas</h3>
                    <p>Total Surat Kwitansi <small>(Belum Acc)</small></p>
                </div>
            </div>
        </div>
    @elseif(Session::get('role')==8)
        <div class="col-lg-4 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
     	           	<h3>{{$kendaraan}} Berkas</h3>
                    <p>Total Pengajuan Pinjam Kendaraan <small>(Menunggu Respon)</small></p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-purple">
                <div class="inner">
     	           	<h3>{{$cuti1}} Berkas</h3>
                    <p>Total Pengajuan Cuti <small>(Menunggu Respon)</small></p>
                </div>
            </div>
        </div>
    @elseif(Session::get('role')==9)
        <div class="col-lg-4 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
     	           	<h3>{{$upg}} Berkas</h3>
                    <p>Total Pengajuan Laporan Gratifikasi <small>(Menunggu Respon)</small></p>
                </div>
            </div>
        </div>
    @endif
    
</div>