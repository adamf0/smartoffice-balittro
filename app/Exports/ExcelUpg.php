<?php

namespace App\Exports;

use App\data_user;
use App\laporan_upg;
use App\laporan_upg_detail;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExcelUpg implements FromView
{
	public function __construct(string $date)
    {
        $this->date = $date;
    }

    public function view(): View
    {
    	$data           = array();
        $data_laporan   = laporan_upg::Where('tanggal', 'like', '%'.$this->date.'%')->where('status',1)->get();

        for ($i=0; $i < $data_laporan->count(); $i++) { 
            $gratifikasi = array();
            $datas = laporan_upg_detail::where('id_laporan_upg',$data_laporan[$i]->id)->where('id_jenis_gratifikasi','!=',null)->get();
            for ($j=0; $j < $datas->count(); $j++) { 
                array_push($gratifikasi, ($datas[$j]->id_jenis_gratifikasi==null?"N/a":$datas[$j]->jenis_gratifikasi->nama));
            }

            $pengguna = data_user::where('id_user',$data_laporan[$i]->id_user)->first();
            $arr = [
                "pengguna"                  => ($pengguna==null?"N/a":"$pengguna->nama - $pengguna->nip"),
                "lokasi"                    => $data_laporan[$i]->lokasi,
                "tanggal_mulai"             => Carbon::parse($data_laporan[$i]->tanggal)->formatLocalized("%A, %d %B %Y"),
                "tanggal_berakhir"          => Carbon::parse($data_laporan[$i]->tanggal)->addDays($data_laporan[$i]->lama-1)->formatLocalized("%A, %d %B %Y"),
                "honor"                     => $data_laporan[$i]->honor,
                "pemberi"                   => $data_laporan[$i]->pemberi,
                "gratifikasi"               => implode(";", $gratifikasi),
                "hubungan_gratifikasi"      => $data_laporan[$i]->hubungan_gratifikasi,
            ];
           	array_push($data, $arr);
        }

        return view('excel.laporan_upg', [
            'datas' => $data,
            'bln' => Carbon::parse($this->date)->formatLocalized("%B %Y")
        ]);
    }
}
