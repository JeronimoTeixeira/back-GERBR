<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Measures;
use App\Models\Measurers;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;


class MeasuresController extends Controller
{


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        try{
            $values = $request->only(['id_measurer']);
            $userJWT = JWTAuth::parseToken()->authenticate();
            $user = User::where('id',$userJWT['id'])->first();
            $measurer = $user->measurer($values['id_measurer'])->first();
            if($measurer == null){
                return response()->json(['error'=> "Dados Invalidos"],400);
            }
            $values = $request->only(['id_measurer','value','date']);
            $reponse =Measures::create([
                'id_measurer' => $values['id_measurer'],
                'value' => $values['value'],
                'date' => $values['date'],
                ]);
                return response()->json(['value'=> $reponse]);
            }
            catch(Exception $e){
                return response()->json(['error'=> "Ocorreu algum erro inesperado"],500);
            }
    }

    /**
     * Generates the average of the last twelve months.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \ Illuminate \ Http \ Response
     */


    public function getMonth(Request $request){
        try{
            $values = $request->only(['id_measurer']);
            $userJWT = JWTAuth::parseToken()->authenticate();
            $user = User::where('id',$userJWT['id'])->first();
            $measurer = $user->measurer($values['id_measurer'])->first();
            if($measurer == null){
                return response()->json(['error'=> "Dados Invalidos"],400);
            }
            $measures = array();
            $date = Carbon::now();
            for($i = 12 + $date->month; $i>$date->month; $i--){
                if($i>12){
                    $values = $measurer->measures()->whereMonth('date', '=', $i - 12 )->select('value')->get();
                    $month = $i - 12;
                }
                else{
                    $values = $measurer->measures()->whereMonth('date', '=', $i )->select('value')->get();
                    $month = $i;
                }
                $total = 0;
                foreach($values as $val){
                    $total = $val["value"] + $total;
                }
                $media = 0;
                if(sizeof($values)!=0){
                    $media = $total/sizeof($values);
                }
                $values = array(
                    "value"=>$media,
                    "date"=>$month
                );
                array_push($measures,$values);
            }
            return response()->json(['value'=> $measures]);
        }
        catch(Exception $e){
            return response()->json(['error'=> "Ocorreu algum erro inesperado"],500);
        }
    }

    /**
     * Generates the average of the last seven days.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \ Illuminate \ Http \ Response
     */

    public function getWeek(Request $request){
        try{
            $values = $request->only(['id_measurer']);
            $userJWT = JWTAuth::parseToken()->authenticate();
            $user = User::where('id',$userJWT['id'])->first();
            $measurer = $user->measurer($values['id_measurer'])->first();
            if($measurer == null){
                return response()->json(['error'=> "Dados Invalidos"],400);
            }
            $date = Carbon::now();
            $measures = array();
            for($i = $date->day-1; $i>=0; $i--){
                $date = Carbon::now()->subDays($i)->format('Y-m-d');
                $values = $measurer->measures()->whereDate('date', '=', $date)->select('value')->get();
                $total = 0;
                foreach($values as $val){
                    $total = $val["value"] + $total;
                }
                $media = 0;
                if(sizeof($values)!=0){
                    $media = $total/sizeof($values);
                }
                $values = array(
                    "value"=>$media,
                    "date"=>$date
                );
                array_push($measures,$values);
            }
            return response()->json(['value'=> $measures]);
        }
        catch(Exception $e){
            return response()->json(['error'=> "Ocorreu algum erro inesperado"],500);
        }
    }

    /**
     * Generates the mediated of the Day.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \ Illuminate \ Http \ Response
     */

    public function getDay(Request $request){
        try{
            $values = $request->only(['id_measurer','date']);
            $userJWT = JWTAuth::parseToken()->authenticate();
            $user = User::where('id',$userJWT['id'])->first();
            $measurer = $user->measurer($values['id_measurer'])->first();
            if($measurer == null){
                return response()->json(['error'=> "Dados Invalidos"],400);
            }
            $measures = $measurer->measures()->whereDate('date', '=', $values['date'])->get();
            return response()->json(['value'=> $measures]);
        }
        catch(Exception $e){
            return response()->json(['error'=> "Ocorreu algum erro inesperado"],500);
        }
    }

    public function records(Request $request){
        try{
            $values = $request->only(['id_measurer','dateStart','dateFinal']);
            $userJWT = JWTAuth::parseToken()->authenticate();
            $user = User::where('id',$userJWT['id'])->first();
            $measurer = $user->measurer($values['id_measurer'])->first();
            if($measurer == null){
                return response()->json(['error'=> "Dados Invalidos"],400);
            }
            $measures = $measurer->measures()
                        ->whereDate('date', '>=', $values['dateStart'])
                        ->whereDate('date', '<=', $values['dateFinal'])->get();
            return response()->json(['value'=> $measures]);
        }
        catch(Exception $e){
            return response()->json(['error'=> "Ocorreu algum erro inesperado"],500);
        }
    }
}
