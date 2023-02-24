<?php

namespace App\Http\Controllers\Carreras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Carreras;
use App\Http\Resources\Resource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class CarrerasAdminController extends Controller
{
/**

* @OA\Post(
* path= "/api/v1/carreras/admin",
* operationId="Store Carreras",
* tags={"Gestion Carreras"},
* summary="Ingrese los datos para crear una carrera",
* description="Ingrese los datos requeridos",
*      @OA\RequestBody(
*          @OA\JsonContent(),
*          @OA\MediaType(
*              mediaType="multipart/form-data",
*            @OA\Schema(
*               type="object",
*               required={"nombre", "descripcion", "encargado"},
*               @OA\Property(property="nombre", type="string"),
*               @OA\Property(property="descripcion", type="string"),
*               @OA\Property(property="encargado", type="string"),
*            ),
*        ),
*    ),
*      @OA\Response(
*          response=201,
*          description="Successfully Creation",
*          @OA\JsonContent()
*       ),
*      @OA\Response(
*          response=200,
*          description="Successfully Creation",
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
    //FUNCION PARA CREAR CARRERAS

    public function store_admin(Request $request)
    {
    $response = Gate::inspect('gestion-carreras-admin');

        if($response->allowed())
        {
           
            $rules=array(
                'nombre' => ['required', 'string','unique:carreras', 'min:4', 'max:100'] ,
                'descripcion' => ['required', 'string', 'min:4', 'max:250'],
                'encargado' => ['required', 'string', 'min:4', 'max:10']
            );

            $messages=array(
                'nombre.unique' => 'La carrera debe ser unica',
                'descripcion.required' => 'Debe tener una descripción o exede de la cantidad de caracteres.',
                'encargado.required' => 'Ingrese una persona a cargo.'
            );
            
            $validator=Validator::make($request->all(),$rules,$messages);

            if($validator->fails())
            {
                $messages=$validator->messages();
                return response()->json(["messages"=>$messages], 500);
            }
            
            $carreras = new Carreras();
            $carreras->nombre= $request->nombre;
            $carreras->descripcion = $request->descripcion;
            $carreras->encargado = $request->encargado;
            $carreras->save();

            return response()->json(["carreras" => $carreras, "message"=>"La carrera se ha creado satisfactoriamente"], 200);
        }else{
            echo $response->message();
        }
    }


    
     /**
      * @OA\Get(
        * path= "/api/v1/carreras/adminE",
        * operationId="Carreras Activas",
        * tags={"Gestion Carreras"},
        * summary="Lista de carreras activas",
        * description="Carreras a Visualizar",
        *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )

      */

    //FUNCION PARA VER LAS CARRERAS CREADAS ACTIVAS
        public function index_adminE (){

            $carreras = Carreras::where('estado',1)->get();
            
            return response()->json([
                'data'=> $carreras

            ]);
        }

     /**
      * @OA\Get(
        * path= "/api/v1/carreras/admin",
        * operationId="Carreras Activas e Inativas",
        * tags={"Gestion Carreras"},
        * summary="Lista de carreras activas e inactivas",

        * description="Carreras a visualizar",
        *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )

      */

     //FUNCION PARA VER LAS CARRERAS CREADAS
        public function index_admin (){
            $response = Gate::inspect('gestion-carreras-admin');

            if($response->allowed())
            {
                $carreras = Carreras::all();
                return response()->json([
                    'data'=> $carreras

                ]);

            }else{
                echo $response->message();
            }
        
        }

            /**
     * @OA\Get(
     * path= "/api/v1/carreras/admin/{id}",
     * operationId="Ver carrer por ID",
     * tags={"Gestion Carreras"},
     * summary=" Información de una carrera según su id",
     * description="Retorna la información de una carrera",
     *      @OA\Parameter(
     *          name="id",
     *          description="Ingrese el id de la carrera",
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



    //FUNCION PARA VER UNA CARRERA
        public function show_admin ($id){

            $carreras = Carreras::find($id);
            if($carreras){
                return response()->json([
                    'mesagge' => 'Carrera a vizualizarse',
                    'data'=> $carreras
        
                ]);
            }else{
                return response()->json([
                    'message' => 'No existe ninguna carrera con ese id.',

        
                ], 404);

            }
        }
    /**
     * @OA\Post(
     * path= "/api/v1/carreras/admin/{id}",
     * operationId=" Actualizar Carreras",
     * tags={"Gestion Carreras"},
     * summary="Actualizar la información de una carrera",
     * description=" Actualizar la información de una carrera",
     *      @OA\Parameter(
     *          name="id",
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
        *                 property="encargado",

        *                type="string"
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


    //FUNCION PARA ACTUALIZAR LA CARRERA
        public function update_admin (Request $request, $id){

            $response = Gate::inspect('gestion-carreras-admin');

            if($response->allowed())
            {
                $fields = $request->validate([

                'nombre' => 'nullable|string',
                'descripcion' => 'nullable|string',
                'encargado' => 'nullable|string'

                    
                ]);
                

                $carreras = Carreras::find($id);


                if($carreras){
                    $carreras->update($fields);

                    return response()->json([
                        'message' => 'La carrera se actualizado satisfactoriamente.',
                        'data'=> $carreras
                    ]);
                }
                else{
                    return response()->json([
                        'message'=> 'No existe ninguna carrera con ese id.'
            
                    ], 404);

                }
            }else{
                echo $response->message();
            }

        }

        /**
    * @OA\Get(
    *     path="/api/v1/carreras/desactiva/admin/{carreras}",
    *     summary="Activar e Inactivar Carreras",
    *     tags={"Gestion Carreras"},
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
     //ACTIVAR E INACTIVAR CARRERAS   


        public function destroy_admin (Carreras $carreras){


            // $carreras = Carreras::find($id);
        
            $response = Gate::inspect('gestion-carreras-admin');

            if($response->allowed())
            {
            
                $carreras_estado = $carreras->estado;
                $mensaje = $carreras_estado ? "inactiva.":"activa.";
                $carreras->estado = !$carreras_estado;
                $carreras->save();

                return $this->sendResponse(message: "La carrera esta $mensaje ");
           
            }else{
                echo $response->message();
            }
        }
    
}
