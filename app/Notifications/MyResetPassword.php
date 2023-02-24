<?php

// namespace App\Notifications;

// use Illuminate\Auth\Notifications\ResetPassword;
// use Illuminate\Notifications\Messages\MailMessage;

// class MyResetPassword extends ResetPassword
// {
//     public function toMail($notifiable)
//     {
//         return (new MailMessage)
//             ->subject('Recuperar contraseña')
//             ->greeting('Bienvenido a la gestion de restablecimiento de contraseñas del Sistems Web "Edupoli"')
//             ->line('Estás recibiendo este correo porque hiciste una solicitud de recuperación de contraseñas.')
//             ->action('Recuperar contraseña', route('password.reset', $this->token))
//             ->line('Si no realizaste esta solicitud, no se requiere realizar ninguna otra acción.')
//             ->salutation('Saludos, '. config('app.name'));
//     }
// }