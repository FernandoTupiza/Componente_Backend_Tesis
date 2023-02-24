<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // Se procede a definir la estructura de la respuesta de la petición
        // https://laravel.com/docs/9.x/eloquent-resources#introduction
        return [
            // 'username' => $this->username,
            'id' => $this->id,
            'role_id' => $this->role_id,
            'full_name' => $this->getFullName(),
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'avatar' =>$this->getAvatarPath(),
            // 'birthdate' => $this->birthdate,
            // 'home_phone' => $this->home_phone,
            // 'personal_phone' => $this->personal_phone,
            // 'address' => $this->address,
        ];
    }
}
