@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 id="nomorPengadaan">{{ $pengadaan->nodin ?? '{Nodin}' }}</h3>
                <p id="namaPengadaan" class="text-subtitle text-muted">{{ $pengadaan->nama ?? '{Nama Project}' }}</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pengadaan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Basket 1 -->
    <section class="section">
        <div class="card mb-4">
            <div class="card-content">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">Informasi Project</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form id="pengadaanForm" class="col-12 col-md-6 col-lg-5 col-xl-4">
                            <input type="hidden" name="pengadaan_id" value="{{ $pengadaan->id }}">
                            <div class="mb-3">
                                <p class="badge bg-success mb-0">Terakhir diupdate: <span id="lastUpdated">{{ $pengadaan->updated_at }}</span></p>
                            </div>
                            <div class="form-group mb-3">
                                <label for="first-name-vertical">Nama Project</label>
                                <input @cannot('edit pengadaan') disabled @endcannot type="text" id="first-name-vertical" class="form-control pengadaan-field" name="nama" value="{{ $pengadaan->nama }}" placeholder="Masukkan nama project">
                            </div>
                            <div class="form-group mb-3">
                                <label for="first-name-vertical">Nodin</label>
                                <input @cannot('edit pengadaan') disabled @endcannot type="text" id="first-name-vertical" class="form-control pengadaan-field" name="nodin" value="{{ $pengadaan->nodin }}" placeholder="Masukkan nodin">
                            </div>
                            <div class="form-group mb-3">
                                <label for="first-name-vertical">Tanggal Nodin</label>
                                <input @cannot('edit pengadaan') disabled @endcannot type="date" id="first-name-vertical" class="form-control pengadaan-field" name="tgl_nodin" value="{{ $pengadaan->tgl_nodin }}" placeholder="Masukkan tanggal nodin">
                            </div>
                            <div class="form-group mb-3">
                                <label for="first-name-vertical">Nomor PR</label>
                                <input @cannot('edit pengadaan') disabled @endcannot type="text" id="first-name-vertical" class="form-control pengadaan-field" name="pr" value="{{ $pengadaan->pr }}" placeholder="Masukkan nomor pr">
                            </div>
                            <div class="form-group mb-3">
                                <label for="first-name-vertical">Status</label>
                                <select @cannot('edit pengadaan') disabled @endcannot class="form-select pengadaan-field" name="status" aria-label="Default select example">
                                    <option>Pilih status</option>
                                    <option value="PROSES" @if($pengadaan->status == 'PROSES') selected @endif>PROSES</option>
                                    <option value="TERKONTRAK" @if($pengadaan->status == 'TERKONTRAK') selected @endif>TERKONTRAK</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Jasa --}}
        <div class="card mb-4">
            <div class="card-content">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">RAB Jasa</h4>
                </div>
                <div class="card-body">
                    @can('edit pengadaan')
                    <div class="mb-4">
                        <div class="form-group mb-3">
                            <label for="first-name-vertical">WBS Jasa</label>
                            <div id="wbsJasaContainer" class="mb-1">
                                @foreach ($pengadaan->wbs_jasas as $i => $wbs_jasa)
                                <div id="wbs-jasa-{{ $wbs_jasa->id }}" class="d-flex mb-2">
                                    <input list="skkiList" type="text" id="first-name-vertical" class="form-control skki-field me-2" disabled value="{{ $wbs_jasa->wbs_jasa }}" placeholder="Masukkan nomor WBS Jasa">
                                    <button class="btn btn-primary me-2 import-jasa" data-skki-id="{{ $wbs_jasa->skki_id }}">Import&nbsp;Jasa</button>
                                    <button class="btn btn-primary me-2 show-jasa" data-skki-id="{{ $wbs_jasa->skki_id }}">Lihat&nbsp;Jasa</button>
                                    <button class="btn btn-danger delete-wbs-jasa" data-id={{ $wbs_jasa->id }}>Hapus</button>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="first-name-vertical">WBS Jasa Baru</label>
                            <input list="skkiList" type="text" id="first-name-vertical" class="form-control skki-field" name="wbs_jasa" value="" placeholder="Masukkan nomor WBS Jasa">
                        </div>
                        <datalist id="skkiList">
                            @foreach ($skkis as $skki)
                            @if($skki->wbs_jasa)
                            <option value="{{ $skki->id }}">{{ $skki->wbs_jasa }}</option>
                            @endif
                            @endforeach
                        </datalist>
                    </div>
                    @endcan

                    @can('edit pengadaan')
                    <div class="mb-4">
                        <button id="createJasaBtn" class="btn btn-primary">Jasa Baru</button>
                    </div>
                    @endcan
                    <div class="table-responsive">
                        <table id="jasaTbl" class="table table-stripped">
                            <thead>
                                <tr>
                                    <th>Nama Jasa</th>
                                    <th>Nilai</th>
                                    @can('edit pengadaan')<th>&nbsp;</th>@endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengadaan->jasas as $jasa)
                                <tr id="jasa-{{ $jasa->id }}">
                                    <td>{{ $jasa->nama }}</td>
                                    <td>Rp{{ number_format($jasa->harga, 0, ',', '.') }}</td>
                                    @can('edit pengadaan')
                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-warning me-2 editJasaBtn" data-id="{{ $jasa->id }}" data-nama="{{ $jasa->nama }}" data-harga="{{ $jasa->harga }}">Edit</button>
                                            <button class="btn btn-danger deleteJasaBtn" data-id="{{ $jasa->id }}">Hapus</button>
                                        </div>
                                    </td>
                                    @endcan
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Material --}}
        <div class="card mb-4">
            <div class="card-content">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">RAB Material</h4>
                </div>
                <div class="card-body">
                    @can('edit pengadaan')
                    <div class="mb-4">
                        <div class="form-group mb-3">
                            <label for="first-name-vertical">WBS Material</label>
                            <div id="wbsMaterialContainer" class="mb-1">
                                @if(count($pengadaan->wbs_materials) > 0)
                                @foreach ($pengadaan->wbs_materials as $i => $wbs_material)
                                <div id="wbs-material-{{ $wbs_material->id }}" class="d-flex mb-2">
                                    <input list="skkiList" type="text" id="first-name-vertical" class="form-control skki-field me-2" disabled value="{{ $wbs_material->wbs_material }}" placeholder="Masukkan nomor WBS Material">
                                    <button class="btn btn-primary me-2 import-material" data-skki-id="{{ $wbs_material->skki_id }}">Import&nbsp;Material</button>
                                    <button class="btn btn-primary me-2 show-material" data-skki-id="{{ $wbs_material->skki_id }}">Lihat&nbsp;Material</button>
                                    <button class="btn btn-danger delete-wbs-material" data-id="{{ $wbs_material->id }}">Hapus</button>
                                </div>
                                @endforeach
                                @else
                                <em>Belum ada wbs material</em>
                                @endif
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="first-name-vertical">WBS Material Baru</label>
                            <input list="skkiMaterialList" type="text" id="first-name-vertical" class="form-control skki-field" name="wbs_material" value="" placeholder="Masukkan nomor WBS Material">
                        </div>
                        <datalist id="skkiMaterialList">
                            @foreach ($skkis as $skki)
                            @if($skki->wbs_material)
                            <option value="{{ $skki->id }}">{{ $skki->wbs_material }}</option>
                            @endif
                            @endforeach
                        </datalist>
                    </div>
                    <div class="mb-4">
                        <button id="createMaterialBtn" class="btn btn-primary">Baru</button>
                    </div>
                    @endcan
                    <div class="table-responsive">
                        <table id="materialTbl" class="table table-stripped">
                            <thead>
                                <tr>
                                    <th>Kode Normalisasi</th>
                                    <th>Nama Material</th>
                                    <th>Satuan</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                    @can('edit pengadaan')<th>:</th>@endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengadaan->materials as $material)
                                <tr id="material-{{ $material->id }}">
                                    <td>{{ $material->normalisasi }}</td>
                                    <td>{{ $material->nama }}</td>
                                    <td>{{ $material->satuan }}</td>
                                    <td>Rp{{ number_format($material->harga, 0, ',', '.') }}</td>
                                    <td>{{ $material->jumlah }}</td>
                                    <td>Rp{{ number_format($material->jumlah * $material->harga, 0, ',', '.') }}</td>
                                    @can('edit pengadaan')
                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-warning me-2 editMaterialBtn" data-id="{{ $material->id }}" data-normalisasi="{{ $material->normalisasi }}" data-nama="{{ $material->nama }}" data-satuan="{{ $material->satuan }}" data-harga="{{ $material->harga }}" data-jumlah="{{ $material->jumlah }}" data-stok="{{ $material->stok }}" data-base-material-id="{{ $material->base_material_id }}" data-deskripsi="{{ $material->deskripsi }}">Edit</button>
                                            <button class="btn btn-danger deleteMaterialBtn" data-id="{{ $material->id }}">Hapus</button>
                                        </div>
                                    </td>
                                    @endcan
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- File --}}
        <div class="card mb-4">
            <div class="card-content">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">Lampiran Berkas</h4>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <button id="createFileBtn" class="btn btn-primary">Upload</button>
                    </div>
                    <div class="table-responsive">
                        <table id="fileTbl" class="table table-stripped">
                            <thead>
                                <tr>
                                    <th>Nama Berkas</th>
                                    <th>:</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengadaan->files as $file)
                                <tr id="file-{{ $file->id }}">
                                    <td>
                                        <p class="mb-0">{{ $file->nama }}</p>
                                        <small>{{ $file->deskripsi }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <a href="/storage/{{ $file->url }}" target="_blank" class="btn btn-primary me-2">Unduh</a>
                                            <button class="btn btn-danger deleteFileBtn" data-id="{{ $file->id }}">Hapus</button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            @can('edit pengadaan')<button class="btn btn-danger me-2">Hapus Data</button>@endcan
            <button class="btn btn-primary">Selesai</button>
        </div>
    </section>

    @can('edit pengadaan'){{-- Jasa modal --}}
    <div class="modal fade" id="jasaModal" tabindex="-1" aria-labelledby="jasaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="modal-title" id="jasaModalLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="jasaForm" class="my-4">
                        <input type="hidden" name="jasa_id">
                        <div class="mb-3">
                            <label for="">Nama Jasa</label>
                            <input type="text" class="form-control" name="jasa_nama" placeholder="Masukkan nama jasa">
                        </div>
                        <div class="mb-3">
                            <label for="">Harga</label>
                            <input type="text" class="form-control" name="jasa_harga" placeholder="Masukkan nilai jasa">
                        </div>
                    </form>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</button>
                        <button id="updateJasaBtn" type="button" class="btn btn-primary">Perbarui</button>
                        <button id="saveJasaBtn" type="button" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>@endcan

    {{-- Jasa di SKKI modal --}}
    <div class="modal fade" id="jasaSkkiModal" tabindex="-1" aria-labelledby="jasaSkkiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="modal-title" id="jasaSkkiModalLabel">Jasa di SKKI</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="my-4">
                        <table id="jasaSkkiTbl" class="table table-stripped">
                            <thead>
                                <tr>
                                    <th>Nama Jasa</th>
                                    <th>Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @can('edit pengadaan'){{-- Material modal --}}
    <div class="modal fade" id="materialModal" tabindex="-1" aria-labelledby="materialModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="modal-title" id="materialModalLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="materialForm" class="my-4">
                        <input type="hidden" name="material_id">
                        <div class="mb-3">
                            <label for="">Kode Normalisasi</label>
                            <input type="text" list="materialList" class="form-control" name="base_material_id" placeholder="Masukkan kode normalisasi">
                            <small id="materialNormalisasiMessageContainer" style="display: none"><i class="bi bi-info-circle"></i> Data diatas hanya id di database. Kode normalisasi sebenarnya adalah <strong id="selectedMaterialNormalisasi"></strong></small>
                            <datalist id="materialList"></datalist>
                        </div>
                        <div class="mb-3">
                            <label for="">Nama Material</label>
                            <input type="text" class="form-control" disabled name="material_nama" placeholder="Masukkan nama material">
                        </div>
                        <div class="mb-3">
                            <label for="">Deskripsi</label>
                            <textarea name="material_deskripsi" disabled placeholder="Masukkan deskripsi material" class="form-control" id="" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="">Satuan</label>
                            <input type="text" class="form-control" disabled name="material_satuan" placeholder="Masukkan satuan">
                        </div>
                        <div class="mb-3">
                            <label for="">Harga</label>
                            <input type="text" class="form-control" disabled name="material_harga" placeholder="Masukkan harga material">
                        </div>
                        <div class="mb-3">
                            <label for="">Jumlah</label>
                            <input type="text" class="form-control" name="material_jumlah" placeholder="Masukkan jumlah">
                        </div>
                    </form>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</button>
                        <button id="saveMaterialBtn" type="button" class="btn btn-primary">Simpan</button>
                        <button id="updateMaterialBtn" type="button" class="btn btn-primary">Perbarui</button>
                    </div>
                </div>
            </div>
        </div>
    </div>@endcan

    {{-- Material di SKKI modal --}}
    <div class="modal fade" id="materialSkkiModal" tabindex="-1" aria-labelledby="materialSkkiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="modal-title" id="materialSkkiModalLabel">Material di SKKI</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="my-4 table-responsive">
                        <table id="materialSkkiTbl" class="table table-stripped">
                            <thead>
                                <tr>
                                    <th>Kode Normalisasi</th>
                                    <th>Nama Material</th>
                                    <th>Satuan</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- file modal --}}
    <div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="modal-title" id="fileModalLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="my-4">
                        <input type="hidden" name="file_id">
                        <div class="mb-3">
                            <label for="">File Lampiran</label>
                            <input type="file" class="form-control" name="file">
                        </div>
                        <div class="mb-3">
                            <label for="">Deskripsi</label>
                            <textarea name="file_deskripsi" placeholder="Masukkan deskripsi lampiran" class="form-control" id="" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</button>
                        <button id="saveFileBtn" type="button" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete modal --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="modal-title" id="deleteModalLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="my-4">
                        Data yang dihapus tidak dapat dikembalikan. Lanjutkan?
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</button>
                        <button id="deleteJasaBtn" type="button" class="btn btn-danger">Hapus</button>
                        <button id="deleteMaterialBtn" type="button" class="btn btn-danger">Hapus</button>
                        <button id="deleteFileBtn" type="button" class="btn btn-danger">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @can('edit pengadaan'){{-- Kontrak modal --}}
    <div class="modal fade" id="kontrakModal" tabindex="-1" aria-labelledby="kontrakModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="modal-title" id="kontrakModalLabel">Kontrak Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="kontrakForm" class="my-4">
                        <div class="mb-3">
                            <label for="">Nomor Kontrak</label>
                            <input type="text" class="form-control" name="kontrak_nomor_kontrak" placeholder="Masukkan nomor kontrak">
                        </div>
                        <div class="mb-3">
                            <label for="">Tanggal Kontrak</label>
                            <input type="date" class="form-control" name="kontrak_tgl_kontrak">
                        </div>
                        <div class="mb-3">
                            <label for="">Tanggal Awal</label>
                            <input type="date" class="form-control" name="kontrak_tgl_awal">
                        </div>
                        <div class="mb-3">
                            <label for="">Tanggal Akhir</label>
                            <input type="date" class="form-control" name="kontrak_tgl_akhir">
                        </div>
                        <div class="mb-3">
                            <label for="">Pelaksana</label>
                            <input type="text" class="form-control" name="kontrak_pelaksana" placeholder="Masukkan nama pelaksana">
                        </div>
                        <div class="mb-3">
                            <label for="">Direksi</label>
                            <select name="kontrak_direksi" class="form-control">
                                <option>Pilih Direksi</option>
                                <option value="PERENCANAAN">PERENCANAAN</option>
                                <option value="KONSTRUKSI">KONSTRUKSI</option>
                                <option value="JARINGAN">JARINGAN</option>
                                <option value="TRANSAKSI ENERGI">TRANSAKSI ENERGI</option>
                                <option value="NIAGA">NIAGA</option>
                                <option value="PEMASARAN">PEMASARAN</option>
                                <option value="KEUANGAN DAN UMUM">KEUANGAN DAN UMUM</option>
                                <option value="K3L">K3L</option>
                            </select>
                        </div>
                    </form>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</button>
                        <button id="saveKontrakBtn" type="button" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Kontrak modal --}}
    <div class="modal fade" id="kontrakSuccessModal" tabindex="-1" aria-labelledby="kontrakSuccessModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="modal-title" id="kontrakSuccessModalLabel">Success</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="my-4">
                        Kontrak terlah disimpan.
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>@endcan
</div>
@endsection

@section('js')
<script src="/assets/js/services/base-materials.js?v={{ \Str::uuid() }}"></script>
<script src="/assets/js/pages/pengadaan/index.js?v={{ \Str::uuid() }}"></script>
<script src="/assets/js/pages/pengadaan/callback.js?v={{ \Str::uuid() }}"></script>
<script src="/assets/js/pages/pengadaan/services.js?v={{ \Str::uuid() }}"></script>
@endsection