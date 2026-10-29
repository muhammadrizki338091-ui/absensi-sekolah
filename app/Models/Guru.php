<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nama', 'username', 'password', 'mapel', 'foto'])]
#[Hidden(['password'])]
class Guru extends Model
{
    protected $table = 'guru';

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function kelas(): HasMany
    {
        return $this->hasMany(Siswa::class);
    }
}
