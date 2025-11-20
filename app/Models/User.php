<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        $this->attributes['Password'] = bcrypt($password);
    }

    // Login pakai kolom Email (bukan username)
    public function getAuthIdentifierName()
    {
        return 'Email';
    }
}