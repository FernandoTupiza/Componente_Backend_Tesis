<?php

namespace App\Http\Controllers\Comentarios;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ComentarioSistema;
use App\Http\Resources\Resource;
use App\Models\Materias;
use App\Models\Semestres;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class ComentariosSistemaController extends Controller
{
/**
 * @OA\Post(
 * path= "/api/v1/comentarios/sistema/cambio/{semestres}",
 * operationId="Crear comentarios en relacion al semestres",
 * tags={"Gestion Comentarios"},
 * summary="Crear comentario",
 * description="Ingrese la informacion para crear un comentario",
 *      @OA\Parameter(
 *          name="semestres",
 *          description="Id del comentario",
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
 *             required={"comentario"},
 *             
 *              @OA\Property(
 *                 property="comentario",
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
//FUNCION PARA CREAR COMENTARIOS 
public function store_admin (Request $request, Materias $materias)
{
    $rules=array(

        'comentario' => 'required|string',
    );
    $messages=array(
        'comentario.required' => 'Debe tener un comentario.',
    );
    
    $validator=Validator::make($request->all(),$rules,$messages);
    if($validator->fails())
    {
        $messages=$validator->messages();
        return response()->json(["messages"=>$messages], 500);
    }
    
    $comentarios = new ComentarioSistema($request->all());
    $comentarios ->materias_id = $materias->id;
    $user = Auth::user();
    $comentarios->user_id = $user->id;
    $comentarios->save();
    return response()->json(["comentarios" => $comentarios, "message"=>"El comentario se ha creado satisfactoriamente"], 200);

}

//FUNCION PARA CREAR COMENTARIOS 
public function store_adminCambio (Request $request, Semestres $semestres)
{
    $rules=array(

        'comentario' => 'required|string',
    );
    $messages=array(
        'comentario.required' => 'Debe tener un comentario.',
    );
    
    $validator=Validator::make($request->all(),$rules,$messages);
    if($validator->fails())
    {
        $messages=$validator->messages();
        return response()->json(["messages"=>$messages], 500);
    }
    
    $comentarios = new ComentarioSistema($request->all());
    $comentarios ->semestres_id = $semestres->id;
    $user = Auth::user();
    $comentarios->user_id = $user->id;
    $comentarios->save();
    return response()->json(["comentarios" => $comentarios, "message"=>"El comentario se ha creado satisfactoriamente"], 200);

}
     /**
      * @OA\Get(
        * path= "/api/v1/comentarios/sistema",
        * operationId="Comentarios",
        * tags={"Gestion Comentarios"},
        * summary="Lista de comentarios",

        * description="Lista de comentarios",
        *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )

      */

//FUNCION PARA VER LOS COMENTARIOS
    public function index_admin (){

        $comentarios = ComentarioSistema::all();

        return response()->json([
            'data'=> $comentarios

        ]);
    }
            /**
     * @OA\Get(
     * path= "/api/v1/comentarios/sistema/{id}",
     * operationId="Ver comentario por ID",
     * tags={"Gestion Comentarios"},
     * summary=" Información de un comentario según su id",
     * description="Retorna la información de un comentario",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id del semestre",
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
    

//FUNCION PARA VER UN COMENTARIOS
    public function show_admin ( $id){

        $comentarios = ComentarioSistema::find($id);
        if($comentarios){
            return response()->json([
                'mesagge' => 'Comentario a vizualizarse',
                'data'=> $comentarios

            ]);
        }else{
             return response()->json([
            'message' => 'No existe ningun comentario con ese id.',


            ], 404);

        }
    }

    
    /**
     * @OA\Post(
     * path= "/api/v1/comentarios/sistema/actualizar/{id}",
     * operationId=" Actualizar Comentarios",
     * tags={"Gestion Comentarios"},
     * summary="Actualizar comentario",
     * description=" Ingrese el comentario a actualizarce",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id del comentario",
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
     *                 property="comentario",
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

//FUNCION PARA ACTUALIZAR COMENTARIOS
    public function update_admin (Request $request, $id){

        $fields = $request->validate([

            'comentario' => 'nullable|string',
            
        ]);

        $comentarios = ComentarioSistema::find($id);


        if($comentarios){
            $comentarios->update($fields);

            return response()->json([
                'message' => 'El comentario se actualizado satisfactoriamente.',
                'data'=> $comentarios
            ]);
        }
        else{
            return response()->json([
                'message'=> 'No existe ningun comentario con ese id.'
    
            ], 404);

        }


    }
            /**
    * @OA\Delete(
    *     path="/api/v1/comentarios/sistema/{id}",
    *     summary="Eliminar Comentarios",
    *     tags={"Gestion Comentarios"},
    *      @OA\Parameter(
    *          name="id",
    *          description="Id del comentario",
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

    // FUNCION PARA ELIMINAR COMENTARIOS
    public function delete_admin (Request $request, $id){


        $comentarios = ComentarioSistema::find($id);


        if($comentarios){
            $comentarios->delete();

            return response()->json([
                'message'=> 'El comentario se ha eliminado satisfactoriamente'
            ]);
        }
        else{
            return response()->json([
                'message'=> 'No existe ninguna comentario con ese id.'
    
            ], 404);

        }


    }
}
