<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{
    /** @use HasFactory<\Database\Factories\PekerjaanFactory> */
    use HasFactory;

    protected $fillable = [
        'nama',
        'min_gaji',
        'max_gaji',
        'max_pekerja',
        'deskripsi',
        'alamat',
        'petunjuk_alamat',
        'koordinat',
        'latitude',
        'longitude',
        'pembuat',
        'start_job',
        'end_job',
        'kriteria',
    ];
    protected $casts = [
        'nama' => 'string',
        'min_gaji' => 'integer',
        'max_gaji' => 'integer',
        'max_pekerja' => 'integer',
        'is_active' => 'integer',
        'pembuat' => 'integer',
        'deskripsi' => 'string',
        'alamat' => 'string',
        'petunjuk_alamat' => 'string',
        'koordinat' => 'string',
        'latitude' => 'string',
        'longitude' => 'string',
    ];

    public function pembuat()
    {
        return $this->belongsTo(Users::class, 'pembuat');
    }

    public function pelamar()
    {
        return $this->belongsToMany(Pekerjaan::class, 'pelamars', 'user_id', 'job_id');
    }
}
