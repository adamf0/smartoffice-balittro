<style type="text/css">
  .table td{
    border-top: 0px;
    padding: 0.5em
  }  
  ol{
    margin: 0px
  }
</style>     
      <p class="text-center">
          <b>
              BADAN PENELITIAN DAN PENGEMBANGAN PERTANIAN<br>
              PUSAT PENELITIAN DAN PENGEMBANGAN PERKEBBUNAN<br>
              BALAI PENELITIAN TANAMAN REMPAH DAN OBAT<br>
          </b>
      </p>
      <table class="float-right" style="font-size:10px;margin-right: 20%">
          <tr>
              <td>Tahun Anggaran</td>
              <td>: </td>
          </tr>
              <td>No. Kas</td>
              <td>: </td>
          </tr>
      </table>
      <br>
      <br>
      <table class="table" style="font-size:10px">
          <tr>
              <td>Telah Terima dari</td>
              <td>: Penjabat Pembuat Komitmen Balai Penelitian Tanaman Rempah dan Obat</td>
          </tr>
          <tr>
              <td>Banyaknya uang</td>
              <td>: {{ $data['banyak_uang'] }}</td>
          </tr>
          <tr>
              <td>Untuk pembayaran</td>
              <td>: Biaya Perjalanan Dinas menurut perincian dibawah ini</td>
          </tr>
          <tr>
              <td>Berdasarkan SPPD</td>
              <td>: LUMPSUM</td>
          </tr>
          <tr>
              <td>Nomor</td>
              <td>: {{ $data['nomor_perjalanan_dinas'] }}</td>
          </tr>
          <tr>
              <td>Tanggal</td>
              <td>: {{ $data['tanggal'] }}</td>
          </tr>
          <tr>
              <td>Untuk perjalanan dinas dari</td>
              <td>: Bogor ke {{ $data['tujuan'] }}</td>
          </tr>
          <tr>
              <td>Dibiayai dari Kegiatan</td>
              <td>: {{ $data['kegiatan'] }}</td>
          </tr>
      </table>
      <br>
      <table class="table" style="font-size:10px">
          <tr>
              <td class="text-center">Setuju dibayar <br>Penjabat Pembuat Komitmen Balai <br>Penelitian Tanaman Rempah dan Obat</td>
              <td class="text-center">Lunas dibayar <br>Bendahara Pengeluaran</td>
              <td class="text-center">Yang menerima</td>
          </tr>
          <tr>
              <td class="text-center">
                <img src="{{ public_path('storage/'.$data['tanda_tangan']['admin']['tanda_tangan']) }}" width="100px" height="50px"><br>
                {{ $data['tanda_tangan']['admin']['nama'] }}<br>
                {{ $data['tanda_tangan']['admin']['nip'] }}
              </td>
              <td class="text-center">
                <img src="{{ public_path('storage/'.$data['tanda_tangan']['bendahara']['tanda_tangan']) }}" width="100px" height="50px"><br>
                {{ $data['tanda_tangan']['bendahara']['nama'] }}<br>
                NIP {{ $data['tanda_tangan']['bendahara']['nip'] }}
              </td>
              <td class="text-center">
                <img src="{{ public_path('storage/'.$data['tanda_tangan']['penerima']['tanda_tangan']) }}" width="100px" height="50px"><br>
                {{ $data['tanda_tangan']['penerima']['nama'] }}<br>
                NIP {{ $data['tanda_tangan']['penerima']['nip'] }}
              </td>
          </tr>
      </table>
      <br>
      <table class="table table-bordered" style="font-size:10px">
          <tr>
              <td width="5%">No</td>
              <td width="40%">Perincian Biaya</td>
              <td width="30%">Jumlah</td>
              <td width="40%">Keterangan</td>
          </tr>
          <tr>
              <td width="5%">1</td>
              <td width="40%">Transport</td>
              <td width="30%">{{ $data['transport'] }}</td>
              <td width="40%"></td>
          </tr>
          <tr>
              <td width="5%"></td>
              <td width="40%">
                Tiket Bus
                <ol>
                    <li>Penginapan dan Makanan</li>
                    <li>Angkutan Setempat / Biaya rill</li>
                    <li>Uang Saku</li>
                </ol>
              </td>
              <td width="30%">
                <br>
                <ol>
                    <li>{{ $data['penginapan_makan'] }}</li>
                    <li>{{ $data['biaya_rill'] }}</li>
                    <li>{{ $data['uang_saku'] }}</li>
                </ol>
              </td>
              <td width="40%"></td>
          </tr>
          <tr>
              <td width="5%"></td>
              <td width="40%">
                  Jumlah :<br>
                  Dengan Huruf :
              </td>
              <td width="30%">
                {{ $data['total'] }}<br>
                {{ $data['total_terbilang'] }}
              </td>
              <td width="40%"></td>
          </tr>
      </table>