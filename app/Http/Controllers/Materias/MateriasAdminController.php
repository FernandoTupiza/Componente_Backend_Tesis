<?php

namespace App\Http\Controllers\Materias;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Materias;
use App\Http\Resources\Resource;
use App\Models\Semestres;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class MateriasAdminController extends Controller
{   
    /**
 * @OA\Post(
 * path= "/api/v1/materias/admin/{semestres}",
 * operationId="Crear materias en relacion al semestres",
 * tags={"Gestion Materias"},
 * summary="Crear una materia",
 * description="Ingrese la informacion para crear una materia",
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
 *      *      @OA\RequestBody(
 *          @OA\JsonContent(),
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema(
 *              type="object",
 *             required={"nombre", "descripcion", "encargado"},
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
*      @OA\Response(response=400, description="Bad request"),
*      @OA\Response(response=404, description="Resource Not Found"),
* )
*
*/
    //FUNCION PARA CREAR MATERIAS
    public function store_admin (Request $request, Semestres $semestres)
    {

        $response = Gate::inspect('gestion-materias-admin');

        if($response->allowed())
        {
        $rules=array(
            'nombre' => ['required', 'string','unique:carreras', 'min:4', 'max:100'] ,
            'descripcion' => ['required', 'string', 'min:4', 'max:250'],
            'encargado' => ['required', 'string', 'min:4', 'max:35']
            );
            $messages=array(
                'nombre.unique' => 'La materia debe ser unica',
                'descripcion.required' => 'Debe tener una descripción.',
                'encargado.required' => 'Ingrese una persona a cargo.',
                // 'password_confirmation.required' => 'Ingrese la confirmación de la contraseña.',

            );
            
            $validator=Validator::make($request->all(),$rules,$messages);
            if($validator->fails())
            {
                $messages=$validator->messages();
                return response()->json(["messages"=>$messages], 500);
            }
            $materias = new Materias($request->all());
            $materias ->semestres_id = $semestres->id;
            // $materias->semestres_id = $request->semestres_id;
            // $materias->nombre= $request->nombre;
            // $materias->descripcion = $request->descripcion;
            // $materias->encargado = $request->encargado;
            // $registro->password_confirmation = $request->password_confirmation;
            $materias->save();
            return response()->json(["materias" => $materias, "message"=>"La materia se ha creado satisfactoriamente"], 200);
        }else{
            echo $response->message();
        }
        }
/**
 * @OA\Get(
* path= "/api/v1/materias/adminE",
* operationId="Materias Activas",
* tags={"Gestion Materias"},
* summary="Lista de materias activas",

* description="Retorno materias activas",
*     @OA\Response(
*          response=200,
*          description="Successful operation",
*          @OA\JsonContent()
*      ),
*      @OA\Response(response=400, description="Bad request"),
*      @OA\Response(response=404, description="Resource Not Found"),
* )

*/

        //FUNCION PARA VER LAS MATERIAS CREADAS ACTIVAS
        public function index_adminE (Request $request){


            $materias = Materias::where('estado',1)->get();
            return response()->json([
                'data'=> $materias
                
            ]);
        }

/**
 * @OA\Get(
* path= "/api/v1/materias/admin",
* operationId="Materias Activas e Inativas",
* tags={"Gestion Materias"},
* summary="Lista de materias activas e inactivas",

* description="Retorno materias activas e inactivas",
*     @OA\Response(
*          response=200,
*          description="Successful operation",
*          @OA\JsonContent()
*      ),
*      @OA\Response(response=400, description="Bad request"),
*      @OA\Response(response=404, description="Resource Not Found"),
* )

*/

        
        
        //FUNCION PARA VER TODAS LA MATERIAS CREADAS
        public function index_admin (){
            $response = Gate::inspect('gestion-materias-admin');

            if($response->allowed())
            {
                $materias = Materias::all();
                return response()->json([
                    'data'=> $materias
                    

                ]);
            }else{
                echo $response->message();
            }
        }

                    /**
     * @OA\Get(
     * path= "/api/v1/materias/admin/{id}",
     * operationId="Ver materias por ID",
     * tags={"Gestion Materias"},
     * summary=" Información de una materia según su id",
     * description="Retorna la información de una materia",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id de la materia",
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
        //FUNCION PARA VER UNA MATERIA
        public function show_admin (Request $request, $id){
            $response = Gate::inspect('gestion-materias-admin');

            if($response->allowed())
            {
                $materias = Materias::find($id);
                if($materias){
                    return response()->json([
                        'mesagge' => 'Materia a vizualizarse',
                        'data'=> $materias
            
                    ]);
                }else{
                    return response()->json([
                        'message' => 'No existe ninguna materia con ese id.',

            
                    ], 404);

                }            
            }else{
                    echo $response->message();
                }

        }

    /**
     * @OA\Post(
     * path= "/api/v1/materias/admin/update/{id}",
     * operationId=" Actualizar Materias",
     * tags={"Gestion Materias"},
     * summary="Actualizar la información de una materia",
     * description=" Ingrese la informacion para actualizar la materia",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id de la materia",
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

        //FUNCION PARA ACTUALIZAR LA MATERIA
        public function update_admin (Request $request, $id){
            $response = Gate::inspect('gestion-materias-admin');

            if($response->allowed())
            {
                $fields = $request->validate([
                    'nombre' => 'nullable|string',
                    'descripcion' => 'nullable|string',
                    'encargado' => 'nullable|string'
                    
                ]);

                $materias = Materias::find($id);


                if($materias){
                    $materias->update($fields);

                    return response()->json([
                        'message' => 'La materia se actualizado satisfactoriamente.',
                        'data'=> $materias
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
    *     path="/api/v1/materias/desactiva/admin/{materias}",
    *     summary="Activar e Inactivar Materias",
    *     tags={"Gestion Materias"},
    *      @OA\Parameter(
    *          name="materias",
    *          description="Id de la materia",
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
        //FUNCION PARA ACTIVAR Y DESACTIVAR 

        
        public function destroy_admin (Materias $materias){

            $response = Gate::inspect('gestion-materias-admin');

            if($response->allowed())
            {
                // $carreras = Carreras::find($id);
                $materias_estado = $materias->estado;
                $mensaje = $materias_estado ? "inactivo":"activo";
                $materias->estado = !$materias_estado;
                $materias->save();

                return $this->sendResponse(message: "La materia esta $mensaje ");

            }else{
                echo $response->message();
            }
        }

}
