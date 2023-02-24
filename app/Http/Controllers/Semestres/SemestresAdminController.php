<?php

namespace App\Http\Controllers\Semestres;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Semestres;
use App\Http\Resources\Resource;
use App\Models\Carreras;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Response;


class SemestresAdminController extends Controller
{
/**
 * @OA\Post(
 * path= "/api/v1/semestres/admin/{carreras}",
 * operationId="Crear semestres en relacion a la carrera",
 * tags={"Gestion Semestres"},
 * summary=" Registro para crear un semestre",
 * description="Crea un semestre en relacion a la carrera",
 *      @OA\Parameter(
 *          name="carreras",
 *          description="Ingrese el id de la carrera",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="integer",
 *              format="int64"
 *          )
 *      ),
 *      @OA\RequestBody(
 *          @OA\JsonContent(),
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema(
 *              type="object",
 *             required={"nombre", "descripcion", "path"},
 *             
 *              @OA\Property(
 *                 property="nombre",
 *                type="string"
 *               
 *            ),
 *            @OA\Property(
*                 property="descripcion",

*                type="string"
*              
*            ),
*            @OA\Property(
*                 property="path",

*                type="file"
*              
*            ),
*            ),
*         ),
*     ),
*      @OA\Response(
*          response=200,
*          description="Successful operation",
*          @OA\JsonContent()
*      ),
*      @OA\Response(response=400, description="Bad request"),
*      @OA\Response(response=404, description="Resource Not Found"),
* )
*
*/
    //---------FUNCION PARA CREAR LOS SEMESTRES-------------//
    public function store_admin (Request $request, Carreras $carreras)
    {
        $response = Gate::inspect('gestion-semestres-admin');

        if($response->allowed())
        {
            
        $doc = $request -> validate([
            'nombre' => ['required', 'string', 'min:4', 'max:100'] ,
            'descripcion' => ['required', 'string', 'min:4', 'max:250'],
            'path' => ['required', 'image', 'mimes:jpg,png,jpeg', 'max:1000'],

        ]);

        $doc1 = $doc [ 'path'];
        $uploadedFileUrl = Cloudinary::upload($doc1->getRealPath())->getSecurePath();
        $semestres = new Semestres($request->all());
        $semestres ->carreras_id = $carreras->id;
        $semestres->path= $uploadedFileUrl;


        $semestres->nombre= $request->nombre;
        $semestres->descripcion = $request->descripcion;
        $semestres->save();

        return response()->json(["carreras" => $semestres, "message"=>"El semestre se ha creado satisfactoriamente"], 200);

        }else{
            echo $response->message();
        }

        
    }
         /**
      * @OA\Get(
        * path= "/api/v1/semestres/admin",
        * operationId="Semestres Activas",
        * tags={"Gestion Semestres"},
        * summary="Lista de semestres activos",

        * description="Retorno semestres activos",
        *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )

      */

        //-----------------------------------------------------//

        //-------FUNCION PARA VER LOS SEMESTRES ACTIVOS--------//
        public function index_admin (){

            $semestres = Semestres::where('estado',1)->get();

            return response()->json([
                'data'=> $semestres

            ]);
            

    }
     /**
      * @OA\Get(
        * path= "/api/v1/semestres/adminE",
        * operationId="Semestres Activos e Inativos",
        * tags={"Gestion Semestres"},
        * summary="Lista de carreras activas e inactivas",

        * description="Retorna carreras activas e inactivas",
        *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )

      */



    //-----------------------------------------------------//


    //---FUNCION PARA VER TODOS LOS SEMESTRES CREADOS-----//
    public function index_adminE (){
        $response = Gate::inspect('gestion-semestres-admin');

        if($response->allowed())
        {
            $semestres = Semestres::all();

            return response()->json([
                'data'=> $semestres

            ]);
        }else{
            echo $response->message();
        }
    }
    //-----------------------------------------------------//
            /**
     * @OA\Get(
     * path= "/api/v1/semestres/admin/{id}",
     * operationId="Ver semestres por ID",
     * tags={"Gestion Semestres"},
     * summary=" Información de un semestres según su id",
     * description="Retorna la información de un semestre",
     *      @OA\Parameter(
     *          name="id",
     *          description="Ingrese el id del semestre",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     *
     */

