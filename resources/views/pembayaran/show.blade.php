@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 id="nomorSpk">{{ $pembayaran->pelaksanaan->spk ? $pembayaran->pelaksanaan->spk : 'Belum ada SPK' }}</h3>
                <p id="namaPrk" class="text-subtitle text-muted">{{ $pembayaran->pelaksanaan->kontrak->nomor_kontrak }}</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pembayaran</li>
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
                        <form id="pembayaranForm" class="col-12 col-md-6 col-lg-5 col-xl-4">
                            <div class="mb-3">
                                <p class="badge bg-success mb-0">Terakhir diupdate: <span id="lastUpdated">{{ $pembayaran->updated_at }}</span></p>
                            </div>
                            <div class="form-group mb-3">
                                <label for="first-name-vertical">Nomor SPK</label>
                                <input type="text" id="first-name-vertical" disabled class="form-control" name="nama" value="{{ $pembayaran->pelaksanaan->spk ? $pembayaran->pelaksanaan->spk : 'Belum ada SPK' }}" placeholder="Masukkan nama project">
                            </div>
                            <div class="form-group mb-3">
                                <label for="first-name-vertical">Status</label>
                                <select @cannot('edit pembayaan') disabled @endcannot class="form-select pembayaran-field" name="status" aria-label="Default select example">
                                    <option @if($pembayaran->status == 'DALAM PELAKSANAAN') selected @endif value="DALAM PELAKSANAAN">DALAM PELAKSANAAN</option>
                                    <option @if($pembayaran->status == 'ADMINISTRASI PROYEK') selected @endif value="ADMINISTRASI PROYEK">ADMINISTRASI PROYEK</option>
                                    <option @if($pembayaran->status == 'OUTSTANDING') selected @endif value="OUTSTANDING">OUTSTANDING</option>
                                    <option @if($pembayaran->status == 'SELESAI BAYAR') selected @endif value="SELESAI BAYAR">SELESAI BAYAR</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-content">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">Tagihan Jasa</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="jasaTbl" class="table table-stripped">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama Jasa</th>
                                    <th>Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach ($pembayaran->pelaksanaan->jasas as $jasa)
                                <tr id="jasa-{{ $jasa->id }}">
                                    @php $total += $jasa->harga; @endphp
                                    <td>{{ $jasa->tanggal }}</td>
                                    <td>{{ $jasa->nama }}</td>
                                    <td>Rp{{ number_format($jasa->harga, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2">
                                        <div class="d-flex justify-content-end">
                                            <strong>Total</strong>
                                        </div>
                                    </td>
                                    <td><strong>Rp{{ number_format($total, 0, ',', '.') }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-content">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">Tagihan Material</h4>
                    <button id="materialTransaksiBtn" class="btn btn-primary">Lihat detail transaksi</button>
                </div>
                <div class="card-body">
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
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $tagihan_materials = [];
                                    foreach ($pembayaran->pelaksanaan->materials as $material) {
                                        if(!isset($tagihan_materials[$material->normalisasi])) {
                                            $tagihan_materials[$material->normalisasi] = $material;
                                        } else {
                                            if($material->transaksi == 'masuk') {
                                                $tagihan_materials[$material->normalisasi]['jumlah'] += $material->jumlah;
                                            } else {
                                                $tagihan_materials[$material->normalisasi]['jumlah'] -= $material->jumlah;
                                            }
                                        }
                                    }
                                @endphp
                                
                                @foreach ($tagihan_materials as $key => $tagihan_material)
                                <tr id="material-{{ $tagihan_material->id }}">
                                    <td>{{ $tagihan_material->normalisasi }}</td>
                                    <td>{{ $tagihan_material->nama }}</td>
                                    <td>{{ $tagihan_material->satuan }}</td>
                                    <td>Rp{{ number_format($tagihan_material->harga, 0, ',', '.') }}</td>
                                    <td>{{ $tagihan_material->jumlah }}</td>
                                    <td>Rp{{ number_format($tagihan_material->jumlah * $tagihan_material->harga, 0, ',', '.') }}</td>
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
                    <h4 class="card-title">Pembayaran</h4>
                </div>
                <div class="card-body">
                    @can('edit pembayaran')<div class="mb-4">
                        <button id="pembayaranCreateBtn" class="btn btn-primary me-2">Pembayaran Baru</button>
                    </div>@endcannot
                    <div class="table-responsive">
                        <table id="pembayaranPertahapTbl" class="table table-stripped">
                            <thead>
                                <tr>
                                    <th>Keterangan</th>
                                    <th>Nominal</th>
                                    @can('edit pembayaran')<th>:</th>@endcannot
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pembayaran->tahapans as $tahap)
                                <tr id="pembayaran-tahap-{{ $tahap->id }}">
                                    <td>
                                        <div><strong>Dibayarkan</strong>: {{ $tahap->tanggal }}</div>
                                        <div><small>{{ $tahap->keterangan }}</small></div>
                                    </td>
                                    <td>Rp{{ number_format($tahap->nominal, 0, ',', '.') }}</td>
                                    @can('edit pembayaran')<td>
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-warning me-2 editPembayaranPertahapBtn" data-id="{{ $tahap->id }}" data-tanggal="{{ $tahap->tanggal }}" data-keterangan="{{ $tahap->keterangan }}" data-nominal="{{ $tahap->nominal }}">Edit</button>
                                            <button class="btn btn-danger deletePembayaranPertahapBtn" data-id="{{ $tahap->id }}">Hapus</button>
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
                                @foreach ($pembayaran->files as $file)
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
            @can('edit pembayaran')<button class="btn btn-danger me-2">Hapus Data</button>@endcannot
            <button class="btn btn-primary">Selesai</button>
        </div>
    </section>

    {{-- Transaksi Material modal --}}
    <div class="modal fade" id="materialTransaksiModal" tabindex="-1" aria-labelledby="materialTransaksiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="modal-title" id="materialTransaksiModalLabel">Transaksi Material</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="table-responsive my-4">
                        <table id="materialTransaksiTbl" class="table table-stripped">
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

    @can('edit pembayaran'){{-- Pembayaran modal --}}
    <div class="modal fade" id="pembayaranModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="pembayaranModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="modal-title" id="pembayaranModalLabel">Pembayaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="pembayaranPertahapForm" class="my-4">
                        <input id="pembayaranIdInput" type="hidden" name="id">
                        <div class="mb-3">
                            <label for="">Tanggal</label>
                            <input id="pembayaranTanggalInput" type="date" class="form-control" name="tanggal" required placeholder="Masukkan tanggal pembayaran">
                        </div>
                        <div class="mb-3">
                            <label for="">Nominal</label>
                            <input id="pembayaranNominalInput" type="number" class="form-control" name="nominal" required placeholder="Masukkan nilai pembayaran">
                        </div>
                        <div class="mb-3">
                            <label for="">Keterangan</label>
                            <textarea class="form-control" name="keterangan" id="pembayaranKeteranganTextarea" placeholder="Masukkan keterangan" rows="3"></textarea>
                        </div>
                    </form>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Batal</button>
                        <button id="updatePembayaranBtn" type="button" class="btn btn-primary">Perbarui</button>
                        <button id="savePembayaranBtn" type="button" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>@endcannot

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
                        <button id="deletePembayaranPertahapBtn" type="button" class="btn btn-danger">Hapus</button>
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
<script src="/assets/js/pages/pembayaran/index.js?v={{ \Str::uuid() }}"></script>
<script src="/assets/js/pages/pembayaran/callback.js?v={{ \Str::uuid() }}"></script>
<script src="/assets/js/pages/pembayaran/services.js?v={{ \Str::uuid() }}"></script>
@endsection