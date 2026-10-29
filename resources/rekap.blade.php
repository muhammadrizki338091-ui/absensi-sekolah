<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Absensi</title>
</head>
<body>

    <h1>Rekap Absensi</h1>

    <p>ID Kelas: {{ $id_kelas }}</p>
    <p>Tanggal: {{ $tanggal }}</p>

    <h3>Daftar Absensi</h3>

    @forelse ($absensiList as $absensi)
        <p>
            {{ $absensi->siswa->nama ?? 'Nama tidak ditemukan' }}
        </p>
    @empty
        <p>Belum ada data absensi.</p>
    @endforelse

</body>
</html>