    //FUNCION PARA VER UN SEMESTRE
    public function show_admin ( $id){
        $semestres = Semestres::find($id);
        if($semestres){
            return response()->json([
                'data'=> $semestres

            ]);
        }else{
            return response()->json([
                'message' => 'No existe ningun semestre con ese id.',

    
            ], 404);
        }
    }

    /**
     * @OA\Post(
     * path= "/api/v1/semestres/admin/update/{semestres}",
     * operationId=" Actualizar Semestres",
     * tags={"Gestion Semestres"},
     * summary="Actualizar la información de un semestres",
     * description=" Actualizar la información de una carrera",
     *      @OA\Parameter(
     *          name="semestres",
     *          description="Ingrese el id del semestre",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          @OA\JsonContent(),
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *              type="object",
     *             
     *              @OA\Property(
     *                property="nombre",
     *                type="string"
     *               
     *            ),
     *            @OA\Property(
    *                 property="descripcion",
    *                 type="string"
    *              
    *            ),
    *            @OA\Property(
    *                 property="path",
    *                type="file"
    *              
    *            ),
    *            ),
    *         ),
    *     ),
    *      @OA\Response(
    *          response=200,
    *          description="Successful operation",
    *          @OA\JsonContent()
    *      ),
    *      @OA\Response(
    *          response=422,
    *          description="Unprocessable Entity",
    *          @OA\JsonContent()
    *      ),
    *      @OA\Response(response=400, description="Bad request"),
    *      @OA\Response(response=404, description="Resource Not Found"),
    * )
    *
    */

    //FUNCION PARA ACTUALIZAR LOS SEMESTRES

    public function update_admin(Request $request, Semestres $semestres)
    {
        $response = Gate::inspect('gestion-semestres-admin');

        if($response->allowed())
        {
            $doc=$request -> validate([
            'nombre' => ['string', 'min:4', 'max:100'] ,
            'descripcion' => ['string', 'min:4', 'max:250'],
            'path' => ['nullable','image', 'mimes:jpg,png,jpeg', 'max:1000'],

            ]);
            if($request->has('path')){

                $doc1 = $doc [ 'path'];

                $uploadedFileUrl = Cloudinary::upload($doc1->getRealPath())->getSecurePath();
                $semestres -> update( [
                    'path'  => $uploadedFileUrl,
                ]);
            }
            // Del request se obtiene unicamente los dos campos
            $service_data = $request->only(['nombre','descripcion']);
            $semestres -> update($service_data);
            return $this->sendResponse('El semestre  se ha actualizado satisfactoriamente');
        }else{
            echo $response->message();
        }
    }
        /**
    * @OA\Get(
    *     path="/api/v1/semestres/desactiva/admin/{semestres}",
    *     summary="Activar e Inactivar semestres",
    *     tags={"Gestion Semestres"},
    *      @OA\Parameter(
    *          name="semestres",
    *          description="Ingrese el id del semestre",
    *          required=true,
    *          in="path",
    *          @OA\Schema(
    *              type="integer",
    *              format="int64"
    *          )
    *      ),

    *      @OA\Response(
    *          response=200,
    *          description="Successful operation",
    *          @OA\JsonContent()
    *      ),
    *      @OA\Response(response=400, description="Bad request"),
    *      @OA\Response(response=404, description="Resource Not Found"),
    * )
     *
     */
    //ACTIVAR E INACTIVAR SEMESTRE

    
    public function destroy_admin (Semestres $semestres){


        // $carreras = Carreras::find($id);
        $response = Gate::inspect('gestion-carreras-admin');

        if($response->allowed())
        {
            $semestres_estado = $semestres->estado;
            $mensaje = $semestres_estado ? "Inactiva":"Activa";
            $semestres->estado = !$semestres_estado;
            $semestres->save();

            return $this->sendResponse(message: "El semestres esta $mensaje ");
        }else{
            echo $response->message();
        }
    

    }





}
