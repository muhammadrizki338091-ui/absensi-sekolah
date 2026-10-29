<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekapController extends Controller
{
    public function index(Request $request)
    {
        $kelasList = Kelas::orderBy('nama_kelas')->get();

        $id_kelas = $request->query('id_kelas', '');
        $tanggal = $request->query('tanggal', '');

        $absensiList = Absensi::query()
            ->when($id_kelas, function ($q) use ($id_kelas) {
                $q->whereHas('siswa', function ($q) use ($id_kelas) {
                    $q->where('id_kelas', $id_kelas);
                });
            })
            ->where('tanggal', $tanggal)
            ->with('siswa')
            ->get();

        return view('rekap.index', compact(
            'kelasList',
            'id_kelas',
            'tanggal',
            'absensiList'
        ));
    }

    public function edit(Request $request)
    {
        $absensi = Absensi::with('siswa')->findOrFail($request->query('id'));
        $id_kelas = $request->query('id_kelas', '');
        $tanggal = $request->query('tanggal', '');

        return view('rekap.edit', compact('absensi', 'id_kelas', 'tanggal'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id'       => 'required',
            'status'   => 'required|in:Hadir,Izin,Sakit,Alfa',
            'id_kelas' => 'required',
            'tanggal'  => 'required',
        ]);

        $absensi = Absensi::findOrFail($request->id);
        $absensi->update(['status' => $request->status]);

        return redirect()->route('rekap.index', [
            'id_kelas' => $request->id_kelas,
            'tanggal'  => $request->tanggal,
        ])->with('success', 'Status absensi berhasil diubah!');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id_kelas' => 'required',
            'tanggal'  => 'required',
        ]);

        $siswaIds = Siswa::where('id_kelas', $request->id_kelas)->pluck('id');
        Absensi::whereIn('id_siswa', $siswaIds)
            ->where('tanggal', $request->tanggal)
            ->delete();

        return redirect()->route('rekap.index', [
            'id_kelas' => $request->id_kelas,
            'tanggal'  => $request->tanggal,
        ])->with('success', 'Data absensi berhasil dihapus!');
    }

    public function cetakPdf(Request $request)
    {
        $id_kelas = $request->query('id_kelas');
        $tanggal = $request->query('tanggal');

        $absensiList = Absensi::whereHas('siswa', function ($q) use ($id_kelas) {
            $q->where('id_kelas', $id_kelas);
        })
        ->where('tanggal', $tanggal)
        ->with('siswa')
        ->get();

        $kelas = Kelas::find($id_kelas);

        return view('rekap.cetak_pdf', compact('absensiList', 'kelas', 'tanggal'));
    }
}
