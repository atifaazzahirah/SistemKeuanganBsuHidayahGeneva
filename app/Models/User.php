<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'User';
    protected $primaryKey = 'ID_User';
    public $timestamps = false;

    protected $fillable = ['Username', 'Email', 'Password', 'Role'];

    protected $hidden = ['Password', 'remember_token'];

    // Hash password otomatis
    public function setPasswordAttribute($password)
    {
        // Biar tidak double-hash ketika update
        if (!empty($password) && !str_starts_with($password, '$2y$')) {
            $this->attributes['Password'] = bcrypt($password);
        } else {
            $this->attributes['Password'] = $password;
        }
    }

    // Karena nama kolom di DB 'Password' (P besar), override ini
    public function getAuthPassword()
    {
        return $this->Password;
    }
}
