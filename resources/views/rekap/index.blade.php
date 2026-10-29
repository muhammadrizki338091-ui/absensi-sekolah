@extends('layouts.app')

@section('title', 'Rekap Absensi')

@section('styles')
<style>
    body {
        min-height: 100vh;
        margin: 0;
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #ffffffa2 0.5%, #0008ffd5 45%, #006aff 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .app-navbar {
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 70px;
        background: #ffffff13;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 40px;
        z-index: 100;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.49);
    }

    .nav-left { display: flex; align-items: center; gap: 15px; }
    .nav-left img { height: 45px; }
    .nav-left span { font-size: 18px; font-weight: 600; color: #ffffff; }

    .action-bar { display: flex; gap: 12px; align-items: center; }

    .btn-back, .btn-hapus, .btn-print {
        height: 42px;
        padding: 0 18px;
        display: flex;
        align-items: center;
        font-weight: 600;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        white-space: nowrap;
        text-decoration: none;
    }

    .btn-back {
        background: linear-gradient(135deg, #0b3d91 0%, #3b82f6 100%);
        color: #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }

    .btn-hapus {
        background: linear-gradient(135deg, #ff4d4f 0%, #a50d0d 100%);
        color: #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    .btn-print {
        background: linear-gradient(135deg, #0f4d92 0%, #0f766e 100%);
        color: #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }

    @media print {
        .app-navbar, .btn-print, .btn-hapus, .btn-back { display: none !important; }
        body { background: white !important; }
        table { width: 100%; font-size: 12px; }
        th { background: #000 !important; color: #fff !important; }
    }
</style>
@endsection

@section('content')
<nav class="app-navbar">
    <div class="nav-left">
        <img src="{{ asset('smk.png') }}" alt="Logo Sekolah">
        <span>SMK AL-FALAH NAGREG</span>
    </div>
</nav>

<div class="container mt-4">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow rounded-4">
        <div class="card-header bg-primary text-white">
            <h5><i class="fa-solid fa-chart-bar"></i> Rekap Absensi per Kelas & Tanggal</h5>
        </div>
        <div class="card-body">
            <form method="get" class="row g-3">
                <div class="col-md-5">
                    <label class="form-label">Kelas</label>
                    <select name="id_kelas" class="form-select" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id }}" {{ $k->id == $id_kelas ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ $tanggal }}" required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-success w-100">Tampilkan</button>
                </div>
            </form>
        </div>
    </div>

    @if($id_kelas && $tanggal)
    <div class="card shadow rounded-4 mt-4">
        <div class="card-header bg-success text-white">
            Hasil Rekap
        </div>

        <div class="action-bar p-3">
            <a href="{{ route('dashboard') }}" class="btn-back">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>

            <form action="{{ route('rekap.destroy') }}" method="post"
                  onsubmit="return confirm('Yakin hapus data?')">
                @csrf
                <input type="hidden" name="id_kelas" value="{{ $id_kelas }}">
                <input type="hidden" name="tanggal" value="{{ $tanggal }}">
                <button type="submit" class="btn-hapus">
                    <i class="fa-solid fa-trash"></i> Hapus Data
                </button>
            </form>

            <a href="{{ route('rekap.pdf', ['id_kelas' => $id_kelas, 'tanggal' => $tanggal]) }}"
               class="btn-print" target="_blank">
                <i class="fa-solid fa-print"></i> Print PDF
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>

                @if($absensiList->isEmpty())
                    <tr><td colspan="4">Belum ada data absensi</td></tr>
                @else
                    @php $no = 1; @endphp
                    @foreach($absensiList as $r)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $r->siswa->nama }}</td>
                        <td>
                            <span class="badge
                                {{ $r->status == 'Hadir' ? 'bg-success' :
                                   ($r->status == 'Izin' ? 'bg-warning' :
                                   ($r->status == 'Sakit' ? 'bg-info' : 'bg-danger')) }}">
                                {{ $r->status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('rekap.edit', ['id' => $r->id, 'id_kelas' => $id_kelas, 'tanggal' => $tanggal]) }}"
                               class="btn btn-warning btn-sm">
                                <i class="fa-solid fa-pen"></i> Edit
                            </a>
                        </td>
                    </tr>
                    @endforeach
                @endif
            </table>
        </div>
    </div>
    @endif

</div>
@endsection
