<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        /** validate if session is set, or else back to log in */
        if (session()->exists('user_data')) {
            return redirect(route('startup.index'));
        }
        return view('login');
    }

    public function logout()
    {
        /** unset session to restart session back to login */
        session()->flush(session()->getid());
        return redirect('/login');
    }

    public function view_session()
    {
        /** temporarily view active session
         * FOR DEVELOPMENT
         */

        echo "<pre>";
        print_r(session()->all());



    }

    public function login(Request $request)
    {

        /** convert array request to object */
        $post = (object) $request->all();

        /**  validate email of null or no input */
        if($post->user_email == '')
            return [
                'h'=>"Login Failed",
                'm'=>"Please enter correct Email or Password",
                's'=>"error",
            ];

        /** get data from database sp if email exists
         * @param user_email WHERE clause for specific user
        */
        $user_info = DB::select("CALL sp_login(?)",[$post->user_email]);

        /** convert multi-array to single array */
        foreach($user_info as $user_info)

        /** validate of email exists, if no email registered in data then failed */
        if(empty($user_info))
            return [
                'h'=>"Login Failed",
                'm'=>"Incorrect email / password",
                's'=>"error",
            ];




        /** CONTINUE CODE IF USER EXISTS */


        /** validate hashed password to current password registered in database */
        if(!Hash::check($post->user_password,$user_info->user_password))
            return [
                'h'=>"Login Failed",
                'm'=>"Incorrect email / password",
                's'=>"error",
            ];


        /** validate user if locked or not
         * @param user_locked if 1 then LOCKED ELSE UNLOCKED
         */
        if($user_info->user_locked)
            return [
                'h'=>"Account Locked!",
                'm'=>"This account is not Available, Please contact the Administrator for support",
                's'=>"warning",
            ];


        /* Success Login */
        $user_access = explode(',',$user_info->user_access);

        /** i dont remember why this exists anyways i wont remove it lol */

        if($user_info->user_type == 1) {
            $data = (object) DB::table('atb_user_access')
                        ->select('access_id')->get();

            $permisions = [];
            foreach($data as $row)
            {
                $permisions[] = $row->access_id;
            }
            $user_access = $permisions;
        }
        /** set data to session to successfully logged in */
        session([
            'user_data'=>$user_info,
            'user_access'=>$user_access,
        ]);

        /** this result redirects to main page */
        return [
            's'=>"success"
        ];

    }
}
