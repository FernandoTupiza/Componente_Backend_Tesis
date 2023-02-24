<?php

namespace App\Http\Controllers\Documentos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Documentos;
use App\Models\Materias;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class DocumentosAdminController extends Controller
{
/**
 * @OA\Post(
 * path= "/api/v1/documentos/admin/{materias}",
 * operationId="Crear docuemntos en relacion a la materias",
 * tags={"Gestion Documentos"},
 * summary=" Crear un nuevo documento ",
 * description="Suba un nuevo documento",
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
 *      *      @OA\RequestBody(
 *          @OA\JsonContent(),
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema(
 *              type="object",
 *             required={"nombre_doc", "documentos"},
 *             
 *              @OA\Property(
 *                 property="nombre_doc",
 *                type="string"
 *               
 *            ),
 *            @OA\Property(
*                 property="documentos",
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
    //FUNCION PARA SUBIR UN DOCUMENTO.
    public function store_admin (Request $request, Materias $materias)
    {
        $response = Gate::inspect('gestion-documentos-admin');

        if($response->allowed())
        {
            $doc=$request -> validate([

                'nombre_doc'  => ['required', 'string', 'min:5', 'max:30'],
                'documentos' => ['required', 'file', 'mimes:pdf', 'max:20000'],

            ]);
            $doc1 = $doc [ 'documentos'];
            $uploadedFileUrl = Cloudinary::uploadFile($doc1->getRealPath())->getSecurePath();
            $documentos = new Documentos($request->all());
            $documentos->materias_id = $materias->id;
        
            $documentos->path= $uploadedFileUrl;
            $documentos->save();
            
            return $this->sendResponse('Documento subido  satisfactoriamente');
        }else{
            echo $response->message();
        }
    }
/**
 * @OA\Post(
 * path= "/api/v1/documentos/admin/actualizar/{materias}",
 * operationId=" Actualizar Documentos",
 * tags={"Gestion Documentos"},
 * summary="Actualizar la información de un documento",
 * description=" Actualizar un documento",
 *      @OA\Parameter(
 *          name="materias",
 *          description="Id del documento",
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
 *                 property="nombre_doc",
 *                type="string"
 *               
 *            ),
 *            @OA\Property(
*                 property="documentos",

*                type="file"
*              
*               ),
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

    // FUNCION PARA ACTUALIZAR EL DOCUMENTO
    public function update_admin(Request $request, Documentos $documentos)
    {
        $response = Gate::inspect('gestion-documentos-admin');

        if($response->allowed())
        {
            $doc=$request -> validate([
                'nombre_doc'  => ['nullable','string', 'min:5', 'max:30'],
                'documentos' => ['nullable','file', 'mimes:pdf', 'max:200000'],
            ]);
            if($request->has('documentos')){

                $doc1 = $doc [ 'documentos'];

                $uploadedFileUrl = Cloudinary::uploadFile($doc1->getRealPath())->getSecurePath();
                $documentos -> update( [
                    'path'  => $uploadedFileUrl,
                ]);
            }
            if($request->has('nombre_doc')){
                $documentos -> update( [
                    'nombre_doc'  =>  $request -> nombre_doc,
                ]);
            }
            return $this->sendResponse('Documento se ha actualizado satisfactoriamente');
        }else{
            echo $response->message();
        }
    }
            /**
     * @OA\Get(
     * path= "/api/v1/documentos/admin/{id}",
     * operationId="Ver documentos por ID",
     * tags={"Gestion Documentos"},
     * summary=" Información de un documento según su id",
     * description="Retorna la información de un documento",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id del documento",
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
    //FUNCION PARA VER UN DOCUMENTO MEDIANTE EL ID
    public function show_admin ($id){
        $response = Gate::inspect('gestion-documentos-admin');

        if($response->allowed())
        {
            $documentos = Documentos::find($id);
            if($documentos){
            return response()->json([
                'mesagge' => 'Path del documento a vizualizarse',
                'data'=> $documentos

            ]);
            }else{
                return response()->json([
                    'message' => 'No existe ninguna path con ese id.',


                ], 404);

            }
        }else{
            echo $response->message();
        }
    }
         /**
      * @OA\Get(
        * path= "/api/v1/documentos/admin",
        * operationId="Documentos a ver",
        * tags={"Gestion Documentos"},
        * summary="Lista de documentos",

        * description="Retorno lista de documentos",
        *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )

      */

    
    //FUNCION PARA VER TODOS LOS DOCUMENTOS CREADOS

    public function index_admin (Request $request){

        $documentos = Documentos::all();
        return response()->json([
            'data'=> $documentos

        ]);

    }
            /**
    * @OA\Delete(
    *     path="/api/v1/documentos/admin/{id}",
    *     summary="Eliminar un documento",
    *     tags={"Gestion Documentos"},
    *      @OA\Parameter(
    *          name="id",
    *          description="Id del documento",
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

    //FUNCION PARA ELIMINAR DOCUMENTOS

    public function delete_admin ($id){

        $response = Gate::inspect('gestion-documentos-admin');

        if($response->allowed())
        {
            $documentos = Documentos::find($id);


            if($documentos){
                $documentos->delete();

                return response()->json([
                    'message'=> 'El documento se ha eliminado satisfactoriamente'
                ]);
            }
            else{
                return response()->json([
                    'message'=> 'No existe ninguna documento con ese id.'
        
                ], 404);

            }

        }else{
            echo $response->message();
        }

    }

}
