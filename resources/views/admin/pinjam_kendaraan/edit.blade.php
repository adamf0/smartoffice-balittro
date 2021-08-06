<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            	<form action="/admin/pinjam_kendaraan/update/{{$data->id}}" method="post">
                    {{ csrf_field() }}
                    <div class="col-12">
            		    <label>Nomor Laporan</label>
                        <input type="text" value="{{ $data->nomor_laporan }}" class="form-control" disabled="true">
                    </div>
                    <div class="col-12">
                        <label>Peminjam</label>
                        <input type="text" value="{{ $data->peminjam }}" class="form-control" disabled="true">
                    </div>
                    <div class="col-12">
                        <label>Tujuan</label>
                        <input type="text" value="{{ $data->tujuan }}" class="form-control" disabled="true">
                    </div>
                    <div class="controls">
                        @php 
                            $jml_data_pengemudi  = count($data_pengemudi);
                            $jml_pengemudi  = count($data->pengemudi);
                        @endphp
                        @for($x=0;$x<$jml_pengemudi;$x++)
                        <div class="row entry mt-2">
                            <div class="col-12">
                                  <div class="input-group">
                                    <div class="col-12">
                                        <label>Nama Pengemudi</label>    
                                    </div>
                                    <div class="col-12 input-group">
                                        <select name="pengemudi[]" data-placeholder="Pilih Pengemudi" class="form-control" required="true">
                                            <option value=""></option>
                                            @for($y=0;$y<$jml_data_pengemudi;$y++)
                                               <option value="{{ $data_pengemudi[$y]['id'] }}" @if($data_pengemudi[$y]['id']==$data->pengemudi[$x]['id']) selected="true" @endif>{{ $data_pengemudi[$y]['nama'] }}</option>
                                            @endfor
                                        </select>
                                        <span class="input-group-btn">
                                            @if($jml_pengemudi>0)
                                                @if($x<$jml_pengemudi-1)
                                                    <button class="btn btn-danger btn-remove" type="button">
                                                        <span class="fa fa-minus"></span>
                                                    </button>
                                                @else
                                                    <button class="btn btn-success btn-add" type="button">
                                                        <span class="fa fa-plus"></span>
                                                    </button>
                                               @endif
                                            @else
                                                <button class="btn btn-success btn-add" type="button">
                                                    <span class="fa fa-plus"></span>
                                                </button>
                                            @endif
                                       </span>
                                    </div>
                                  </div>
                            </div>
                        </div>
                        @endfor
                    </div>
            		<button type="submit" name="simpan" class="btn btn-primary btn-block mt-3">Ubah Data</button>
            	</form>
           	</div>
        </div>
    </div>
</div>