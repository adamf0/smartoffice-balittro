<style type="text/css">
  .table td{
    border-top: 0px;
    padding: 0.5em
  }  
  ol{
    margin: 0px
  }  
</style>
        <center>
            <b>
              SURAT PERJALANAN DINAS (SPD)
            </b>
        </center>
        <br>
        <table class="table table-bordered" style="font-size:10px">
            <tr>
                <td width="5%">1</td>
                <td width="40%">Penjabat Pembuat Komitmen</td>
                <td width="55%" colspan="2">Badan Penelitian Tanaman Rempah dan Obat Bogor</td>
            </tr>
            <tr>
                <td width="5%">2</td>
                <td width="40%">Nama/NIP pegawai yang melakukan perjalanan dinas</td>
                <td width="55%" colspan="2">{{ $data['nama']."/".$data['nip'] }}</td>
            </tr>
            <tr>
                <td width="5%">3</td>
                <td width="40%">
                  <ol>
                    <li>Pangkat dan golongan PGPNS</li>
                    <li>Jabatan/Instansi</li>
                    <li>Tingkat Biaya Perjalanan Dinas</li>
                  </ol>
                </td>
                <td width="55%" colspan="2">
                  <ol>
                    <li>{{ $data['pangkat'] }} - {{ $data['golongan'] }}</li>
                    <li>{{ $data['jabatan'] }}</li>
                    <li>{{ $data['biaya_perjalanan_dinas'] }}</li>
                  </ol>
                </td>
            </tr>
            <tr>
                <td width="5%">4</td>
                <td width="40%">Maksud perjalanan dinas</td>
                <td width="55%" colspan="2">{{ $data['maksud_perjalanan'] }}</td>
            </tr>
            <tr>
                <td width="5%">5</td>
                <td width="40%">Alat angkutan yang digunakan</td>
                <td width="55%" colspan="2">{{ $data['kendaraan'] }}</td>
            </tr>
            <tr>
                <td width="5%">6</td>
                <td width="40%">
                  <ol>
                    <li>Tempat berangkat</li>
                    <li>Tempat tujuan</li>
                  </ol>
                </td>
                <td width="55%" colspan="2">
                  <ol>
                    <li>{{ $data['tempat_berangkat'] }}</li>
                    <li>{{ $data['tempat_tujuan'] }}</li>
                  </ol>
                </td>
            </tr>
            <tr>
                <td width="5%">7</td>
                <td width="40%">
                  <ol>
                    <li>Lama perjalanan dinas</li>
                    <li>Tanggal berangkat</li>
                    <li>
                        @if($data['keterangan']!=0)
                            Tanggal harus kembali
                        @else
                            <strike>Tanggal harus kembali</strike>
                        @endif
                        /
                        @if($data['keterangan']!=1)
                            tiba di tempat baru
                        @else
                            <strike>tiba di tempat baru</strike>
                        @endif
                    </li>
                  </ol>
                </td>
                <td width="55%" colspan="2">
                  <ol>
                    <li>{{ $data['lama_perjalanan'] }} Hari</li>
                    <li>{{ $data['tanggal_berangkat'] }}</li>
                    <li>{{ $data['tanggal_akhir'] }}</li>
                  </ol>
                </td>
            </tr>
            <tr>
                <td width="5%">8</td>
                <td width="40%">Pengikut: Nama</td>
                <td>Tanggal Lahir</td>
                <td>Keterangan</td>
            </tr>
            @php $jml_pengikut = count($data['pengikut']) @endphp
            <tr>
                <td></td>
                <td>
                  <ol>
                    @for($i=0;$i<$jml_pengikut;$i++)
                    <li>{{ $data['pengikut'][$i]['nama'] }}</li>
                    @endfor
                  </ol>
                </td>
                <td width="25%">
                  <ol>
                    @for($j=0;$j<$jml_pengikut;$j++)
                    <li>@if($data['pengikut'][$j]['tanggal_lahir']=='0000-00-00') - - - @else {{ $data['pengikut'][$j]['tanggal_lahir'] }} @endif</li>
                    @endfor
                  </ol>
                </td>
                <td width="25%"></td>
            </tr>
            <tr>
                <td width="5%">9</td>
                <td width="40%">
                  Pembebanan Anggaran:<br>
                  <ol>
                    <li>Instansi</li>
                    <li>Akun</li>
                  </ol>
                </td>
                <td width="55%" colspan="2">
                  <ol>
                    <li>Balai Besar Penelitian Tanaman Rempah dan Obat</li>
                    <li></li>
                  </ol>
                </td>
            </tr>
            <tr>
                <td width="5%">10</td>
                <td width="40%">Keterangan lain-lain</td>
                <td width="55%" colspan="2">{{ $data['keterangan_lain'] }}</td>
            </tr>
        </table>
        <table class="float-right" style="font-size:10px">
            <tr>
                <td>Diselenggarakan di</td>
                <td>: Bogor</td>
            </tr>
            <tr>
                <td>Pada tanggal</td>
                <td>: {{ $data['create'] }}</td>
            </tr>
            <tr>
                <td colspan="2" class="text-center"><br>Penjabat Pembuat Komitmen</td>
            </tr>
            <tr>
                <td colspan="2" class="text-center">
                    <br>
                    <img src="{{ public_path('storage/'.$data['tanda_tangan']['admin']['tanda_tangan']) }}" width="100px" height="50px">
                    <br>
                    {{ $data['tanda_tangan']['admin']['nama'] }}<br>
                    NIP. {{ $data['tanda_tangan']['admin']['nip'] }}
                </td>
            </tr>
        </table>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <table border="1" style="font-size:10px">
            @for($i=0;$i<=5;$i++)
                @if($i==0)
                <tr>
                    <td width="350px">
                        
                    </td>
                    <td width="350px">
                        <table>
                            <tr>
                                <td>{{ $i+1 }} Berangkat dari (tempat kedudukan)</td>
                                <td>: ................................................................</td>
                            </tr>
                            <tr>
                                <td>Ke</td>
                                <td>: ................................................................</td>
                            </tr>
                            <tr>
                                <td>Pada Tanggal</td>
                                <td>: ................................................................</td>
                            </tr>
                            <tr>
                                <td colspan=2>
                                    Kepala
                                </td>
                            </tr>
                            <tr>
                                <td colspan=2>
                                    <br>
                                    <img src="{{ public_path('storage/'.$data['tanda_tangan']['admin_sppd']['tanda_tangan']) }}" width="100px" height="50px">
                                    <br>
                                    {{ $data['tanda_tangan']['admin_sppd']['nama'] }}<br>
                                    NIP. {{ $data['tanda_tangan']['admin_sppd']['nip'] }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                @else
                <tr>
                    <td width="350px">
                        <table>
                        <tr>
                            <td>{{ $i+1 }} Tiba di</td>
                            <td>: ................................................................</td>
                        </tr>
                        <tr>
                            <td>Pada Tanggal</td>
                            <td>: ................................................................</td>
                        </tr>
                        <tr>
                            <td colspan=2>
                                Kepala
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                            </td>
                        </tr>
                        <tr>
                            <td colspan=2>
                                (...................................)
                            </td>
                        </tr>
                    </table>
                    </td>
                    <td width="350px">
                    <table>
                        <tr>
                            <td>Berangkat dari (tempat kedudukan)</td>
                            <td>: ................................................................</td>
                        </tr>
                        <tr>
                            <td>Ke</td>
                            <td>: ................................................................</td>
                        </tr>
                        <tr>
                            <td>Pada Tanggal</td>
                            <td>: ................................................................</td>
                        </tr>
                        <tr>
                            <td colspan=2>
                                Kepala
                                <br>
                                <br>
                                <br>
                            </td>
                        </tr>
                        <tr>
                            <td colspan=2>
                                (...................................)
                            </td>
                        </tr>
                    </table>
                </td>
                </tr>
                @endif
            @endfor
            @php $i++ @endphp
            <tr>
                <td width="350px">
                        <table>
                        <tr>
                            <td>{{ $i }} Tiba di (Tempat Kedudukan)</td>
                            <td>: ................................................................</td>
                        </tr>
                        <tr>
                            <td>Pada Tanggal</td>
                            <td>: ................................................................</td>
                        </tr>
                        <tr>
                            <td colspan=2>
                                Penjabat Pebuat Komitmen
                            </td>
                        </tr>
                        <tr>
                            <td colspan=2>
                                <br>
                                <img src="{{ public_path('storage/'.$data['tanda_tangan']['admin']['tanda_tangan']) }}" width="100px" height="50px">
                                <br>
                                {{ $data['tanda_tangan']['admin']['nama'] }}<br>
                                NIP. {{ $data['tanda_tangan']['admin']['nip'] }}
                            </td>
                        </tr>
                    </table>
                    </td>
                <td width="350px">
                    <table>
                        <tr>
                            <td>
                                Telah diperiksa dengan keterangan bahwa perjalanan tersebut ata perintahnya dan semata-mata untuk kepentingan jabatan dalam waktu yang sesingkat-singkatnya.<br>
                                <br>
                                Penjabat Pembuat Komitmen
                            </td>
                        </tr>
                        <tr>
                            <td colspan=2>
                                <br>
                                <img src="{{ public_path('storage/'.$data['tanda_tangan']['admin']['tanda_tangan']) }}" width="100px" height="50px">
                                <br>
                                {{ $data['tanda_tangan']['admin']['nama'] }}<br>
                                NIP. {{ $data['tanda_tangan']['admin']['nip'] }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>{{ $i+1 }} Catatan Lain-lain:</td>
                <td></td>
            </tr>
            <tr>
                <td colspan=2>
                    {{ $i+2 }} Perhatian: <br>
                    <span style="font-size:8px">PPK yang menerbitkan SPD, pegawai yang melakukan perjalanan dinas, para penjabat yang mengesahkan tanggal berangkat/tiba serta bendahara pengeluaran bertanggung jawab berdasarkan peraturan-peraturan keuangan negara apanila negara menderita rugi akibat kesalahan, kelalaian dan kealpaan.</span>
                </td>
            </tr>
        <table>