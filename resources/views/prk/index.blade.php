@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>PRK</h3>
                <p class="text-subtitle text-muted">List project dalam tahap PRK</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Table</li>
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
                    @can('edit prk')
                    <a href="/prk/baru?basket=1" class="btn btn-primary">Baru</a>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basket1" class="table table-striped" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Nama Project</th>
                                    <th>Nomor PRK</th>
                                    <th>RAB Jasa</th>
                                    <th>RAB Material</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($result['basket_1'] as $prk)
                                <tr>
                                    <td>
                                        <a href="/prk/{{ $prk->id }}">{{ $prk->nama ?? 'untitled' }}</a>
                                    </td>
                                    <td>{{ $prk->prk }}</td>
                                    <td>Rp{{ number_format(collect($prk->jasas)->sum('harga'), 0, ',', '.') }}</td>
                                    <td>Rp{{ number_format(collect($prk->materials)->map(function ($item){return $item->jumlah*$item->harga;} )->sum(), 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="card">
            <div class="card-content">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">Basket 2</h4>
                    @can('edit prk')
                    <a href="/prk/baru?basket=2" class="btn btn-primary">Baru</a>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basket2" class="table table-striped" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Nama Project</th>
                                    <th>Nomor PRK</th>
                                    <th>RAB Jasa</th>
                                    <th>RAB Material</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($result['basket_2'] as $prk)
                                <tr>
                                    <td>
                                        <a href="/prk/{{ $prk->id }}">{{ $prk->nama ?? 'untitled' }}</a>
                                    </td>
                                    <td>{{ $prk->prk }}</td>
                                    <td>Rp{{ number_format(collect($prk->jasas)->sum('harga'), 0, ',', '.') }}</td>
                                    <td>Rp{{ number_format(collect($prk->materials)->map(function ($item){return $item->jumlah*$item->harga;} )->sum(), 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="card">
            <div class="card-content">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">Basket 3</h4>
                    @can('edit prk')
                    <a href="/prk/baru?basket=3" class="btn btn-primary">Baru</a>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basket3" class="table table-striped" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Nama Project</th>
                                    <th>Nomor PRK</th>
                                    <th>RAB Jasa</th>
                                    <th>RAB Material</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($result['basket_3'] as $prk)
                                <tr>
                                    <td>
                                        <a href="/prk/{{ $prk->id }}">{{ $prk->nama ?? 'untitled' }}</a>
                                    </td>
                                    <td>{{ $prk->prk }}</td>
                                    <td>Rp{{ number_format(collect($prk->jasas)->sum('harga'), 0, ',', '.') }}</td>
                                    <td>Rp{{ number_format(collect($prk->materials)->map(function ($item){return $item->jumlah*$item->harga;} )->sum(), 0, ',', '.') }}</td>
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
        $('#basket1').DataTable();
        $('#basket2').DataTable();
        $('#basket3').DataTable();
    });
</script>
@endsection