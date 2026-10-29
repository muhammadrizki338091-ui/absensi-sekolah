<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Data Guru
        Guru::create([
            'nama' => 'Administrator',
            'username' => 'admin',
            'password' => bcrypt('admin@smk'),
            'mapel' => 'Kantor TU',
            'foto' => 'eski1.jpg',
        ]);

        // Data Kelas
        $kelasNames = [
            'X PPLG 1',
            'XI PPLG 2',
            'XII PPLG 3',
            'X DKV 1',
            'XI DKV 2',
            'XII DKV 3',
        ];

        foreach ($kelasNames as $nama) {
            Kelas::create(['nama_kelas' => $nama]);
        }

        // Data Siswa (untuk kelas XII PPLG 3 = id 3)
        Siswa::create([
            'id_kelas' => 3,
            'nama' => 'MUHAMMAD RIZKI ESKI PRATAMA 1',
            'nis' => '10001',
        ]);
        Siswa::create([
            'id_kelas' => 3,
            'nama' => 'FAUZI RIFA RIZKYDESTIAN 2',
            'nis' => '10002',
        ]);
        Siswa::create([
            'id_kelas' => 3,
            'nama' => 'ALDI SURYA FAKHREZI 3',
            'nis' => '20001',
        ]);
        Siswa::create([
            'id_kelas' => 3,
            'nama' => 'JAWAHIR NAUFAL WAFA 4',
            'nis' => '30001',
        ]);
    }
}
