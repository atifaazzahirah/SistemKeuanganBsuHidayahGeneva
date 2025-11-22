<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSampah extends Model
{
    use HasFactory;

    protected $table = 'jenis_sampah';
    public $timestamps = false;
    protected $primaryKey = 'ID_Jenis';


    protected $fillable = [
        'Jenis_Sampah',
        'Harga_kg',
    ];
}
