<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Krs extends Model
{
    use HasFactory;

    protected $table = 'krs';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'm_id',
        'kode_mata_kuliah',
        'sks'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'm_id', 'm_id');
    }

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'kode_mata_kuliah', 'kode_mata_kuliah');
    }
}
