<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Measurers;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class MeasurersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $userJWT = JWTAuth::parseToken()->authenticate();
            $user = User::where('id',$userJWT['id'])->first();
            $measurer = $user->measurers()->get();
            return response()->json(['value'=> $measurer]);
        }
        catch (Exception $e){
            return response()->json(['error'=> "Ocorreu algum erro inesperado"],500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try{
            $values = $request->only([
            'id_user',
            'city',
            'state',
            'district',
            'street',
            'cep',
            'complement'
            ]);
            $reponse = Measurers::create([
                'id_user' => $values['id_user'],
                'city' => $values['city'],
                'state' => $values['state'],
                'district' => $values['district'],
                'street' => $values['street'],
                'cep' => $values['cep'],
                'complement' => $values['complement']
            ]);
            return response()->json(['value'=> $reponse]);
        }
        catch(Exception $e){
            return response()->json(['error'=> "Ocorreu algum erro inesperado"],500);
        }
    }
}
