<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak PDF Rekap Absensi</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
        th { background: #333; color: #fff; }
    </style>
</head>
<body>
    <h2>LAPORAN ABSENSI SISWA</h2>
    <p><strong>Kelas:</strong> {{ $kelas->nama_kelas ?? '-' }}</p>
    <p><strong>Tanggal:</strong> {{ $tanggal }}</p>

    <table>
        <tr>
            <th>No</th>
            <th>Nama Siswa</th>
            <th>Status</th>
        </tr>
        @php $no = 1; @endphp
        @foreach($absensiList as $r)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $r->siswa->nama }}</td>
            <td>{{ $r->status }}</td>
        </tr>
        @endforeach
    </table>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
