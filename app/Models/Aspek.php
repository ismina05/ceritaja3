<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Aspek extends Model
{
    protected $table = 'aspeks';

    protected $fillable = [
        'nama_aspek',
        'warna'
    ];

    public function refleksis()
    {
        return $this->hasMany(Refleksi::class);
    }
}