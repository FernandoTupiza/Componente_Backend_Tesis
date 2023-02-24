<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Trait\HasImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\ResetPassword;


class User extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable,HasImage;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'first_name',
    //     'email',
    //     'password',
    // ];

    protected $fillable = [
        'role_id','email', 'first_name','last_name', 'password', 'id',
    ];

     // Logica Resert Password 

     public function sendPasswordResetNotification($token)
     {
         $this->notify(new ResetPassword($token, $this->email));
     }

        /**
     * Send the password reset notification.
     *
     * @param string $token
     * @return void
     */
    // public function sendPasswordResetNotification($token)
    // {
    //     $this->notify(new MyResetPassword($token));
    // }

    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    // Relación de uno a muchos
    // Un usuario le pertenece un rol
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Obtener el nombre completo del usuario
    public function getFullName()
    {
        return "$this->first_name $this->last_name";
    }

    // //Relacion polimorficas uno a uno
    // //Un usuario pueden tener una imagen

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

        // Crear un avatar por default
        public function getDefaultAvatarPath()
        {
            return "https://cdn-icons-png.flaticon.com/512/711/711769.png";
        }
    
        // Obtener la imagen de la BDD
        public function getAvatarPath()
        {
            // se verifica no si existe una iamgen
            if (!$this->image)
            {
                // asignarle el path de una imagen por defecto
                return $this->getDefaultAvatarPath();
            }
            // retornar el path de la imagen registrada en la BDD
            return $this->image->path;
        }
    
    
}
