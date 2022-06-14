@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Pelaksanaan</h3>
                <p class="text-subtitle text-muted">List project dalam tahap Pelaksanaan</p>
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
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="prk01" class="table table-striped" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Nomor Kontrak</th>
                                    <th>Tanggal Kontrak</th>
                                    <th>Tanggal Awal</th>
                                    <th>Tanggal Akhir</th>
                                    <th>Pelaksana</th>
                                    <th>Direksi</th>
                                    <th>Progress</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(collect($pelaksanaans)->where('basket', 1) as $pelaksanaan)
                                <tr>
                                    <td>
                                        <a href="/pelaksanaan/{{ $pelaksanaan->id }}">{{ $pelaksanaan->kontrak->nomor_kontrak }}</a>
                                    </td>
                                    <td>{{ \Carbon\Carbon::create($pelaksanaan->kontrak->tgl_kontrak)->format('j M Y') }}</td>
                                    <td>{{ \Carbon\Carbon::create($pelaksanaan->kontrak->tgl_awal)->format('j M Y') }}</td>
                                    <td>{{ \Carbon\Carbon::create($pelaksanaan->kontrak->tgl_akhir)->format('j M Y') }}</td>
                                    <td>{{ \Str::upper($pelaksanaan->kontrak->pelaksana) }}</td>
                                    <td>{{ $pelaksanaan->kontrak->direksi }}</td>
                                    <td>
                                        <div>
                                            <progress value="{{ $pelaksanaan->progress }}" max="100"></progress>
                                        </div>
                                        <small>{{ $pelaksanaan->progress }}%</small>
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
</div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        $('#prk01').DataTable();
    });
</script>
@endsection