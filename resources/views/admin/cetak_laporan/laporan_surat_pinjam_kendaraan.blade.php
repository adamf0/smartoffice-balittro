<style type="text/css">
  .table td{
    border-top: 0px;
    padding: 0.5em
  }  
  hr {
      margin-top: 1rem;
      margin-bottom: 1rem;
      border: 0;
      border-top: 1px solid #000;
    }
</style>
        <center>
            <b>
              SURAT PINJAMAN KENDARAAN
            </b>    
        </center>
        <br>
        <table class="table" style="font-size:10px">
            <tr>
                <td width="20%">Nama</td>
                <td width="25%">: {{ $data['nama'] }}</td>
                <td width="20%">Pangkat</td>
                <td width="25%">: {{ $data['pangkat'] }}</td>
            </tr>
            <tr>
                <td width="20%">Subbag/Kasie/Kelti</td>
                <td width="25%">: {{ $data['subbag'] }}</td>
                <td width="20%">Jenis Kendaraan</td>
                <td width="25%">: 
                    @if($data['jenis_kendaraan'] == 1)
                        Dinas
                    @else
                        <strike>Dinas</strike>
                    @endif
                    / 
                    @if($data['jenis_kendaraan'] == 0)
                        Umum
                    @else
                        <strike>Umum</strike>
                    @endif
                </td>
            </tr>
            <tr>
                <td width="20%">Penumpang yang ikut</td>
                <td width="25%">: {{ $data['penumpang'] }}</td>
                <td width="20%">Keperluan</td>
                <td width="25%">: 
                    @if($data['keperluan'] == 1)
                        Dinas
                    @else
                        <strike>Dinas</strike>
                    @endif
                    / 
                    @if($data['keperluan'] == 0)
                        Sosial
                    @else
                        <strike>Sosial</strike>
                    @endif

                </td>
            </tr>
            <tr>
                <td width="20%">Tujuan</td>
                <td width="25%">: {{ $data['tujuan'] }}</td>
                <td width="20%">Jam Berangkat</td>
                <td width="25%">: {{ $data['jam_berangkat'] }}</td>
            </tr>
            <tr>
                <td width="20%">Tanggal yang diinginkan</td>
                <td width="25%">: {{ $data['tanggal_berangkat'] }}</td>
                <td width="20%">Lapanya Keperluan</td>
                <td width="25%">: {{ $data['lama_keperluan'] }}</td>
            </tr>
        </table>
        <br>
        <table class="table text-center" style="font-size:10px">
          <tr>
              <td class="text-center">Mengetahui/Menyetujui <br>Kepala Subbag TU <br></td>
              <td class="text-center">Bogor,{{ $data['create'] }} <br>pemohon,</td>
          </tr>
          <tr>
              <td class="text-center">
                <br>
                <img src="{{ public_path('storage/'.$data['tanda_tangan']['admin']['tanda_tangan']) }}" width="100px" height="50px">
                <br>
                nip. {{ $data['tanda_tangan']['admin']['nip'] }}
              </td>
              <td class="text-center">
                <br>
                <img src="{{ public_path('storage/'.$data['tanda_tangan']['peminjam']['tanda_tangan']) }}" width="100px" height="50px">
                <br>
                nip. {{ $data['tanda_tangan']['peminjam']['nip'] }}
              </td>        
        </table>
        <br>
        <hr>
        <center>
            <b>
              PERINTAH JALAN
            </b>
        </center>
        <br>
        <table class="table" style="font-size:10px">
            <tr>
                <td width="20%">Nama Pengemudi</td>
                <td width="25%">: {{ $data['nama_pengemudi'] }}</td>
                <td width="20%">Tanggal</td>
                <td width="25%">: {{ $data['tanggal_berangkat'] }}</td>
            </tr>
            <tr>
                <td width="20%">Jenis Kendaraan</td>
                <td width="25%">: @if($data['jenis_kendaraan']==1) Dinas @else Umum @endif</td>
                <td width="20%">Tujuan</td>
                <td width="25%">: {{ $data['tujuan'] }}</td>
            </tr>
            <tr>
                <td width="20%">No.Polisi</td>
                <td width="25%">: {{ $data['no_polisi'] }}</td>
                <td width="20%">Waktu/Jam</td>
                <td width="25%">: {{ $data['jam_berangkat'] }}</td>
            </tr>
            <tr>
                <td width="20%">Keperluan</td>
                <td width="25%">: @if($data['keperluan']==1) Dinas @else Umum @endif</td>
                <td width="20%">Lamanya</td>
                <td width="25%">: {{ $data['lama_keperluan'] }}</td>
            </tr>
        </table>
        <br>
        <center>
            <b>POOL KENDARAAN</b>
            <br>
            <br>
            <br>
            <br>
            <p style="margin-left: -200px">NIP.</p>
        </center>
