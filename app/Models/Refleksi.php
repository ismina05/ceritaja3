<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refleksi extends Model
{
    use HasFactory;

    protected $table = 'refleksis';

    protected $fillable = [
        'user_id',
        'mood_id',
        'kategori_id',
        'aspek_id',
        'judul',
        'isi_refleksi',
        'tanggal'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mood()
    {
        return $this->belongsTo(Mood::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function aspek()
    {
        return $this->belongsTo(Aspek::class);
    }
}