<style type="text/css">
  .table td{
    border-top: 0px;
  }  
</style>  
      <center>
          <b>
            SURAT TUGAS
          </b>
      </center>
      <br>
      <table class="table" style="font-size:10px">
          <tr>
              <td width="25%">Kepada Yth.</td>
              <td width="75%">: Kuasa Pengguna Anggaran</td>
          </tr>
          <tr>
              <td width="25%">Dari Penanggung Jawab Kegiatan</td>
              <td width="75%">: {{ $data['penanggung_jawab'] }}</td>
          </tr>
          <tr>
              <td width="25%">Judul Kegiatan</td>
              <td width="75%">: {{ $data['judul'] }}</td>
          </tr>
          <tr>
              <td width="25%">Menugaskan</td>
              <td width="75%">: </td>
          </tr>
      </table>
      <table class="table table-bordered" style="font-size:10px">
          <tr>
              <td>No</td>
              <td>Nama</td>
              <td>Gol dan SPD</td>
              <td>Keterangan</td>
          </tr>        
          @php $i=1; @endphp
          @foreach($data['menugaskan'] as $menugaskan =>$item)
          <tr>      
                <td>{{ $i }}</td>
                <td>{{ $item['nama'] }}</td>
                <td>{{ $item['golongan'] }}</td>
                <td></td>
          </tr>
          @php $i++ @endphp
          @endforeach
      </table>
      <br>
      <p style="font-size:10px">Untuk Melakukan Perjalanan Dinas ke {{ $data['tujuan'] }} selama {{ $data['lama'] }} (Hari),tgl {{ $data['tanggal'] }} Dalam Rangka {{ $data['maksud_perjalanan'] }} Setelah melaksanakan tugas yang bersangkutan wajib memebuat laporan perjalanan dinas dan dilaksanakan kepada PPK dan penanggung jawab kegiatan. Demikian surat tugas dikeluarkan untuk dipergunakan sesuai dengan ketentuan yang berlaku. Atas Perhatian Saudara diucapkan terima kasih.</p> 
      <table class="table text-center" style="font-size:10px">
          <tr>
              <td>Mengetahui/Menyetujui:<br>Kuasa Pengguna Anggaran</td>
              <td>Penanggungjawab:<br>RODHP/ROPP/RDHP/RPTP</td>
          </tr>
          <tr>
              <td>
                <br>
                <img src="{{ public_path('storage/'.$data['tanda_tangan']['admin']['tanda_tangan']) }}" width="100px" height="50px">
                <br>
                {{ $data['tanda_tangan']['admin']['nama'] }}
                <br>
                NIP:{{ $data['tanda_tangan']['admin']['nip'] }}
              </td>
              <td>
                <br>
                <img src="{{ public_path('storage/'.$data['tanda_tangan']['pengaju']['tanda_tangan']) }}" width="100px" height="50px">
                <br>
                {{ $data['tanda_tangan']['pengaju']['nama'] }}
                <br>
                NIP:{{ $data['tanda_tangan']['pengaju']['nip'] }}
              </td>
          </tr>
      </table>