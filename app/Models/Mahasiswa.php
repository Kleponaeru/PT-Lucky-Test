<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';
    protected $fillable = [
        'nim',
        'kode_jenis_kelamin',
        'nama_mahasiswa',
        'jurusan',
        'ipk'
    ];

    // Relationship to gender table
    public function jenisKelamin()
    {
        return $this->belongsTo(JenisKelamin::class, 'kode_jns_kelamin', 'kode_jns_kelamin');
    }

    // Relationship to KRS table
    public function krs()
    {
        return $this->hasMany(Krs::class, 'm_id', 'm_id');
    }
}
