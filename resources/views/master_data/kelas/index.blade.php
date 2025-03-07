@extends('template.home')
@section('heading', 'Data Kelas')
@section('page')
    <li class="breadcrumb-item active">Data Kelas</li>
@endsection
@section('content')
    <?php
    $user = Auth::user();
    $role = $user->role;
    $id_guru = $user->id_guru;
    ?>
    <div class="col-md-12">
        <div class="card">
            @if ($role === 'admin')
                <div class="card-header">
                    <h3 class="card-title">
                        <button type="button" class="btn btn-default btn-sm" data-toggle="modal"
                            data-target=".bd-example-modal-lg">
                            <i class="nav-icon fas fa-folder-plus"></i> &nbsp; Tambah Data Kelas </button>
                    </h3>
                </div> <!-- /.card-header -->
            @endif

            <div class="card-body">
                <div class="row">
                    <div class="col-md">
                        <div class="form-group">
                            <label for="filter_tahun_ajaran">Filter Tahun Ajaran</label>
                            <select id="filter_tahun_ajaran" name="filter_tahun_ajaran" class="select2bs4 form-control">
                                <option value="all">Semua Tahun Ajaran</option>
                                @foreach ($tahun_ajaran as $v)
                                    <?php $active = $id_tahun_ajaran_aktif == $v->id ? ' (aktif)' : ''; ?> <?php $sel = $v->id == $ftahun_ajaran ? ' selected' : ''; ?> <option value="{{ $v->id }}"
                                        {!! $sel !!}>{{ $v->tahun . $active }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <table id="example1" class="table table-bordered table-hover dt-responsive nowrap" width="100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kelas</th>
                            <th>Tahun Ajaran</th>
                            <th>Wali Kelas</th>
                            <th>Jumlah Siswa</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kelas as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->tingkatan . $data->nama }}</td>
                                <td>{{ $data->tahun_ajaran()->tahun }}</td>
                                <td>{{ $data->wali_kelas()->nama }}</td>
                                <td>{{ $data->jumlah_siswa() }}</td>
                                <td> <?php $enc_id = Crypt::encrypt($data->id); ?> <form class="d-flex flex-col"
                                        action="{{ route('kelas.destroy', $enc_id) }}" method="post"> @csrf
                                        @method('delete') <a href="{{ route('kelas.kelola', $enc_id) }}"
                                            class="btn btn-info btn-sm pt-2 mx-2">
                                            <i class="nav-icon fas fa-id-card"></i> &nbsp; Kelola </a>
                                        @if ($role === 'admin')
                                            <a href="{{ route('kelas.edit', $enc_id) }}"
                                                class="btn btn-success btn-sm pt-2 mx-2">
                                                <i class="nav-icon fas fa-edit"></i> &nbsp; Edit </a>
                                            @endif @if ($role === 'admin')
                                                <button class="btn btn-danger btn-sm pt-2 mx-2">
                                                    <i class="nav-icon fas fa-trash-alt"></i> &nbsp; Hapus </button>
                                            @endif
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- /.card-body -->
        </div>
    </div>


    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('kelas.store') }}" method="post" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Data Kelas</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"> @csrf <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="tingkatan">Kelas</label>
                                    <select id="tingkatan" name="tingkatan"
                                        class="select2bs4 form-control @error('tingkatan') is-invalid @enderror">
                                        <option value="">-- Pilih Kelas --</option>
                                        @for ($i = 1; $i <= 6; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama Kelas (Misal: A, B, C, D, E)</label>
                                    <input type="text" id="nama" name="nama"
                                        class="form-control @error('nama') is-invalid @enderror">
                                </div>
                                <div class="form-group">
                                    <label for="tahun_ajaran">Tahun Ajaran</label>
                                    <select id="tahun_ajaran" name="tahun_ajaran"
                                        class="select2bs4 form-control @error('tahun_ajaran') is-invalid @enderror">
                                        <option value="">-- Pilih Tahun Ajaran --</option>
                                        @foreach ($tahun_ajaran as $v)
                                            <option value="{{ $v->id }}">{{ $v->tahun }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="wali_kelas">Wali Kelas</label>
                                    <select id="wali_kelas" name="wali_kelas"
                                        class="select2bs4 form-control @error('wali_kelas') is-invalid @enderror">
                                        <option value="">-- Pilih Wali Kelas --</option>
                                        @foreach ($guru as $v)
                                            <option value="{{ $v->id }}">({{ $v->nik }}) {{ $v->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                <i class='nav-icon fas fa-arrow-left'></i> &nbsp; Kembali
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="nav-icon fas fa-save"></i> &nbsp; Tambahkan
                            </button>
                        </div>
                    </div>
            </form>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $("#MasterData").addClass("active");
        $("#liMasterData").addClass("menu-open");
        $("#DataKelas").addClass("active");

        let ftahun_ajaran = $("#filter_tahun_ajaran");

        function construct_query_string() {
            return "?ftahun_ajaran=" + encodeURIComponent(ftahun_ajaran.val());
        }

        function handle_filter_change() {
            window.location = construct_query_string();
        }

        ftahun_ajaran.change(handle_filter_change);
    </script>
@endsection
