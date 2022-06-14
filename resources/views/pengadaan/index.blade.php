@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Pengadaan</h3>
                <p class="text-subtitle text-muted">List project dalam tahap Pengadaan</p>
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
        <div class="card">
            <div class="card-content">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">Basket 1</h4>
                    @can('edit pengadaan')
                    <a href="/pengadaan/baru?basket=1" class="btn btn-primary">Baru</a>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="prk01" class="table table-striped" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Nodin</th>
                                    <th>Tanggal Nodin</th>
                                    <th>Nama Project</th>
                                    <th>RAB Jasa</th>
                                    <th>RAB Material</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($result['basket_1'] as $pengadaan)
                                <tr>
                                    <td>
                                        <a href="/pengadaan/{{ $pengadaan->id }}">{{ $pengadaan->nodin ?? 'BELUM ADA NODIN' }}</a>
                                    </td>
                                    <td>{{ $pengadaan->tgl_nodin }}</td>
                                    <td>{{ $pengadaan->nama }}</td>
                                    <td>Rp{{ number_format(collect($pengadaan->jasas)->sum('harga'), 0, ',', '.') }}</td>
                                    <td>Rp{{ number_format(collect($pengadaan->materials)->map(function ($item) {return $item->jumlah * $item->harga;})->sum(), 0, ',', '.') }}</td>
                                    <td>{{ $pengadaan->status }}</td>
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