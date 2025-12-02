<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setoran extends Model
{
    protected $table = 'setoran';
    protected $primaryKey = 'ID_Transaksi';
    public $timestamps = false;

    protected $fillable = [
        'group_id',
        'Id_nasabah',
        'Tgl_Penjualan',
        'id_jenis',
        'total_berat',
        'total_harga'
    ];

    protected $casts = [
        'Tgl_Penjualan' => 'date',
    ];

    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class, 'Id_nasabah', 'ID_Nasabah');
    }

    public function jenis()
    {
        return $this->belongsTo(JenisSampah::class, 'id_jenis', 'ID_Jenis');
    }
}
