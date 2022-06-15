@extends('layouts.app')

@php
    $prk_jasa = collect($prks)->map(function ($item) { return $item[0]; })->sum();
    $prk_material = collect($prks)->map(function ($item) { return $item[1]; })->sum();
    $prk_total = $prk_jasa + $prk_material;
    $skki_jasa = collect($skkis)->map(function ($item) { return $item[0]; })->sum();
    $skki_material = collect($skkis)->map(function ($item) { return $item[1]; })->sum();
    $skki_total = $skki_jasa + $skki_material;
    $pengadaan_jasa = collect($pengadaans)->map(function ($item) { return $item[0]; })->sum();
    $pengadaan_material = collect($pengadaans)->map(function ($item) { return $item[1]; })->sum();
    $pengadaan_total = $pengadaan_jasa + $pengadaan_material;
    $kontrak_jasa = collect($kontraks)->map(function ($item) { return $item[0]; })->sum();
    $kontrak_material = collect($kontraks)->map(function ($item) { return $item[1]; })->sum();
    $kontrak_total = $kontrak_jasa + $kontrak_material;
    $pelaksanaan_jasa = collect($pelaksanaans)->map(function ($item) { return $item[0]; })->sum();
    $pelaksanaan_material = collect($pelaksanaans)->map(function ($item) { return $item[1]; })->sum();
    $pelaksanaan_total = $pelaksanaan_jasa + $pelaksanaan_material;
    $pembayaran = collect($pembayarans)->map(function ($item) { return collect($item)->sum(); })->sum();
@endphp
@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Halo, {{ auth()->user()->name }}</h3>
                <p class="text-subtitle text-muted">Selamat datang di dashboard</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="/">Dashboard</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    
    <section class="section">
        <div class="row">
            <div class="card col-12 col-md-6 col-lg-4 mb-3">
                <div class="card-body p-3">
                    <h5>Filter</h5>
                    <form action="" method="GET">
                        <div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Basket</span>
                                <select name="basket" id="" class="form-control">
                                    <option value="SEMUA" @if(!(\Request::query('basket'))) selected @endif>SEMUA</option>
                                    <option value="1" @if(\Request::query('basket') == 1) selected @endif>1</option>
                                    <option value="2" @if(\Request::query('basket') == 2) selected @endif>2</option>
                                    <option value="3" @if(\Request::query('basket') == 3) selected @endif>3</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Terapkan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-2 mb-3">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="mb-2">
                            <h5>PRK</h5>
                            <strong>Rp{{ number_format($prk_jasa + $prk_material, 0, ',', '.') }}</strong>
                        </div>
                        <div>
                            <strong>Jasa</strong><br>
                            <small>Rp{{ number_format($prk_jasa, 0, ',', '.') }}</small>
                        </div>
                        <div>
                            <strong>Material</strong><br>
                            <small>Rp{{ number_format($prk_material, 0, ',', '.') }}</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-2 mb-3">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="mb-2">
                            <h5>SKKI</h5>
                            <strong>Rp{{ number_format($skki_jasa + $skki_material, 0, ',', '.') }}</strong>
                        </div>
                        <div>
                            <strong>Jasa</strong><br>
                            <small>Rp{{ number_format($skki_jasa, 0, ',', '.') }}</small>
                        </div>
                        <div>
                            <strong>Material</strong><br>
                            <small>Rp{{ number_format($skki_material, 0, ',', '.') }}</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-2 mb-3">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="mb-2">
                            <h5>Pengadaan</h5>
                            <strong>Rp{{ number_format($pengadaan_jasa + $pengadaan_material, 0, ',', '.') }}</strong>
                        </div>
                        <div>
                            <strong>Jasa</strong><br>
                            <small>Rp{{ number_format($pengadaan_jasa, 0, ',', '.') }}</small>
                        </div>
                        <div>
                            <strong>Material</strong><br>
                            <small>Rp{{ number_format($pengadaan_material, 0, ',', '.') }}</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-2 mb-3">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="mb-2">
                            <h5>Kontrak</h5>
                            <strong>Rp{{ number_format($kontrak_jasa + $kontrak_material, 0, ',', '.') }}</strong>
                        </div>
                        <div>
                            <strong>Jasa</strong><br>
                            <small>Rp{{ number_format($kontrak_jasa, 0, ',', '.') }}</small>
                        </div>
                        <div>
                            <strong>Material</strong><br>
                            <small>Rp{{ number_format($kontrak_material, 0, ',', '.') }}</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-2 mb-3">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="mb-2">
                            <h5>Pelaksanaan</h5>
                            <strong>Rp{{ number_format($pelaksanaan_jasa + $pelaksanaan_material, 0, ',', '.') }}</strong>
                        </div>
                        <div>
                            <strong>Jasa</strong><br>
                            <small>Rp{{ number_format($pelaksanaan_jasa, 0, ',', '.') }}</small>
                        </div>
                        <div>
                            <strong>Material</strong><br>
                            <small>Rp{{ number_format($pelaksanaan_material, 0, ',', '.') }}</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-2 mb-3">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="mb-2">
                            <h5>Pembayaran</h5>
                            <strong>Rp{{ number_format($pembayaran, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5>Persentasi Kontrak/SKKI</h5>
                        <div class="d-flex flex-row">
                            <div class="flex-fill">
                                <h3>
                                {{ number_format(@($kontrak_total/$skki_total)*100, 2, ',', '.') }}%
                                </h3>
                                Rp{{ number_format($kontrak_total, 0, ',', '.') }}/Rp{{ number_format($skki_total, 0, ',', '.') }}
                            </div>
                            <div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5>Persentasi Bayar/SKKI</h5>
                        <div class="d-flex flex-row">
                            <div class="flex-fill">
                                <h3>
                                {{ number_format(@($pembayaran/$skki_total)*100, 2, ',', '.') }}%
                                </h3>
                                Rp{{ number_format($pembayaran, 0, ',', '.') }}/Rp{{ number_format($skki_total, 0, ',', '.') }}
                            </div>
                            <div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5>Persentasi Bayar/Kontrak</h5>
                        <div class="d-flex flex-row">
                            <div class="flex-fill">
                                <h3>
                                {{ number_format(@($pembayaran/$kontrak_total)*100, 2, ',', '.') }}%
                                </h3>
                                Rp{{ number_format($pembayaran, 0, ',', '.') }}/Rp{{ number_format($kontrak_total, 0, ',', '.') }}
                            </div>
                            <div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5>Biaya Proyek</h5>
                <div id="chart"></div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    var options = {
            series: [{
                name: 'Jasa',
                data: [{{ $prk_jasa }}, {{ $skki_jasa }}, {{ $pengadaan_jasa }}, {{ $kontrak_jasa }}, {{ $pelaksanaan_jasa }}]
            }, {
                name: 'Material',
                data: [{{ $prk_material }}, {{ $skki_material }}, {{ $pengadaan_material }}, {{ $kontrak_material }}, {{ $pelaksanaan_material }}]
            }, {
                name: 'Total',
                data: [{{ $prk_total }}, {{ $skki_total }}, {{ $pengadaan_total }}, {{ $kontrak_total }}, {{ $pelaksanaan_total }}]
            }],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: ['PRK', 'SKKI', 'Pengadaan', 'Kontrak', 'Pelaksanaan'],
            },
            yaxis: {
                title: {
                    text: 'Rp'
                },
                labels: {
                    formatter: function (value) {
                        return new Intl.NumberFormat('id-ID').format(value);
                    }
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                    return "Rp " + new Intl.NumberFormat('id-ID').format(val)
                    }
                }
            }
        };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>
@endsection