@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Pelaksanaan {{ $pelaksanaan->kontrak->nomor_kontrak }}</h3>
                <p class="text-subtitle text-muted">{{ $pelaksanaan->kontrak->pelaksana }}</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pelaksanaan</li>
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
                        <form id="pelaksanaanForm" class="col-12 col-md-6 col-lg-5 col-xl-4 me-auto">
                            <div class="mb-3">
                                <p class="badge bg-success mb-0">Terakhir diupdate: <span id="lastUpdated">{{ $pelaksanaan->updated_at }}</span></p>
                            </div>
                            <div class="form-group mb-3">
                                <label for="first-name-vertical">SPK</label>
                                <input type="text" id="first-name-vertical" class="form-control pelaksanaan-field" name="spk" value="{{ $pelaksanaan->spk }}" placeholder="Masukkan SPK">
                            </div>
                            <div class="form-group mb-3">
                                <label for="first-name-vertical">Progress</label>
                                <input type="number" min="0" max="100" step="1" id="progressInput" class="form-control pelaksanaan-field" name="progress" value="{{ $pelaksanaan->progress }}" oninput="handleProgressInputChange()" placeholder="Masukkan Progress">
                                <input type="range" class="form-range pelaksanaan-field" min="0" max="100" step="1" id="progressRange" value="{{ $pelaksanaan->progress }}" oninput="handleProgressChange()">
                            </div>
                        </form>
                        <div class="col-12 col-md-6 col-lg-5 col-xl-4">
                            <div class="card shadow-sm">
                                <div class="card-header d-flex justify-content-between">
                                    <h4 class="card-title">Detail Kontrak</h4>
                                    <a id="kontrakDetailToggle" href="javascript:void();">Lihat <i class="bi bi-eye"></i></a>
                                </div>
                                <div id="kontrakDetailContainer" class="card-body d-none">
                                    <form id="kontrakForm">
                                        <div class="form-group mb-3">
                                            <label for="first-name-vertical">Nomor Kontrak</label>
                                            <input type="text" disabled class="form-control kontrak-field" name="nomor_kontrak" value="{{ $pelaksanaan->kontrak->nomor_kontrak }}" placeholder="Masukkan nama project">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="first-name-vertical">Tanggal Kontrak</label>
                                            <input type="date" disabled class="form-control kontrak-field" name="tgl_kontrak" value="{{ $pelaksanaan->kontrak->tgl_kontrak }}" placeholder="Masukkan nodin">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="first-name-vertical">Tanggal Awal</label>
                                            <input type="date" disabled class="form-control kontrak-field" name="tgl_awal" value="{{ $pelaksanaan->kontrak->tgl_awal }}" placeholder="Masukkan tanggal nodin">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="first-name-vertical">Tanggal Akhir</label>
                                            <input type="date" disabled class="form-control kontrak-field" name="tgl_akhir" value="{{ $pelaksanaan->kontrak->tgl_akhir }}" placeholder="Masukkan t">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="first-name-vertical">Pelaksana</label>
                                            <input type="text" disabled class="form-control kontrak-field" name="pelaksana" value="{{ $pelaksanaan->kontrak->pelaksana }}" placeholder="Masukkan nama pelaksana">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="first-name-vertical">Direksi</label>
                                            <select disabled name="direksi" class="form-control kontrak-field">
                                                <option>Pilih Direksi</option>
                                                <option @if($pelaksanaan->kontrak->direksi == "PERENCANAAN") selected @endif value="PERENCANAAN">PERENCANAAN</option>
                                                <option @if($pelaksanaan->kontrak->direksi == "KONSTRUKSI") selected @endif value="KONSTRUKSI">KONSTRUKSI</option>
                                                <option @if($pelaksanaan->kontrak->direksi == "JARINGAN") selected @endif value="JARINGAN">JARINGAN</option>
                                                <option @if($pelaksanaan->kontrak->direksi == "TRANSAKSI ENERGI") selected @endif value="TRANSAKSI ENERGI">TRANSAKSI ENERGI</option>
                                                <option @if($pelaksanaan->kontrak->direksi == "NIAGA") selected @endif value="NIAGA">NIAGA</option>
                                                <option @if($pelaksanaan->kontrak->direksi == "PEMASARAN") selected @endif value="PEMASARAN">PEMASARAN</option>
                                                <option @if($pelaksanaan->kontrak->direksi == "KEUANGAN DAN UMUM") selected @endif value="KEUANGAN DAN UMUM">KEUANGAN DAN UMUM</option>
                                                <option @if($pelaksanaan->kontrak->direksi == "K3L") selected @endif value="K3L">K3L</option>
                                            </select>
                                        </div>
                                        @if($pelaksanaan->kontrak->versi_amandemen)
                                        <div class="form-group mb-3">
                                            <label for="first-name-vertical"><span class="text-danger">Amandemen</span></label>
                                            <input type="text" disabled class="form-control kontrak-field" value="{{ $pelaksanaan->kontrak->versi_amandemen }}">
                                        </div>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-content">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">Realisasi Jasa</h4>
                    <button class="btn btn-primary" id="jasaRabToggle">Lihat RAB</button>
                </div>
                <div class="card-body">
                    <div class="mb-4 d-flex flex-row">
                        <div class="input-group me-2" style="max-width: 15rem">
                            <span class="input-group-text" id="basic-addon1">RAB</span>
                            <input id="jasaRabText" type="text" class="form-control" style="background: white" disabled value="{{ 'Rp'.number_format(collect($pelaksanaan->kontrak->jasas)->sum('harga'), 0, ',', '.') }}" data-sum="{{ collect($pelaksanaan->kontrak->jasas)->sum('harga') }}" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group" style="max-width: 15rem">
                            <span class="input-group-text" id="basic-addon1">Saldo</span>
                            <input id="jasaSaldoText" type="text" class="form-control" style="background: white" disabled value="{{ 'Rp'.number_format(collect($pelaksanaan->kontrak->jasas)->sum('harga') - collect($pelaksanaan->jasas)->sum('harga'), 0, ',', '.') }}" data-sum="{{ collect($pelaksanaan->kontrak->jasas)->sum('harga') - collect($pelaksanaan->jasas)->sum('harga') }}" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                    </div>
                    @can('edit pelaksanaan')<div class="mb-4">
                        <button id="jasaRealisasiCreateBtn" class="btn btn-primary me-2">Realisasi Baru</button>
                    </div>@endcannot
                    <div class="table-responsive">
                        <table id="jasaTbl" class="table table-stripped">
                            <thead>
                                <tr>
                                    <th>Nama Jasa</th>
                                    <th>Nilai</th>
                                    <th>Tanggal</th>
                                    @can('edit pelaksanaan')<th>&nbsp;</th>@endcannot
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pelaksanaan->jasas as $jasa)
                                <tr id="jasa-{{ $jasa->id }}">
                                    <td>{{ $jasa->nama }}</td>
                                    <td>Rp{{ number_format($jasa->harga, 0, ',', '.') }}</td>
                                    <td>{{ $jasa->tanggal }}</td>
                                    @can('edit pelaksanaan')<td>
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-warning me-2 editJasaBtn" data-id="{{ $jasa->id }}" data-nama="{{ $jasa->nama }}" data-harga="{{ $jasa->harga }}">Edit</button>
                                            <button class="btn btn-danger deleteJasaBtn" data-id="{{ $jasa->id }}">Hapus</button>
                                        </div>
                                    </td>@endcannot
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-content">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">RAB Material</h4>
                    <div>
                        <button class="btn btn-primary" id="materialRabToggle">Lihat RAB</button>
                        <button class="btn btn-primary" id="materialStokToggle">Lihat Stok</button>
                    </div>
                </div>
                <div class="card-body">
                    @can('edit pelaksanaan')<div class="mb-4">
                        <button id="reservasiMaterialBtn" class="btn btn-danger">Reservasi Baru</button>
                        <button id="returMaterialBtn" class="btn btn-primary">Retur Baru</button>
                        {{-- <button class="btn btn-success">Import Excel</button> --}}
                    </div>@endcannot
                    <div class="table-responsive">
                        <table id="materialTbl" class="table table-stripped">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>TUG9</th>
                                    <th>Transaksi</th>
                                    <th>Kode Normalisasi</th>
                                    <th>Nama Material</th>
                                    <th>Satuan</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                    @can('edit pelaksanaan')<th>:</th>@endcannot
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pelaksanaan->materials as $material)
                                <tr id="material-{{ $material->id }}">
                                    <td>{{ $material->tanggal }}</td>
                                    <td>{{ $material->tug9 }}</td>
                                    <td>@if($material->transaksi == 'keluar') <span class="text-danger">reservasi</span> @else <span class="text-primary">retur</span> @endif</td>
                                    <td>{{ $material->normalisasi }}</td>
                                    <td>{{ $material->nama }}</td>
                                    <td>{{ $material->satuan }}</td>
                                    <td>Rp{{ number_format($material->harga, 0, ',', '.') }}</td>
                                    <td>{{ $material->jumlah }}</td>
                                    <td>Rp{{ number_format($material->jumlah * $material->harga, 0, ',', '.') }}</td>
                                    @can('edit pelaksanaan')<td>
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-warning me-2 editMaterialBtn" data-id="{{ $material->id }}" data-normalisasi="{{ $material->normalisasi }}" data-nama="{{ $material->nama }}" data-satuan="{{ $material->satuan }}" data-harga="{{ $material->harga }}" data-tug9="{{ $material->tug9 }}" data-tanggal="{{ $material->tanggal }}" data-transaksi="{{ $material->transaksi }}" data-jumlah="{{ $material->jumlah }}" data-base-material-id="{{ $material->base_material_id }}" data-deskripsi="{{ $material->deskripsi }}">Edit</button>
                                            <button class="btn btn-danger deleteMaterialBtn" data-id="{{ $material->id }}">Hapus</button>
                                        </div>
                                    </td>@endcannot
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

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
                                @foreach ($pelaksanaan->files as $file)
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
            @can('edit pelaksanaan')<button class="btn btn-danger me-2">Hapus Data</button>@endcannot
            <button class="btn btn-primary">Selesai</button>
        </div>
    </section>

    @can('edit pelaksanaan'){{-- Jasa modal --}}
    <div class="modal fade" id="jasaModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="jasaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="modal-title" id="jasaModalLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="jasaForm" class="my-4">
                        <input id="jasaIdInput" type="hidden" name="id">
                        <div class="mb-3">
                            <label for="">Nama Jasa</label>
                            <input id="jasaNamaInput" type="text" class="form-control" name="nama" required placeholder="Masukkan nama jasa">
                        </div>
                        <div class="mb-3">
                            <label for="">Harga</label>
                            <input id="jasaHargaInput" type="text" class="form-control" name="harga" required placeholder="Masukkan nilai jasa">
                        </div>
                        <div class="mb-3">
                            <label for="">Tanggal</label>
                            <input id="jasaTanggalInput" type="date" class="form-control" name="tanggal" placeholder="Masukkan nilai jasa">
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
    </div>@endcannot

    {{-- RAB modal --}}
    <div class="modal fade" id="jasaRabModal" tabindex="-1" aria-labelledby="jasaRabModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="modal-title" id="jasaRabModalLabel">RAB Jasa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="my-4">
                        <table id="jasaRabTbl" class="table table-stripped">
                            <thead>
                                <tr>
                                    <th>Nama Jasa</th>
                                    <th>Nilai</th>
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

    @can('edit pelaksanaan'){{-- Material modal --}}
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
                        <input id="materialTransaksiType" type="hidden" name="material_transaksi">
                        <input type="hidden" name="material_normalisasi" id="materialNormalisasi">
                        <div class="mb-3">
                            <label for="">Tanggal</label>
                            <input type="date" class="form-control" name="material_tanggal" placeholder="Masukkan tanggal">
                        </div>
                        <div class="mb-3">
                            <label for="">TUG9</label>
                            <input type="text" class="form-control" name="material_tug9" placeholder="Masukkan TUG9">
                        </div>
                        <div class="mb-3">
                            <label for="">Kode Normalisasi</label>
                            <input type="text" list="materialList" class="form-control" name="base_material_id" placeholder="Masukkan kode normalisasi">
                            <small id="materialNormalisasiMessageContainer" style="display: none"><i class="bi bi-info-circle"></i> Data diatas hanya id di database. Kode normalisasi sebenarnya adalah <strong id="selectedMaterialNormalisasi"></strong></small>
                            <datalist id="materialList"></datalist>
                        </div>
                        <div class="mb-3">
                            <label for="">Nama Material</label>
                            <input type="text" class="form-control" name="material_nama" placeholder="Masukkan nama material">
                        </div>
                        <div class="mb-3">
                            <label for="">Deskripsi</label>
                            <textarea name="material_deskripsi" placeholder="Masukkan deskripsi material" class="form-control" id="" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="">Satuan</label>
                            <input type="text" class="form-control" name="material_satuan" placeholder="Masukkan satuan">
                        </div>
                        <div class="mb-3">
                            <label for="">Harga</label>
                            <input type="text" class="form-control" name="material_harga" placeholder="Masukkan harga material">
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
    </div>@endcannot

    {{-- RAB modal --}}
    <div class="modal fade" id="materialRabModal" tabindex="-1" aria-labelledby="materialRabModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="modal-title" id="materialRabModalLabel">RAB Jasa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="my-4">
                        <table id="materialRabTbl" class="table table-stripped">
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

    {{-- Stok modal --}}
    <div class="modal fade" id="materialStokModal" tabindex="-1" aria-labelledby="materialStokModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="modal-title" id="materialStokModalLabel">Stok Material</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="my-4">
                        <table id="materialStokTbl" class="table table-stripped">
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
                    <form id="fileForm" class="my-4">
                        <input type="hidden" name="file_id">
                        <div class="mb-3">
                            <label for="">File Lampiran</label>
                            <input type="file" class="form-control" name="file">
                        </div>
                        <div class="mb-3">
                            <label for="">Deskripsi</label>
                            <textarea name="file_deskripsi" placeholder="Masukkan deskripsi lampiran" class="form-control" id="" rows="2"></textarea>
                        </div>
                    </form>
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
</div>
@endsection

@section('js')
<script src="/assets/js/services/base-materials.js?v={{ \Str::uuid() }}"></script>
<script src="/assets/js/pages/pelaksanaan/index.js?v={{ \Str::uuid() }}"></script>
<script src="/assets/js/pages/pelaksanaan/callback.js?v={{ \Str::uuid() }}"></script>
<script src="/assets/js/pages/pelaksanaan/services.js?v={{ \Str::uuid() }}"></script>
@endsection