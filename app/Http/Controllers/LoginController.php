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
        echo "</pre>";
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


        $query = "  SELECT
                        *
                    FROM atb_user a
                    INNER JOIN atb_user_type b ON a.user_type = b.user_type
                    INNER JOIN atb_user_access c ON a.user_id = c.user_id
                    WHERE a.user_email = ?";
        $user_info =  DB::select(DB::raw($query),[$post->user_email]);

        foreach($user_info as $user_info)

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


        if(empty($user_info))
            return [
                'h'=>"Login Failed",
                'm'=>"Incorrect email / password",
                's'=>"error",
            ];

        /* Success Login */

        $id = session()->getID();
        DB::raw("UPDATE sessions SET user_id = ? WHERE id = ?", [$user_info->user_id,$id]);

        session([
            'user_data'=>$user_info
        ]);



        return [
            's'=>"success"
        ];

    }
}
