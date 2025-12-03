<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;

    protected $table = 'mata_kuliah';
    protected $primaryKey = 'kode_mata_kuliah';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_mata_kuliah',
        'nama_mata_kuliah',
        'dosen',
        'jurusan'
    ];

    public function krs()
    {
        return $this->hasMany(Krs::class, 'kode_mata_kuliah', 'kode_mata_kuliah');
    }
}
