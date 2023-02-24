<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // Relación de uno a muchos
    // Un rol puede tener muchos usuarios
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Relación de uno a muchos
    // Un usuario puede realizar muchos reportes
    // public function reports()
    // {
    //     return $this->hasMany(Report::class);
    // }

    // Relación de muchos a muchos
    // Un usuario puede estar en varios pabellones
    // public function wards()
    // {
    //     return $this->belongsToMany(Ward::class)->withTimestamps();
    // }

    // Relación de muchos a muchos
    // Un usuario puede estar en varias cárceles
    // public function jails()
    // {
    //     return $this->belongsToMany(Jail::class)->withTimestamps();
    // }

    // Relación polimórfica uno a uno
    // Un usuario pueden tener una imagen
    // public function image()
    // {
    //     return $this->morphOne(Image::class, 'imageable');
    // }
}
