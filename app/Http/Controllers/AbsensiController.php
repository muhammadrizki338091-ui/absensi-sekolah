<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_siswa' => 'required|array',
            'status'   => 'required|array',
        ]);

        $tanggal = now()->toDateString();

        $ids = $request->id_siswa;
        $statuses = $request->status;

        for ($i = 0; $i < count($ids); $i++) {
            Absensi::create([
                'id_siswa' => $ids[$i],
                'tanggal'  => $tanggal,
                'status'   => $statuses[$i],
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Absensi berhasil disimpan!');
    }
}
