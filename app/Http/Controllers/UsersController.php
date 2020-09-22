<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index()
    {
        return view('users.index');
    }


    public function users_type_add(Request $request)
    {
        $post = (object) $request->all();

        $validate = DB::SELECT(DB::RAW("
            SELECT * FROM atb_user_type WHERE user_type_name = ?
        "),[$post->user_type_name]);

        if(!empty($validate))
            return [
                'h'=>"Add User Type Failed",
                'm'=>"User type already exists",
                's'=>"warning"
            ];

        $id = DB::table('atb_user_type')
            ->insertGetId(['user_type_name'=>$post->user_type_name]);


        return [
            'h'=>"Good Job!",
            'm'=>"You have successfully added new user type!",
            's'=>"success",
        ];
    }

    public function users_type_delete(Request $request)
    {
        $delete = (object) $request->all();


        $validate = DB::SELECT(DB::RAW("
            SELECT user_type FROM atb_user WHERE user_type = ?
        "),[$delete->user_type]);

        if(!empty($validate))
            return [
                'h'=>"Delete User Type Failed",
                'm'=>"User type is currently in use and cannot be removed",
                's'=>"warning"
            ];

        DB::table('atb_user_type')->where('user_type',$delete->user_type)->delete();


        return [
            'h'=>"Delete User Type Success!",
            'm'=>"You have successfully removed User Type",
            's'=>"success"
        ];

    }


    public function users_list_add(Request $request)
    {
        $post = (object) $request->all();

        if (!filter_var($post->user_email, FILTER_VALIDATE_EMAIL))
            return [
                'h'=>"Add User Failed",
                'm'=>"Please enter valid email",
                's'=>"error"
            ];

        $validate = DB::select( DB::raw("SELECT user_id FROM atb_user WHERE  user_type = ?") , [$post->user_email]);
        if(!empty($validate))
            return [
                'h'=>"Add User Failed",
                'm'=>"Username / Email already exists!",
                's'=>"warning"
            ];

        if($post->user_password != $post->user_cpassword)
            return [
                'h'=>"Add User Failed",
                'm'=>"Password doesn't match!",
                's'=>"error"
            ];

        $passwordc = strlen($post->user_password);

        $setup = (object) DB::select( DB::raw("SELECT * FROM atb_setup WHERE setup_id = ?") , [env('SETUP_ID')] );
        foreach($setup as $setup)


        $access_data = (object) DB::select( DB::raw("SELECT * FROM atb_user_type WHERE user_type = ?") , [$post->user_type] );
        $access = [];
        foreach($access_data as $access_data)

        foreach($access_data as $key=>$val) {
            if(strpos($key,'access') !== true)
                $access[$key]=$val;
        }
        $access  = (object) $access;

        if($passwordc < $setup->setup_min_password || $passwordc > $setup->setup_max_password)
            return [
                'h'=>"Add User Failed",
                'm'=>"Password requires minimum of 6 and maximum of 24 characters",
                's'=>"error"
            ];

        $new_password = Hash::make($post->user_password);

        $id = DB::table('atb_user')
            ->insertGetId([
                'user_email'=>$post->user_email,
                'user_password'=>$new_password,
                'user_type'=>$post->user_type
            ]);

        $access->user_id = $id;
        unset($access->user_type);
        unset($access->user_type_name);
        DB::table('atb_user_access')
            ->insert((array) $access);

        return [
            'h'=>"Good Job!",
            'm'=>"You have successfully added new user!",
            's'=>"success",
        ];

    }


    public function data_user_type()
    {
        $query = "CALL sp_data_user_type()";
        return DB::select($query);
    }

    public function data_user_list(Request $request)
    {
        $post = (object) $request->all();
        $user_type = $post->user_type;
        $query = "  SELECT
                        a.user_id,
                        a.user_name,
                        a.user_email,
                        a.user_locked,
                        a.user_date_registered,
                        a.user_change_password,
                        a.user_img,
                        b.*,
                        c.*
                    FROM atb_user a
                    INNER JOIN atb_user_type b ON a.user_type = b.user_type
                    INNER JOIN atb_user_access c ON a.user_id = c.user_id
                    WHERE
                        CASE ?
                            WHEN 0 THEN 1=1
                            ELSE b.user_type = ?
                        END
        ";
        return DB::select( DB::raw($query), [$user_type,$user_type] );
    }


}
