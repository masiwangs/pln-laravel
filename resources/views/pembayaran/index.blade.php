@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Pembayaran</h3>
                <p class="text-subtitle text-muted">List Pembayaran Project</p>
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
        <div class="card">
            <div class="card-content">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">Basket 1</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="min-height: 250px">
                        <table id="prk01" class="table table-striped" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Nomor Kontrak</th>
                                    <th>SPK</th>
                                    <th>Tagihan</th>
                                    <th>Terbayar</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(collect($pembayarans)->where('basket', 1) as $pembayaran)
                                <tr>
                                    <td>
                                        <div class="dropdown">
                                            <span class="text-primary" role="button" id="dropdown-{{ $pembayaran->id }}" data-bs-toggle="dropdown" aria-expanded="false">{{ $pembayaran->pelaksanaan->kontrak->nomor_kontrak }}</span>
                                            <ul class="dropdown-menu shadow" aria-labelledby="dropdown-{{ $pembayaran->id }}">
                                                <li><a class="dropdown-item" href="/pembayaran/{{ $pembayaran->id }}"><i class="bi bi-eye"></i> Detail</a></li>
                                                <li><a class="dropdown-item" href="/kontrak/{{ $pembayaran->pelaksanaan->kontrak_id }}"><i class="bi bi-file-earmark-check-fill"></i> Lihat Kontrak</a></li>
                                                <li><a class="dropdown-item" href="/pelaksanaan/{{ $pembayaran->pelaksanaan_id }}"><i class="bi bi-cart"></i> Lihat Pelaksanaan</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td>{{ $pembayaran->pelaksanaan->spk ? $pembayaran->pelaksanaan->spk : 'Belum ada SPK' }}</td>
                                    <td>
                                        @php
                                            $tagihan_jasa = collect($pembayaran->pelaksanaan->jasas)->sum('harga');
                                            $tagihan_material = collect($pembayaran->pelaksanaan->materials)->map(function ($item) {
                                                if($item->transaksi == 'keluar') {
                                                    return $item->jumlah*$item->harga;
                                                } else {
                                                    return -1*$item->jumlah*$item->harga;
                                                }
                                            })->sum();
                                        @endphp
                                        Rp{{ number_format($tagihan_jasa + $tagihan_material, 0, ',', '.') }}
                                    </td>
                                    <td>Rp{{ number_format(collect($pembayaran->tahapans)->sum('nominal'), 0, ',', '.') }}</td>
                                    <td>{{ $pembayaran->status }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        $('#prk01').DataTable();
    });
</script>
@endsection