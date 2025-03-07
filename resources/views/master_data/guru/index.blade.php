@extends('template.home')
@section('heading', 'Data Guru')
@section('page')
    <li class="breadcrumb-item active">Data Guru</li>
@endsection
@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <button type="button" class="btn btn-default btn-sm" data-toggle="modal"
                        data-target=".bd-example-modal-lg">
                        <i class="nav-icon fas fa-folder-plus"></i> &nbsp; Tambah Data Guru
                    </button>
                </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body" style="overflow-x: scroll">
                <div class="row">
                    <div class="col-md">
                        <div class="form-group">
                            <label for="filter_status">Status</label>
                            <select id="filter_status" name="filter_status" class="select2bs4 form-control">
                                <option value="all">Semua Status</option>
                                <option value="aktif"<?= $fstatus === 'aktif' ? ' selected' : '' ?>>Aktif</option>
                                <option value="non-aktif"<?= $fstatus === 'non-aktif' ? ' selected' : '' ?>>Non Aktif
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <table id="example1" class="table table-bordered table-hover dt-responsive nowrap" width="100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Jenis Kelamin</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($guru as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->nama }}</td>
                                <td>{{ $data->email }}</td>
                                <td>{{ $data->jk === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                <td>{{ $data->status === 'aktif' ? 'Aktif' : 'Non-aktif' }}</td>
                                <td>
                                    <?php $enc_id = Crypt::encrypt($data->id); ?>
                                    <form class="d-flex flex-col"
                                        action="{{ route('guru.destroy', $enc_id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <a href="{{ route('guru.show', $enc_id) }}" class="btn btn-info btn-sm pt-2 mx-2"><i
                                                class="nav-icon fas fa-id-card"></i> &nbsp; Detail</a>
                                        <a href="{{ route('guru.edit', $enc_id) }}"
                                            class="btn btn-success btn-sm pt-2 mx-2"><i class="nav-icon fas fa-edit"></i>
                                            &nbsp; Edit</a>
                                        <button class="btn btn-danger btn-sm pt-2"><i class="nav-icon fas fa-trash-alt"></i>
                                            &nbsp; Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>

    <!-- Extra large modal -->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Data Guru</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('guru.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nik">NIK</label>
                                    <input type="text" id="nik" name="nik"
                                        onkeypress="return inputAngka(event)"
                                        class="form-control @error('nik') is-invalid @enderror">
                                </div>
                                <div class="form-group">
                                    <label for="nsm">NSM</label>
                                    <input type="text" id="nsm" name="nsm"
                                        onkeypress="return inputAngka(event)"
                                        class="form-control @error('nsm') is-invalid @enderror">
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama Guru</label>
                                    <input type="text" id="nama" name="nama"
                                        class="form-control @error('nama') is-invalid @enderror">
                                </div>
                                <div class="form-group">
                                    <label for="tmp_lahir">Tempat Lahir</label>
                                    <input type="text" id="tmp_lahir" name="tmp_lahir"
                                        class="form-control @error('tmp_lahir') is-invalid @enderror">
                                </div>
                                <div class="form-group">
                                    <label for="tgl_lahir">Tanggal Lahir</label>
                                    <input type="date" id="tgl_lahir" name="tgl_lahir"
                                        class="form-control @error('tgl_lahir') is-invalid @enderror">
                                </div>
                                <div class="form-group">
                                    <label for="jk">Jenis Kelamin</label>
                                    <select id="jk" name="jk"
                                        class="select2bs4 form-control @error('jk') is-invalid @enderror">
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="L">Laki-Laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="agama">Agama</label>
                                    <select id="agama" name="agama"
                                        class="select2bs4 form-control @error('agama') is-invalid @enderror">
                                        <option value="">-- Pilih Agama --</option>
                                        <?= FormWithRef::get_agama() ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="goldar">Golongan Darah</label>
                                    <select id="goldar" name="goldar"
                                        class="select2bs4 form-control @error('goldar') is-invalid @enderror">
                                        <option value="">-- Pilih Golongan Darah --</option>
                                        <?= FormWithRef::get_goldar() ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="telp">Nomor Telpon/HP</label>
                                    <input type="text" id="telp" name="telp"
                                        onkeypress="return inputAngka(event)"
                                        class="form-control @error('telp') is-invalid @enderror">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" id="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror">
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <input type="text" id="alamat" name="alamat"
                                        class="form-control @error('alamat') is-invalid @enderror">
                                </div>
                                <div class="form-group">
                                    <label for="pendidikan">Pendidikan</label>
                                    <select id="pendidikan" name="pendidikan"
                                        class="select2bs4 form-control @error('pendidikan') is-invalid @enderror">
                                        <option value="">-- Pilih Pendidikan Terakhir --</option>
                                        <?= FormWithRef::get_pendidikan() ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="pekerjaan">Pekerjaan</label>
                                    <select id="pekerjaan" name="pekerjaan"
                                        class="select2bs4 form-control @error('pekerjaan') is-invalid @enderror">
                                        <option value="">-- Pilih Pekerjaan --</option>
                                        <?= FormWithRef::get_pekerjaan() ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select id="status" name="status"
                                        class="select2bs4 form-control @error('status') is-invalid @enderror">
                                        <option value="aktif">Aktif</option>
                                        <option value="non-aktif">Non-aktif</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="foto">File Foto</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="foto"
                                                class="custom-file-input @error('foto') is-invalid @enderror"
                                                id="foto">
                                            <label class="custom-file-label" for="foto">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i
                            class='nav-icon fas fa-arrow-left'></i> &nbsp; Kembali</button>
                    <button type="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp;
                        Tambahkan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $("#MasterData").addClass("active");
        $("#liMasterData").addClass("menu-open");
        $("#DataGuru").addClass("active");

        let fstatus = $("#filter_status");

        function construct_query_string() {
            return "?fstatus=" + encodeURIComponent(fstatus.val());
        }

        function handle_filter_change() {
            window.location = construct_query_string();
        }

        fstatus.change(handle_filter_change);
    </script>
@endsection
