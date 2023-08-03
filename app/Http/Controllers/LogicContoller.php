<?php

namespace App\Http\Controllers;

use App\Models\RecintoElectoral;
use App\Models\Canton;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
/**
 * @OA\Info(
 *             title="API Persons with Login and Register",
 *             version="1.0",
 *             description=""
 * )
 *
 * @OA\Server(url="http://127.0.0.1:8000")
 *
*@OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 * )
 */ 
class LogicContoller extends Controller
{
      /**
     * Listado de todes las personas
     * @OA\Get (
     *     path="/api/auth/provincias",
     *     security={{"bearerAuth":{}}},
     *     tags={"usuarios"},
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="rows",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="provincia",
     *                         type="string",
     *                         example="manabí"
     *                     ), @OA\Property(
     *                         property="canton",
     *                         type="string",
     *                         example="chone"
     * 
     *                           
     *                     ),
     *                     @OA\Property(
     *                         property="parroquia",
     *                         type="string",
     *                         example="santarita"
     * 
     *                           
     *                     ), @OA\Property(
     *                         property="recinto",
     *                         type="string",
     *                         example="uleam"),
     * 
     *                           
     *                     
     *                          @OA\Property(property="created_at", type="string", example="2023-02-23T00:09:16.000000Z"),
     *              @OA\Property(property="updated_at", type="string", example="2023-02-23T12:33:45.000000Z"),
     *                        
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function listap(){
        $datos = DB::table('provincias')
            ->join('cantones', 'provincias.id', '=', 'cantones.provincia_id')
            ->join('parroquias', 'cantones.id', '=', 'parroquias.canton_id')
            ->join('recintoselectorales', 'parroquias.id', '=', 'recintoselectorales.parroquia_id')
            ->select('provincias.provincia', 'cantones.canton', 'parroquias.parroquia', 'recintoselectorales.recinto')
            ->get();

        return response()->json([
            'Datos' => $datos
        ],200);
    }
      /**
     * Listado de todes las personas
     * @OA\Get (
     *     path="/api/auth/cantones",
     *     security={{"bearerAuth":{}}},
     *     tags={"usuarios"},
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="rows",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="canton",
     *                         type="string",
     *                         example="chone"
     *                     ), @OA\Property(
     *                         property="provincia",
     *                         type="string",
     *                         example="manabi"
     * 
     *                           
     *                     ),
     *                     
     *                          @OA\Property(property="created_at", type="string", example="2023-02-23T00:09:16.000000Z"),
     *              @OA\Property(property="updated_at", type="string", example="2023-02-23T12:33:45.000000Z"),
     *                        
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function cantonesp(){
        $datos = DB::table('provincias')
        ->join('cantones', 'provincias.id', '=', 'cantones.provincia_id')
        ->select('cantones.canton', 'provincias.provincia')
        ->orderBy('provincias.provincia')
        ->get();

    return response()->json([
        'Datos' => $datos
    ], 200);


    }

    public function recintosp(){
        $datos = DB::table('provincias')
            ->join('cantones', 'provincias.id', '=', 'cantones.provincia_id')
            ->join('parroquias', 'cantones.id', '=', 'parroquias.canton_id')
            ->join('recintoselectorales', 'parroquias.id', '=', 'recintoselectorales.parroquia_id')
            ->select('provincias.provincia', 'cantones.canton', 'recintoselectorales.recinto')
            ->get();

        return response()->json([
            'Datos' => $datos
        ], 200);

    }

    public function updateRecinto(Request $request,$id){
        if(empty($request->recinto) ){
            return response()->json(['message'=>"No se permiten campos vacios"]);   
         }
     
         if(empty($id)){
     
            return response()->json(['message'=>"El id no puede estar vacio"]);          
         }
         $recinto= RecintoElectoral::find($id);
         if($recinto->estado==false){
            return response()->json(['message'=>"El Registro ya ha sido eliminado anterioemente"]);          
         }
         
         $recinto->recinto=$request->recinto;
         $recinto->parroquia_id=$request->parroquia_id; 
         $recinto->save();
         return response()->json(['message'=>"Registro updated"]);
    }

        public function Eliminar($id){
            $canton=Canton::find($id);
            if($canton->estado==false){
              return response()->json(['message'=>"El Registro ya ha sido eliminado anterioemente"]); 
            }
            $canton->estado=false;
            $canton->save();
            return response()->json(['message'=>"registro eliminado"]);
        }
}