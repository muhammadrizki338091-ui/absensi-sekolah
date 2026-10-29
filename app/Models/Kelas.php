<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nama_kelas'])]
class Kelas extends Model
{
    protected $table = 'kelas';

    public function siswa(): HasMany
    {
        return $this->hasMany(Siswa::class, 'id_kelas');
    }
}
