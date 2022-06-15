@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 id="nomorKontrak">{{ $kontrak->nomor_kontrak ?? '{Nomor Kontrak}' }}</h3>
                <p id="namaPelaksana" class="text-subtitle text-muted">{{ $kontrak->pelaksana ?? '{Pelaksana}' }}</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kontrak</li>
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
                        <form id="kontrakForm" class="col-12 col-md-6 col-lg-5 col-xl-4">
                            <div class="mb-3">
                                <p class="badge bg-success mb-0">Terakhir diupdate: <span id="lastUpdated">{{ $kontrak->updated_at }}</span></p>
                            </div>
                            <div class="form-group mb-3">
                                <label for="first-name-vertical">Nomor Kontrak</label>
                                <input type="text" @if($kontrak->is_amandemen == 0) disabled @endif class="form-control kontrak-field" name="nomor_kontrak" value="{{ $kontrak->nomor_kontrak }}" placeholder="Masukkan nama project">
                            </div>
                            <div class="form-group mb-3">
                                <label for="first-name-vertical">Tanggal Kontrak</label>
                                <input type="date" @if($kontrak->is_amandemen == 0) disabled @endif class="form-control kontrak-field" name="tgl_kontrak" value="{{ $kontrak->tgl_kontrak }}" placeholder="Masukkan nodin">
                            </div>
                            <div class="form-group mb-3">
                                <label for="first-name-vertical">Tanggal Awal</label>
                                <input type="date" @if($kontrak->is_amandemen == 0) disabled @endif class="form-control kontrak-field" name="tgl_awal" value="{{ $kontrak->tgl_awal }}" placeholder="Masukkan tanggal nodin">
                            </div>
                            <div class="form-group mb-3">
                                <label for="first-name-vertical">Tanggal Akhir</label>
                                <input type="date" @if($kontrak->is_amandemen == 0) disabled @endif class="form-control kontrak-field" name="tgl_akhir" value="{{ $kontrak->tgl_akhir }}" placeholder="Masukkan t">
                            </div>
                            <div class="form-group mb-3">
                                <label for="first-name-vertical">Pelaksana</label>
                                <input type="text" @if($kontrak->is_amandemen == 0) disabled @endif class="form-control kontrak-field" name="pelaksana" value="{{ $kontrak->pelaksana }}" placeholder="Masukkan nama pelaksana">
                            </div>
                            <div class="form-group mb-3">
                                <label for="first-name-vertical">Direksi</label>
                                <select @if($kontrak->is_amandemen == 0) disabled @endif name="direksi" class="form-control kontrak-field">
                                    <option>Pilih Direksi</option>
                                    <option @if($kontrak->direksi == "PERENCANAAN") selected @endif value="PERENCANAAN">PERENCANAAN</option>
                                    <option @if($kontrak->direksi == "KONSTRUKSI") selected @endif value="KONSTRUKSI">KONSTRUKSI</option>
                                    <option @if($kontrak->direksi == "JARINGAN") selected @endif value="JARINGAN">JARINGAN</option>
                                    <option @if($kontrak->direksi == "TRANSAKSI ENERGI") selected @endif value="TRANSAKSI ENERGI">TRANSAKSI ENERGI</option>
                                    <option @if($kontrak->direksi == "NIAGA") selected @endif value="NIAGA">NIAGA</option>
                                    <option @if($kontrak->direksi == "PEMASARAN") selected @endif value="PEMASARAN">PEMASARAN</option>
                                    <option @if($kontrak->direksi == "KEUANGAN DAN UMUM") selected @endif value="KEUANGAN DAN UMUM">KEUANGAN DAN UMUM</option>
                                    <option @if($kontrak->direksi == "K3L") selected @endif value="K3L">K3L</option>
                                </select>
                            </div>
                            @if($kontrak->versi_amandemen)
                            <div class="form-group mb-3">
                                <label for="first-name-vertical"><span class="text-danger">Amandemen</span></label>
                                <input type="text" disabled class="form-control kontrak-field" value="{{ $kontrak->versi_amandemen }}">
                            </div>
                            @endif
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
                    @if($kontrak->is_amandemen == 1)
                    <div id="jasaBaruContainer" class="mb-4">
                        <button id="createJasaBtn" class="btn btn-primary">Jasa Baru</button>
                    </div>
                    @endif
                    <div class="table-responsive">
                        <table id="jasaTbl" class="table table-stripped">
                            <thead>
                                <tr>
                                    <th>Nama Jasa</th>
                                    <th>Nilai</th>
                                    @if($kontrak->is_amandemen == 1)
                                    <th class="jasa-table-action">&nbsp;</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kontrak->jasas as $jasa)
                                <tr id="jasa-{{ $jasa->id }}">
                                    <td>{{ $jasa->nama }}</td>
                                    <td>Rp{{ number_format($jasa->harga, 0, ',', '.') }}</td>
                                    @if($kontrak->is_amandemen == 1)
                                    <td class="jasa-table-action">
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-warning me-2 editJasaBtn" data-id="{{ $jasa->id }}" data-nama="{{ $jasa->nama }}" data-harga="{{ $jasa->harga }}">Edit</button>
                                            <button class="btn btn-danger deleteJasaBtn" data-id="{{ $jasa->id }}">Hapus</button>
                                        </div>
                                    </td>
                                    @endif
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
                    @if($kontrak->is_amandemen == 1)
                    <div id="materialBaruContainer" class="mb-4">
                        <button id="createMaterialBtn" class="btn btn-primary">Material Baru</button>
                    </div>
                    @endif
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
                                    @if($kontrak->is_amandemen == 1)
                                    <th class="material-table-action">:</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kontrak->materials as $material)
                                <tr id="material-{{ $material->id }}">
                                    <td>{{ $material->normalisasi }}</td>
                                    <td>{{ $material->nama }}</td>
                                    <td>{{ $material->satuan }}</td>
                                    <td>Rp{{ number_format($material->harga, 0, ',', '.') }}</td>
                                    <td>{{ $material->jumlah }}</td>
                                    <td>Rp{{ number_format($material->jumlah * $material->harga, 0, ',', '.') }}</td>
                                    @if($kontrak->is_amandemen == 1)
                                    <td class="material-table-action">
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-warning me-2 editMaterialBtn" data-id="{{ $material->id }}" data-normalisasi="{{ $material->normalisasi }}" data-nama="{{ $material->nama }}" data-satuan="{{ $material->satuan }}" data-harga="{{ $material->harga }}" data-jumlah="{{ $material->jumlah }}" data-stok="{{ $material->stok }}" data-base-material-id="{{ $material->base_material_id }}" data-deskripsi="{{ $material->deskripsi }}">Edit</button>
                                            <button class="btn btn-danger deleteMaterialBtn" data-id="{{ $material->id }}">Hapus</button>
                                        </div>
                                    </td>
                                    @endif
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
                                @foreach ($kontrak->files as $file)
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
            @can('edit kontrak')
            <button class="btn btn-danger me-2">Hapus Data</button>
            @if($kontrak->is_amandemen == 0)
            <button id="amandemenBtn" class="btn btn-warning me-2">Amandemen</button>
            @else
            <button id="amandemenDoneBtn" class="btn btn-warning me-2">Selesai Amandemen</button>
            @endif
            @endcan
            <a href="/kontrak" class="btn btn-primary">Selesai</a>
        </div>
    </section>

    {{-- Jasa modal --}}
    <div class="modal fade" id="jasaModal" tabindex="-1" aria-labelledby="jasaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="jasaForm" class="modal-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="modal-title" id="jasaModalLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="my-4">
                        <input type="hidden" name="jasa_id">
                        <div class="mb-3">
                            <label for="">Nama Jasa</label>
                            <input type="text" class="form-control" name="jasa_nama" placeholder="Masukkan nama jasa">
                        </div>
                        <div class="mb-3">
                            <label for="">Harga</label>
                            <input type="text" class="form-control" name="jasa_harga" placeholder="Masukkan nilai jasa">
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</button>
                        <button id="updateJasaBtn" type="button" class="btn btn-primary">Perbarui</button>
                        <button id="saveJasaBtn" type="button" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
                        <!-- <a href="" class="btn btn-primary">Lihat PRK</a> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Material modal --}}
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
    </div>

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

    @can('edit kontrak')
    {{-- Amandemen modal --}}
    <div class="modal fade" id="amandemenModal" tabindex="-1" aria-labelledby="amandemenModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="modal-title" id="amandemenModalLabel">Amandemen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="amandemenForm" class="my-4">
                        <div class="mb-3">
                            <label for="">Versi Amandemen</label>
                            <input type="text" class="form-control" name="versi_amandemen">
                        </div>
                    </form>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</button>
                        <button id="amandemenSave" type="button" class="btn btn-primary">Lanjutkan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcan
</div>
@endsection

@section('js')
<script src="/assets/js/services/base-materials.js?v={{ \Str::uuid() }}"></script>
<script src="/assets/js/pages/kontrak/index.js?v={{ \Str::uuid() }}"></script>
<script src="/assets/js/pages/kontrak/callback.js?v={{ \Str::uuid() }}"></script>
<script src="/assets/js/pages/kontrak/services.js?v={{ \Str::uuid() }}"></script>
@endsection