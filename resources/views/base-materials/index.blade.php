@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Database Material</h3>
                <p class="text-subtitle text-muted">List detail material</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="index.html">Database</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Material</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end mb-4">
        <button id="baseMaterialCreateBtn" class="btn btn-primary me-2">Material Baru</button>
        <button id="baseMaterialImportBtn" class="btn btn-success">Import Material</button>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="baseMaterialTbl" class="table table-striped" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Kode Normalisasi</th>
                                    <th>Nama Material</th>
                                    <th>Satuan</th>
                                    <th>Harga</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($base_materials as $base_material)
                                <tr id="base-material-{{ $base_material->id }}">
                                    <td>{{ $base_material->normalisasi }}</td>
                                    <td>
                                        <div>{{ $base_material->nama }}</div>
                                        <small>{{ $base_material->deskripsi }}</small>
                                    </td>
                                    <td>{{ $base_material->satuan }}</td>
                                    <td>Rp{{ number_format($base_material->harga, 2, ',', '.') }}</td>
                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-warning me-2 editBaseMaterialBtn" data-id="{{ $base_material->id }}" data-normalisasi="{{ $base_material->normalisasi }}" data-nama="{{ $base_material->nama }}" data-deskripsi="{{ $base_material->deskripsi }}" data-satuan="{{ $base_material->satuan }}" data-harga="{{ $base_material->harga }}">Edit</button>
                                            <button class="btn btn-danger deleteBaseMaterialBtn" data-id="{{ $base_material->id }}">Hapus</button>
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
    </section>

    <div class="modal fade" id="baseMaterialModal" tabindex="-1" aria-labelledby="baseMaterialModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="modal-title" id="baseMaterialModalLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="baseMaterialForm" class="my-4">
                        <input id="materialIdInput" type="hidden" name="id">
                        <div class="mb-3">
                            <label for="">Kode Normalisasi</label>
                            <input id="materialNormalisasiInput" type="text" class="form-control" name="normalisasi" placeholder="Masukkan kode normalisasi">
                        </div>
                        <div class="mb-3">
                            <label for="">Nama Material</label>
                            <input id="materialNamaInput" type="text" class="form-control" name="nama" placeholder="Masukkan nama material">
                        </div>
                        <div class="mb-3">
                            <label for="">Deskripsi</label>
                            <textarea id="materialDeskripsiTextarea" name="deskripsi" placeholder="Masukkan deskripsi material" class="form-control" id="" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="">Satuan</label>
                            <input id="materialSatuanInput" type="text" class="form-control" name="satuan" placeholder="Masukkan satuan">
                        </div>
                        <div class="mb-3">
                            <label for="">Harga</label>
                            <input id="materialHargaInput" type="number" class="form-control" name="harga" placeholder="Masukkan harga material">
                        </div>
                    </form>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</button>
                        <button id="saveBaseMaterialBtn" type="button" class="btn btn-primary">Simpan</button>
                        <button id="updateBaseMaterialBtn" type="button" class="btn btn-primary">Perbarui</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="baseMaterialImportModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="baseMaterialImportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="modal-title" id="baseMaterialImportModalLabel">Import Material</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="baseMaterialForm" action="/database/material/import" method="POST" class="mt-4" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="">File</label>
                            <input type="file" name="file" class="form-control" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required>
                            @error('file')
                            <div>
                                <small class="text-danger">{{ $message }}</small>
                            </div>
                            @enderror
                            <small>Unduh template <a href="/assets/template/import_material_template.xlsx">disini</a>.</small>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</button>
                            <button id="importBaseMaterialBtn" type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
                        <button id="deleteBaseMaterialBtn" type="button" class="btn btn-danger">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="/assets/js/pages/base-materials/index.js?v={{ \Str::uuid() }}"></script>
<script src="/assets/js/pages/base-materials/callback.js?v={{ \Str::uuid() }}"></script>
<script src="/assets/js/pages/base-materials/services.js?v={{ \Str::uuid() }}"></script>
@endsection