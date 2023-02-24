<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Notifications\RegisteredCostumerNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**

* @OA\Post(
* path= "/api/v1/register",
* operationId="storeUser",
* tags={"Autenticación"},
* summary="Registro de usuarios",
* description=" Ingrese la información a registrar",
*      @OA\RequestBody(
*          @OA\JsonContent(),
*          @OA\MediaType(
*              mediaType="multipart/form-data",
*            @OA\Schema(
*               type="object",
*               required={"first_name", "last_name","email","password", "password_confirmation"},
*               @OA\Property(property="first_name", type="string"),
*               @OA\Property(property="last_name", type="string"),
*               @OA\Property(property="email", type="string"),
*               @OA\Property(property="password", type="password"),
*               @OA\Property(property="password_confirmation", type="password"),
*            ),
*        ),
*    ),
*      @OA\Response(
*          response=201,
*          description="Register Successfully",
*          @OA\JsonContent()
*       ),
*      @OA\Response(
*          response=200,
*          description="Register Successfully",
*          @OA\JsonContent()
*       ),
*      @OA\Response(
*          response=422,
*          description="Unprocessable Entity",
*          @OA\JsonContent()
*       ),
*      @OA\Response(response=400, description="Bad request"),
*      @OA\Response(response=404, description="Resource Not Found"),
* )
*/
    // Crear un nuevo usuario cliente
    public function registro(Request $request)
    {
        // Validación de los datos de entrada
        $request->validate([
            'first_name' => ['required', 'string', 'min:3', 'max:35'],
            'last_name' => ['required', 'string', 'min:3', 'max:35'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        // Validación de los datos de entrada
        $validated = $request->validate([
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::defaults()->mixedCase()->numbers()->symbols()
            ]
        ]);

        // Obtiene el rol del usuario cliente
        $role = Role::where('name', 'student')->first();

        // Crear una instancia del usuario cliente
        $user = new User($request->all());

        // Se setea el paasword al usuario
        $user->password = Hash::make($validated['password']);

        // Se almacena el usuario en la BD
        $role->users()->save($user);


        // Invoca el controlador padre para la respuesta json
        return $this->sendResponse(
        message: 'Usuario registrado satisfactoriamente',
        result: $user,
        code: 201
        );
    }

        //FUNCION PARA VER LOS USUARIOS
        public function index_usuario (){

            $users= User::all();
            // $user = Auth::user();
            return $this->sendResponse(message: 'lista',result:[
                'users' => UserResource::collection($users)
            ]);
 
        
        }

    //FUNCION PARA VER UN USUARIO
        public function show_usuario ($id){

            $usuarios = User::find($id);
            $user = Auth::user();
            if($usuarios){
                return response()->json([
                    'mesagge' => 'Usuario a vizualizarse',
                    'data'=> $usuarios,
                    'avatar' => $user->getAvatarPath()
        
                ]);
            }else{
                return response()->json([
                    'message' => 'No existe ninguna carrera con ese id.',

        
                ], 404);

            }
        }
}
