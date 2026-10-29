@extends('layouts.app')

@section('title', 'Pilih Kelas & Absensi')

@section('styles')
<style>
    :root{--bg1:#eef2ff;--bg2:#f8fafc;--card:#ffffff}
    @media(prefers-color-scheme:dark){
        :root{--bg1:#020617;--bg2:#020617;--card:#111827}
        body{color:#e5e7eb}.card{background:var(--card)}.table{color:#e5e7eb}
    }
    body {
        font-family: "Poppins", sans-serif;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding-top: 80px;
        background: url("{{ asset('foto sekolah 1.jpg') }}") no-repeat center center;
        background-size: cover;
    }

    .app-navbar {
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 70px;
        background: #9e9e9f65;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 40px;
        z-index: 100;
        box-shadow: 0 2px 10px rgba(0,0,0,0.4);
    }

    .nav-left { display: flex; align-items: center; gap: 15px; }
    .nav-left img { height: 45px; }
    .nav-left span { font-size: 18px; font-weight: 600; color: #ffffff; }

    @media (max-width: 768px) {
        .app-navbar { padding: 0 20px; }
        .nav-left span { font-size: 16px; }
    }

    .profile-header {
        background: rgb(10, 30, 213);
        backdrop-filter: blur(20px);
        border-radius: 18px;
    }

    .profile-header::before {
        content: "";
        position: absolute;
        inset: 0;
        backdrop-filter: blur(20px);
        background: rgba(0, 26, 255, 0.2);
    }

    .profile-header * { position: relative; z-index: 2; }

    @keyframes bgFlow{from{background-position:0% 0%}to{background-position:100% 100%}}
    .Btn{width:58px;height:42px;border-radius:8px;border:2px solid #bbb;background:#fff;font-weight:700;transition:.2s}
    .Btn.hadir.active{background:#2ecc71;color:#fff;border-color:#27ae60}
    .Btn.izin.active{background:#f1c40f;color:#000;border-color:#d4ac0d}
    .Btn.sakit.active{background:#3498db;color:#fff;border-color:#2e86c1}
    .Btn.alfa.active{background:#e74c3c;color:#fff;border-color:#c0392b}
    .tr-default td{background:#f1f3f5!important;color:#495057}
    .tr-hadir td{background:#dff5ea!important;color:#0f5132}
    .tr-izin td{background:#fff0c2!important;color:#664d03}
    .tr-sakit td{background:#e2efff!important;color:#084298}
    .tr-alfa td{background:#fde2e1!important;color:#842029}
    .sticky-header{position:sticky;top:0;z-index:10}
</style>
@endsection

@section('content')
<nav class="app-navbar">
    <div class="nav-left">
        <img src="{{ asset('smk.png') }}" alt="Logo Sekolah">
        <span>SMK AL-FALAH NAGREG</span>
    </div>
</nav>

<div class="container my-4">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- PROFIL GURU -->
    <div class="card shadow-lg rounded-4 mb-4 overflow-hidden">
        <div class="profile-header p-4 text-white">
            <div class="d-flex align-items-center gap-3">
                <img src="{{ asset('uploads/guru/' . ($guru->foto ?: 'default.png')) }}"
                     class="rounded-circle border border-3 border-white"
                     style="width:80px;height:80px;object-fit:cover">
                <div>
                    <h5 class="mb-1 fw-bold">{{ $guru->nama }}</h5>
                    <span class="badge bg-light text-primary">{{ $guru->mapel ?: 'Belum diatur' }}</span>
                </div>
            </div>
        </div>
        <div class="card-body bg-white d-flex justify-content-between align-items-center">
            <div class="small text-muted">
                <i class="fa-solid fa-user"></i> Akun Username Aktif
            </div>
            <a href="{{ route('logout') }}" class="btn btn-danger btn-sm"
               onclick="return confirm('Yakin ingin logout?')">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </a>
        </div>
    </div>

    <!-- PILIH KELAS -->
    <div class="card shadow rounded-4 mb-4">
        <div class="card-header bg-primary text-white text-center">
            <h4>Pilih Kelas</h4>
        </div>
        <div class="card-body">
            <form method="get" class="text-center">
                <select name="id_kelas"
                    class="form-select w-100 mb-3 pilih-kelas"
                    onchange="this.form.submit()"
                    required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id }}" {{ $k->id == $id_kelas ? 'selected' : '' }}>
                            {{ strtoupper($k->nama_kelas) }}
                        </option>
                    @endforeach
                </select>
            </form>

            <a href="{{ route('rekap.index', ['id_kelas' => $id_kelas]) }}" class="btn btn-outline-primary w-100">
                <i class="fa-solid fa-chart-bar"></i> Lihat Rekap Absensi
            </a>
        </div>
    </div>

    <!-- ABSENSI -->
    @if($id_kelas && $siswaList->count() > 0)
    <div class="card shadow rounded-4">
        <div class="card-header bg-success text-white sticky-header">
            <div class="d-flex justify-content-between align-items-center gap-2">
                <strong>Absensi Siswa</strong>
                <div class="d-flex gap-2">
                    <span class="badge bg-success">Hadir <span id="cH">0</span></span>
                    <span class="badge bg-warning text-dark">Izin <span id="cI">0</span></span>
                    <span class="badge bg-primary">Sakit <span id="cS">0</span></span>
                    <span class="badge bg-danger">Alfa <span id="cA">0</span></span>
                </div>
                <button type="button" class="btn btn-light btn-sm" onclick="hadirSemua()">Hadir Semua</button>
            </div>
            <div class="progress mt-2" style="height:6px">
                <div id="progressBar" class="progress-bar bg-light" style="width:0%"></div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('absensi.store') }}" method="post" onsubmit="return validateAbsen()">
                @csrf
                <table class="table table-bordered text-center align-middle">
                    <tr><th>No</th><th>Nama</th><th>Status</th></tr>
                    @php $no = 1; @endphp
                    @foreach($siswaList as $s)
                    <tr id="row{{ $s->id }}" class="tr-default">
                        <td>{{ $no++ }}</td>
                        <td class="text-start">{{ $s->nama }}</td>
                        <td>
                            <input type="hidden" name="id_siswa[]" value="{{ $s->id }}">
                            <input type="hidden" name="status[]" id="status{{ $s->id }}">
                            <div class="d-flex gap-2 justify-content-center">
                                <button type="button" class="Btn hadir" onclick="setStatus({{ $s->id }},'Hadir',this)">H</button>
                                <button type="button" class="Btn izin" onclick="setStatus({{ $s->id }},'Izin',this)">I</button>
                                <button type="button" class="Btn sakit" onclick="setStatus({{ $s->id }},'Sakit',this)">S</button>
                                <button type="button" class="Btn alfa" onclick="setStatus({{ $s->id }},'Alfa',this)">A</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </table>

                <button id="btnSave" class="btn btn-success w-100 mt-3" disabled>Simpan Absensi</button>
            </form>
        </div>
    </div>
    @endif

</div>

@endsection

@section('scripts')
<script>
const total = {{ $total }};
function setStatus(id, status, btn) {
    document.getElementById('status' + id).value = status;
    btn.parentElement.querySelectorAll('.Btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    let row = document.getElementById('row' + id);
    row.className = (status == 'Hadir' ? 'tr-hadir' : status == 'Izin' ? 'tr-izin' : status == 'Sakit' ? 'tr-sakit' : 'tr-alfa');
    update();
}
function hadirSemua() {
    document.querySelectorAll('[id^=status]').forEach(s => {
        s.value = 'Hadir';
        let id = s.id.replace('status', '');
        document.getElementById('row' + id).className = 'tr-hadir';
        document.querySelector('#row' + id + ' .hadir').classList.add('active');
    });
    update();
}
function update() {
    let H = 0, I = 0, S = 0, A = 0, done = 0;
    document.querySelectorAll('[id^=status]').forEach(s => {
        if (s.value) done++;
        if (s.value == 'Hadir') H++;
        if (s.value == 'Izin') I++;
        if (s.value == 'Sakit') S++;
        if (s.value == 'Alfa') A++;
    });
    cH.textContent = H;
    cI.textContent = I;
    cS.textContent = S;
    cA.textContent = A;
    progressBar.style.width = ((done / total) * 100) + '%';
    btnSave.disabled = (done != total);
}
function validateAbsen() {
    if (btnSave.disabled) { alert('Masih ada siswa yang belum diabsen!'); return false; }
    return true;
}
</script>
@endsection
