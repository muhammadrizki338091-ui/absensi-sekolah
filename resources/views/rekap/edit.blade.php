@extends('layouts.app')

@section('title', 'Edit Absensi')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow rounded-4">
                <div class="card-header bg-warning text-dark text-center">
                    <h4><i class="fa-solid fa-pen"></i> Edit Status Absensi</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('rekap.update') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $absensi->id }}">
                        <input type="hidden" name="id_kelas" value="{{ $id_kelas }}">
                        <input type="hidden" name="tanggal" value="{{ $tanggal }}">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Siswa</label>
                            <input type="text" class="form-control" value="{{ $absensi->siswa->nama }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Status Kehadiran</label>
                            <select name="status" class="form-select" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="Hadir" {{ $absensi->status == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                <option value="Izin" {{ $absensi->status == 'Izin' ? 'selected' : '' }}>Izin</option>
                                <option value="Sakit" {{ $absensi->status == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                                <option value="Alfa" {{ $absensi->status == 'Alfa' ? 'selected' : '' }}>Alfa</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                            <a href="{{ route('rekap.index', ['id_kelas' => $id_kelas, 'tanggal' => $tanggal]) }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
