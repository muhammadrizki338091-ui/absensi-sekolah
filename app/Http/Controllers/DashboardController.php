<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $kelasList = Kelas::all();
        $id_kelas = $request->query('id_kelas');
        $siswaList = collect();
        $total = 0;

        if ($id_kelas) {
            $siswaList = Siswa::where('id_kelas', $id_kelas)->get();
            $total = $siswaList->count();
        }

        return view('dashboard', compact('kelasList', 'id_kelas', 'siswaList', 'total'));
    }
}
