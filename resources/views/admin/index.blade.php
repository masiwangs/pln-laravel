@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Daftar Admin</h3>
                <p class="text-subtitle text-muted">List Admin</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="index.html">Administrasi</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Admin Panel</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <h5>Daftar Admin</h5>
                    <div class="table-responsive" style="min-height: 400px">
                        <table id="adminTbl" class="table table-striped" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Terkonfirmasi</th>
                                    <th>Edit PRK</th>
                                    <th>Edit SKKI</th>
                                    <th>Edit Pengadaan</th>
                                    <th>Edit Kontrak</th>
                                    <th>Edit Pelaksanaan</th>
                                    <th>Edit Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                @php
                                $roles = $user->getRoleNames()->toArray();
                                $permissions = $user->getPermissionNames()->toArray();
                                @endphp
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->verified)
                                            <span class="badge bg-success">Terkonfirmasi</span>
                                        @else
                                        <div class="dropdown">
                                            <span class="badge bg-danger" role="button" id="dd-{{ $user->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                Belum terkonfirmasi
                                            </span>
                                            <ul class="dropdown-menu" aria-labelledby="dd-{{ $user->id }}">
                                                <li>
                                                    <form action="/administrasi/user/{{ $user->id }}/confirm" method="POST">
                                                        @csrf
                                                        <button class="dropdown-item">Konfirmasi</button>
                                                    </form>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Hapus</a></li>
                                            </ul>
                                        </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if(in_array('super admin', $roles))
                                        <input class="form-check-input update-role" type="checkbox" data-user-id="{{ $user->id }}" checked disabled data-permission="edit prk">
                                        @else
                                        <input class="form-check-input update-role" type="checkbox" data-user-id="{{ $user->id }}" @if(in_array('edit prk', $permissions)) checked @endif data-permission="edit prk">
                                        @endif
                                    </td>
                                    <td>
                                        @if(in_array('super admin', $roles))
                                        <input class="form-check-input update-role" type="checkbox" data-user-id="{{ $user->id }}" checked disabled data-permission="edit skki">
                                        @else
                                        <input class="form-check-input update-role" type="checkbox" data-user-id="{{ $user->id }}" @if(in_array('edit skki', $permissions)) checked @endif data-permission="edit skki">
                                        @endif
                                    </td>
                                    <td>
                                        @if(in_array('super admin', $roles))
                                        <input class="form-check-input update-role" type="checkbox" data-user-id="{{ $user->id }}" checked disabled data-permission="edit pengadaan">
                                        @else
                                        <input class="form-check-input update-role" type="checkbox" data-user-id="{{ $user->id }}" @if(in_array('edit pengadaan', $permissions)) checked @endif data-permission="edit pengadaan">
                                        @endif
                                    </td>
                                    <td>
                                        @if(in_array('super admin', $roles))
                                        <input class="form-check-input update-role" type="checkbox" data-user-id="{{ $user->id }}" checked disabled data-permission="edit kontrak">
                                        @else
                                        <input class="form-check-input update-role" type="checkbox" data-user-id="{{ $user->id }}" @if(in_array('edit kontrak', $permissions)) checked @endif data-permission="edit kontrak">
                                        @endif
                                    </td>
                                    <td>
                                        @if(in_array('super admin', $roles))
                                        <input class="form-check-input update-role" type="checkbox" data-user-id="{{ $user->id }}" checked disabled data-permission="edit pelaksanaan">
                                        @else
                                        <input class="form-check-input update-role" type="checkbox" data-user-id="{{ $user->id }}" @if(in_array('edit pelaksanaan', $permissions)) checked @endif data-permission="edit pelaksanaan">
                                        @endif
                                    </td>
                                    <td>
                                        @if(in_array('super admin', $roles))
                                        <input class="form-check-input update-role" type="checkbox" data-user-id="{{ $user->id }}" checked disabled data-permission="edit pembayaran">
                                        @else
                                        <input class="form-check-input update-role" type="checkbox" data-user-id="{{ $user->id }}" @if(in_array('edit pembayaran', $permissions)) checked @endif data-permission="edit pembayaran">
                                        @endif
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
    $('#adminTbl').DataTable();
    $('.update-role').on('click', async function() {
        let user_id = $(this).data('user-id');
        let permission = $(this).data('permission')

        let data = {
            permission: permission
        }
        const response = await axios.post(`/administrasi/user/${user_id}/update-role`, data)
        console.log(response.data)
    })
</script>
@endsection