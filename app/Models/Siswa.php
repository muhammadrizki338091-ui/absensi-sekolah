<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['id_kelas', 'nama', 'nis'])]
class Siswa extends Model
{
    protected $table = 'siswa';

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    public function absensi(): HasMany
    {
        return $this->hasMany(Absensi::class, 'id_siswa');
    }
}
