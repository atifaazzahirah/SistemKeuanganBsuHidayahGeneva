<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nasabah extends Model
{
    use HasFactory;

    protected $table = 'nasabah';
    public $timestamps = true;
    protected $primaryKey = 'ID_Nasabah';


    protected $fillable = [
        'Nama',
        'No_Induk',
        'Alamat',
        'No_HP',
        'Total_Saldo',
        'jml_kk',
        
    ];
}
