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
        'emosi',
        'mindset',
        'tindakan',
        'tanggal',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}