@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>SKKI</h3>
                <p class="text-subtitle text-muted">List project dalam tahap SKKI</p>
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
    @can('edit skki')<div class="mb-4 d-flex justify-content-end">
        <button id="import" class="btn btn-success">Import dari excel</button>
    </div>@endcan
    <!-- Basket 1 -->
    <section class="section">
        <div class="card">
            <div class="card-content">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">Basket 1</h4>
                    @can('edit skki')
                    <a href="/skki/baru?basket=1" class="btn btn-primary">Baru</a>
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
                                @foreach($result['basket_1'] as $skki)
                                <tr>
                                    <td>
                                        <a href="/skki/{{ $skki->id }}">{{ $skki->skki ?? 'untitled' }}</a>
                                    </td>
                                    <td>{{ $skki->prk_id ? $skki->prk->prk : '' }}</td>
                                    <td>Rp{{ number_format(collect($skki->jasas)->sum('harga'), 0, ',', '.') }}</td>
                                    <td>Rp{{ number_format(collect($skki->materials)->map(function ($item){ return $item->jumlah * $item->harga; })->sum(), 0, ',', '.') }}</td>
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
                    @can('edit skki')
                    <a href="/skki/baru?basket=2" class="btn btn-primary">Baru</a>
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
                                @foreach($result['basket_2'] as $skki)
                                <tr>
                                    <td>
                                        <a href="/skki/{{ $skki->id }}">{{ $skki->skki ?? 'untitled' }}</a>
                                    </td>
                                    <td>{{ $skki->prk_id ? $skki->prk->prk : '' }}</td>
                                    <td>Rp{{ number_format(collect($skki->jasas)->sum('harga'), 0, ',', '.') }}</td>
                                    <td>Rp{{ number_format(collect($skki->materials)->map(function ($item){ return $item->jumlah * $item->harga; })->sum(), 0, ',', '.') }}</td>
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
                    @can('edit skki')
                    <a href="/skki/baru?basket=3" class="btn btn-primary">Baru</a>
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
                                @foreach($result['basket_3'] as $skki)
                                <tr>
                                    <td>
                                        <a href="/skki/{{ $skki->id }}">{{ $skki->skki ?? 'untitled' }}</a>
                                    </td>
                                    <td>{{ $skki->prk_id ? $skki->prk->prk : '' }}</td>
                                    <td>Rp{{ number_format(collect($skki->jasas)->sum('harga'), 0, ',', '.') }}</td>
                                    <td>Rp{{ number_format(collect($skki->materials)->map(function ($item){ return $item->jumlah * $item->harga; })->sum(), 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="importModal" class="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="mb-4">Import dari Excel</h5>
                    <form action="/skki/import" method="POST" class="mb-4" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="">File</label>
                            <input type="file" class="form-control" name="file"  accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required>
                            <small>Template import SKKI dapat didownload <a href="/assets/template/import_skki_template.xlsx" target="_blank">disini</a>.</small>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Import</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        $('#basket1').DataTable();
        $('#basket2').DataTable();
        $('#basket3').DataTable();
    });
    $('#import').on('click', function() {
        $('#importModal').modal('show')
    })
</script>
@endsection