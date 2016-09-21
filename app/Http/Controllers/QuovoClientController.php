<?php
/**
 * Created by PhpStorm.
 * User: miguelfruto
 * Date: 20/09/16
 * Time: 5:48 PM
 */

namespace App\Http\Controllers;


use App\QuovoUsers;
use Illuminate\Support\Facades\Auth;
use Wela\Quovo;

class QuovoClientController
{
    static $quovo;
    static function  getIFrameToken($id){
        $quovo = new Quovo(['user'=>env('QUOVO_USER', ''),'password'=>env('QUOVO_PASSWORD', '')]);
        $quovoUsers =QuovoUsers::where('user_id',$id)
            ->take(1)
            ->get();
        if($quovoUsers[0]->quovo_user_id!=null){
            $token =  $quovo->iframe()->getIframeToken($quovoUsers[0]->quovo_user_id);
            return ['user_id'=>$quovoUsers[0]->quovo_user_id,'token'=>$token->iframe_token->token];
        }
        return null;
    }

}