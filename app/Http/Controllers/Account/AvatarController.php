<?php

namespace App\Http\Controllers\Account;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class AvatarController extends Controller
{    
    /**
    * @OA\Post(
    * path= "/api/v1/profile/avatar ",
    * operationId="Actualizar avatar",
    * tags={"Cuenta del perfil"},
    * summary="Actualizar avatar",
    * description="Actualizar avatar",
    *security={
    *  {"passport": {}},
    *   },
    * @OA\RequestBody(
    *         @OA\JsonContent(),
    *       @OA\MediaType(
    *          mediaType="multipart/form-data",
    *         @OA\Schema(
    *            type="object",
    *          required={"image"},
    *         @OA\Property(property="image", type="file"),
    * 
       *         ),
       *       ),
       *     ),
       
    * 
    * 
   *
    *
    *
    *   @OA\Response(
    *      response=200,
    *       description="Success",
    *      @OA\MediaType(
    *           mediaType="application/json",
    *      )
    *   ),
    *   @OA\Response(
    *      response=401,
    *       description="Unauthenticated"
    *   ),
    *   @OA\Response(
    *      response=400,
    *      description="Bad Request"
    *   ),
    *   @OA\Response(
    *      response=404,
    *      description="Not found"
    *   ),
    *      @OA\Response(
    *          response=403,
    *          description="Forbidden"
    *      )
    * )
    **/
    public function store(Request $request)
    {
        // Validación de los datos de entrada
        $request -> validate([
            'image' => ['required', 'image', 'mimes:jpg,png,jpeg', 'max:1000'],
        ]);

        // Se obtiene el usario que esta haciendo el Request
        $user = $request->user();

        // Nos permite subir el avatar hacia Cloudinary.
        $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();


        // Se hace uso del Trait para asociar esta imagen con el modelo user
        $user->attachImage($uploadedFileUrl);
        // Uso de la función padre
        return $this->sendResponse('El Avatar se actualizado satisfactoriamente');

    }
}

