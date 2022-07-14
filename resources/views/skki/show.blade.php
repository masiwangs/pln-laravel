@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 id="nomorSkki">{{ $skki->skki ?? '{Nomor SKKI}' }}</h3>
                <p id="namaPrk" class="text-subtitle text-muted">{{ $skki->nama ?? '{Nama Project}' }}</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">SKKI</li>
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
                    <form id="skkiForm" class="row">
                        <div class="col-12 col-md-6 col-lg-5 col-xl-4">
                            <div class="mb-3">
                                <p class="badge bg-success mb-0">Terakhir diupdate: <span id="lastUpdated">{{ $skki->updated_at }}</span></p>
                            </div>
                            <div class="form-group mb-3">
                                <label for="first-name-vertical">Nama Project</label>
                                <input type="text" id="namaProject" class="form-control skki-field" name="nama" value="" placeholder="Masukkan nama project">
                            </div>
                            <div class="form-group mb-3">
                                <label for="first-name-vertical">Nomor SKKI</label>
                                <input @cannot('edit skki') disabled @endcannot type="text" id="first-name-vertical" class="form-control skki-field" name="skki" value="{{ $skki->skki }}" placeholder="Masukkan nomor SKKI">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="form-group col-12 col-md-6 col-lg-4">
                                    <label for="first-name-vertical">Nomor PRK-SKKI</label>
                                    <input @cannot('edit skki') disabled @endcannot type="text" id="first-name-vertical" class="form-control skki-field" name="prk_skki" value="{{ $skki->prk_skki }}" placeholder="Masukkan nomor PRK-SKKI">
                                </div>
                                <div class="form-group col-12 col-md-6 col-lg-4">
                                    <label for="first-name-vertical">WBS Jasa</label>
                                    <input readonly type="text" class="form-control"value="Rp{{ number_format($skki->wbs_jasa, 0, ',', '.') }}" placeholder="WBS Jasa">
                                </div>
                                <div class="form-group col-12 col-md-6 col-lg-4">
                                    <label for="first-name-vertical">WBS Material</label>
                                    <input readonly type="text" class="form-control"value="Rp{{ number_format($skki->wbs_material, 0, ',', '.') }}" placeholder="WBS Material">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- PRK kecil --}}
        <div class="card mb-4">
            <div class="card-content">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">Daftar PRK</h4>
                </div>
                <div class="card-body table-responsive" style="min-height: 350px">
                    <table id="prkTable" class="table">
                        <thead>
                            <tr>
                                <th>:</th>
                                <th>Nomor PRK</th>
                                <th>Nama Project</th>
                                <th>RAB Jasa</th>
                                <th>RAB Material</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($skki->prks as $prk)
                            <tr id="prk-{{ $prk->id }}">
                                <td>
                                    <div class="dropdown">
                                        <a class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-list"></i>
                                        </a>
                                        <ul class="dropdown-menu shadow" aria-labelledby="dropdownMenuButton1">
                                            <li>
                                                <a class="dropdown-item importJasaPrk" href="javascript:void(0)" data-id="{{ $prk->id }}">Import Jasa</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item importMaterialPrk" href="javascript:void(0)" data-id="{{ $prk->id }}">Import Material</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" class="dropdown-item text-danger deletePrk" data-id="{{ $prk->id }}">Hapus</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                                <td>{{ $prk->prk }}</td>
                                <td>{{ $prk->nama }}</td>
                                <td>Rp{{ number_format($prk->rab_jasa, 0, ',', '.') }}</td>
                                <td>Rp{{ number_format($prk->rab_material, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex flex-row">
                        <div class="flex-fill me-2">
                            <select name="prk" id="prkSelect2" class="form-control">
                                @foreach ($prks as $prkOption)
                                    <option value="{{ $prkOption->id }}">{{ $prkOption->prk }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <button id="addPrk" class="btn btn-success">Tambah</button>
                        </div>
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
                    @can('edit skki')
                    <div class="mb-4">
                        <button id="createJasaBtn" class="btn btn-primary">Baru</button>
                    </div>
                    @endcan
                    <div class="table-responsive">
                        <table id="jasaTbl" class="table table-stripped">
                            <thead>
                                <tr>
                                    <th>Nama Jasa</th>
                                    <th>Nilai</th>
                                    @can('edit skki')
                                    <th>&nbsp;</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($skki->jasas as $jasa)
                                <tr id="jasa-{{ $jasa->id }}">
                                    <td>{{ $jasa->nama }}</td>
                                    <td>Rp{{ number_format($jasa->harga, 0, ',', '.') }}</td>
                                    @can('edit skki')
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
                    @can('edit skki')
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
                                    @can('edit skki')
                                    <th>:</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($skki->materials as $material)
                                <tr id="material-{{ $material->id }}">
                                    <td>{{ $material->normalisasi }}</td>
                                    <td>{{ $material->nama }}</td>
                                    <td>{{ $material->satuan }}</td>
                                    <td>Rp{{ number_format($material->harga, 0, ',', '.') }}</td>
                                    <td>{{ $material->jumlah }}</td>
                                    <td>Rp{{ number_format($material->jumlah * $material->harga, 0, ',', '.') }}</td>
                                    @can('edit skki')
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
                                @foreach ($skki->files as $file)
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
            @can('edit skki')
            <button id="deleteProject" class="btn btn-danger me-2">Hapus Data</button>
            @endcan
            <button class="btn btn-primary">Selesai</button>
        </div>
    </section>

    @can('edit skki')
    {{-- Jasa modal --}}
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
    </div>
    @endcan
    {{-- Jasa di PRK modal --}}
    <div class="modal fade" id="jasaPrkModal" tabindex="-1" aria-labelledby="jasaPrkModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="modal-title" id="jasaPrkModalLabel">Jasa di PRK</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="my-4">
                        <table id="jasaPrkTbl" class="table table-stripped">
                            <thead>
                                <tr>
                                    <th>Nama Jasa</th>
                                    <th>Nilai</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($skki->prk)
                                @foreach ($skki->prk->jasas as $jasa)
                                <tr>
                                    <td>{{ $jasa->nama }}</td>
                                    <td>Rp{{ number_format($jasa->harga, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</button>
                        @if($skki->prk)
                        <a href="/prk/{{ $skki->prk->id }}" class="btn btn-primary">Lihat PRK</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @can('edit skki')
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
                            <select name="base_material_id" id="materialSelect">
                                @foreach ($base_materials as $base_material)
                                <option value="{{ $base_material->id }}">{{ $base_material->normalisasi }} - {{ $base_material->nama }}</option>
                                @endforeach
                            </select>
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
    </div>
    @endcan
    {{-- Material di PRK modal --}}
    <div class="modal fade" id="materialPrkModal" tabindex="-1" aria-labelledby="materialPrkModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="modal-title" id="materialPrkModalLabel">Material di PRK</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="my-4 table-responsive">
                        <table id="materialPrkTbl" class="table table-stripped">
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
                            <tbody>
                                @if($skki->prk)
                                @foreach ($skki->prk->materials as $material)
                                <tr>
                                    <td>{{ $material->normalisasi }}</td>
                                    <td>{{ $material->nama }}</td>
                                    <td>{{ $material->satuan }}</td>
                                    <td>Rp{{ number_format($material->harga, 0, ',', '.') }}</td>
                                    <td>{{ $material->jumlah }}</td>
                                    <td>Rp{{ number_format($material->jumlah * $material->harga, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</button>
                        @if($skki->prk)
                        <a href="/prk/{{ $skki->prk->id }}" class="btn btn-primary">Lihat PRK</a>
                        @endif
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
                        <button id="deleteProjectBtn" type="button" class="btn btn-danger">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="/assets/js/services/base-materials.js?v={{ \Str::uuid() }}"></script>
<script src="/assets/js/pages/skki/index.js?v={{ \Str::uuid() }}"></script>
<script src="/assets/js/pages/skki/callback.js?v={{ \Str::uuid() }}"></script>
<script src="/assets/js/pages/skki/services.js?v={{ \Str::uuid() }}"></script>
@endsection