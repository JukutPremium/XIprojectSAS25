<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jurusan extends Model
{
    use HasFactory;

    protected $table = 'jurusans';
    protected $primaryKey = 'id_jurusan';

    protected $fillable = [
        'nama_jurusan',
    ];

    public function kelas(): HasMany
    {
        return $this->hasMany(Kelas::class, 'id_jurusan_kelas', 'id_jurusan');
    }

    public function siswa(): HasMany
    {
        return $this->hasMany(Siswa::class, 'id_jurusan_siswa', 'id_jurusan');
    }
}
