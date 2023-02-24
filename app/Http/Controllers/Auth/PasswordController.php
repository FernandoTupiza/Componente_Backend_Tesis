<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordValidator;
use Illuminate\Auth\Events\PasswordReset;


class PasswordController extends Controller
{
        /**
     * @OA\Post(
     *     path="/api/v1/forgot-password",
     *     tags={"Autenticación"},
     *     summary="Envio de correo para restablecer la contraseña",
     *     operationId="sendResetLinkEmail",
     *     description="Ingrese el correo electronico",
     *     @OA\RequestBody(
     *          @OA\JsonContent(),
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *              type="object",
     *              required={"email"},
     *              @OA\Property(property="email", type="email"),
     *
     *            ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent()
     *     )
     * )
     */

    // Función para el manejo del reseteo de contraseña
    public function resendLink(Request $request)
    {
        // Validación de los datos de entrada
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // enviar el link de restablecimiento de contraseña al mail
        // https://laravel.com/docs/9.x/passwords#requesting-the-password-reset-link
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Se invoca a la función padre
        return $status === Password::RESET_LINK_SENT
            ? $this->sendResponse(__($status))
            : $this->sendResponse(
                message: 'Error de restablecimiento de enlace.',
                errors: ['email' => __($status)],
                code: 422
            );
    }
    /**
     * @OA\Post(
     *     path="/api/v1/reset-password",
     * tags={"Autenticación"},
     *     summary="Restablecer contraseña.",
     *     operationId="reset",
     *     description="Ingrese los nuevos datos",
     *     @OA\RequestBody(
     *          @OA\JsonContent(),
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *              type="object",
     *              required={"email", "password", "password_confirmation", "token"},
     *              @OA\Property(property="email", type="email"),
     *              @OA\Property(property="password", type="password"),
     *              @OA\Property(property="password_confirmation", type="password"),
     *              @OA\Property(property="token", type="string"),
     *
     *            ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent()
     *     )
     * )
     */


    // Función para enviar el redirect del formulario para restablecer la contraseña
    public function redirectReset(Request $request)
    {
        $frontend_url = env('APP_FRONTEND_URL');
        $token = $request->route('token');
        $email = $request->email;
        $url = "$frontend_url/?token=$token&email=$email";
        return redirect($url);
    }

    // Función para la actualización del password
    public function restore(Request $request)
    {
        // Validación de los datos de entrada
        $validated = $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'string', 'email'],
            // https://laravel.com/docs/9.x/validation#rule-confirmed
            'password' => [
                'required', 'string', 'confirmed',
                PasswordValidator::defaults()->mixedCase()->numbers()->symbols(),
            ],
        ]);

        // Función para cambiar el password
        $status = Password::reset($validated, function ($user, $password) {
            // Establece el nuevo password
            $user->password = Hash::make($password);
            // Grabar los cambios
            $user->save();
            // https://laravel.com/docs/9.x/passwords#password-reset-handling-the-form-submission
            event(new PasswordReset($user)); // Actualizar la contraseña en tiempo real
        });

        // Se invoca a la función padre
        return $status == Password::PASSWORD_RESET
            ? $this->sendResponse(__($status))
            : $this->sendResponse(
                message: 'Error al restablecer la contraseña.',
                errors: ['email' => __($status)],
                code: 422
            );
    }


    // Función para actualizar el password del suuario
    public function update(Request $request)
    {
        // Validación de los datos de entrada
        $validated = $request->validate([
            'password' => [
                'required', 'string', 'confirmed',
                PasswordValidator::defaults()->mixedCase()->numbers()->symbols()
            ]
        ]);
        $user = $request->user();
        $user->password = Hash::make($validated['password']);
        $user->save();
        return $this->sendResponse('Constraseña autualizada satisfactoriamente');
    }
}
