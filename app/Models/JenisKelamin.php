<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisKelamin extends Model
{
    use HasFactory;

    protected $table = 'jenis_kelamin';
    protected $keyType = 'string';

    protected $fillable = [
        'kode_jns_kelamin',
        'description'
    ];

    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class, 'kode_jns_kelamin', 'kode_jns_kelamin');
    }
}
