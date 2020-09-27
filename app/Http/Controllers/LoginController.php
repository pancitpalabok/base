<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        if (session()->exists('user_data')) {
            return redirect(route('startup.index'));
        }
        return view('login');
    }

    public function logout()
    {
        session()->flush(session()->getid());
        return redirect('/login');
    }

    public function view_session()
    {
        echo "<pre>";
        print_r(session()->all());



    }

    public function login(Request $request)
    {

        $post = (object) $request->all();

        if($post->user_email == '' || $post->user_email == '')
            return [
                'h'=>"Login Failed",
                'm'=>"Please enter correct Email or Password",
                's'=>"error",
            ];


        $user_info = DB::select("CALL sp_login(?)",[$post->user_email]);

        foreach($user_info as $user_info)


        if(empty($user_info))
            return [
                'h'=>"Login Failed",
                'm'=>"Incorrect email / password",
                's'=>"error",
            ];


        if(!Hash::check($post->user_password,$user_info->user_password))
            return [
                'h'=>"Login Failed",
                'm'=>"Incorrect email / password",
                's'=>"error",
            ];

        if($user_info->user_locked)
            return [
                'h'=>"Account Locked!",
                'm'=>"This account is not Available, Please contact the Administrator for support",
                's'=>"warning",
            ];


        /* Success Login */

        session([
            'user_data'=>$user_info,
            'user_access'=>explode(',',$user_info->user_access),
        ]);

        return [
            's'=>"success"
        ];

    }
}
