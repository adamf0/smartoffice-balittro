<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="/super_admin/biaya_anggaran/update" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $datas['id_tujuan'] }}">
                    <div class="col-12">
                        <label>Nama Tujuan</label>
                    </div>
                    <div class="col-12">
                        <select name="tujuan" data-placeholder="Pilih Tujuan" class="form-control chosen-select" required>
                            <option value=""></option>
                            @foreach($tujuan as $tujuan)
                                <option value="{{ $tujuan->id }}" @if($tujuan->id == $datas['id_tujuan']) {{ "selected='true'" }} @endif>{{ $tujuan->tujuan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="controls">
                        @php 
                            $jml_jenis_anggaran = count($jenis_anggaran); 
                            $jml_data_anggaran  = count($datas['data_anggaran']);
                        @endphp
                        @for($x=0;$x<$jml_data_anggaran;$x++)
                        <div class="row entry mt-2">
                            <div class="col-6">
                                  <div class="input-group">
                                    <div class="col-12">
                                        <label>Nama Anggaran</label>    
                                    </div>
                                    <div class="col-12">
                                        <select name="anggaran[]" data-placeholder="Pilih Jenis Anggaran" class="form-control" required>
                                            <option value="-1"></option>
                                            @for($y=0;$y<$jml_jenis_anggaran;$y++)
                                               <option value="{{ $jenis_anggaran[$y]->id }}" @if($datas['data_anggaran'][$x]['id_jenis_anggaran']==$jenis_anggaran[$y]->id) {{ "selected='true'" }}  @endif>{{ $jenis_anggaran[$y]->nama }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                  </div>
                            </div>
                            <div class="col-6">
                                <div class="col-12">
                                    <label>Biaya Anggaran</label>
                                </div>
                                <div class="col-12 input-group">
                                    <input class="form-control" name="biaya[]" type="text" placeholder="Masukkan biaya anggaran..." value="{{ $datas['data_anggaran'][$x]['biaya'] }}" required/>
                                    <span class="input-group-btn">
                                        @if($jml_data_anggaran>0)
                                            @if($x<$jml_data_anggaran-1)
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
                        @endfor
                    </div>
                    <button type="submit" name="simpan" class="btn btn-primary btn-block mt-3">Ubah Data</button>
                </form>
            </div>
        </div>
    </div>
</div>