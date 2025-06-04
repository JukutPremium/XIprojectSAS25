<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswas';
    protected $primaryKey = 'nis_siswa';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nis_siswa',
        'nama_siswa',
        'absen_siswa',
        'id_kelas_siswa',
        'id_jurusan_siswa',
    ];

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'id_kelas_siswa', 'id_kelas');
    }

    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan_siswa', 'id_jurusan');
    }
}
