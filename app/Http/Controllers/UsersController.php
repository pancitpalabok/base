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



    // ----------------------------------------------------------------------------------USER TYPE

    public function users_type_add(Request $request)
    {
        $post = (object) $request->all();
        $result = DB::select("CALL sp_users_type_add(?)",[$post->user_type_name]);
        foreach($result as $result);
        return (array) $result;
    }

    public function users_type_delete(Request $request)
    {
        $delete = (object) $request->all();
        $result = DB::select("CALL sp_users_type_delete(?)",[$delete->user_type]);
        foreach($result as $result);
        return (array) $result;
    }

    public function users_type_edit(Request $request)
    {
        $put = (object) $request;
        $result = DB::select("CALL sp_users_type_edit(?,?)",[$put->user_type,$put->user_type_name]);
        foreach($result as $result);
        return (array) $result;

    }

    public function users_type_data()
    {
        return DB::select("CALL sp_users_type_data()");
    }

    public function users_type_access_data()
    {

    }

    public function users_type_access_edit(Request $request)
    {
        $put = (object) $request->all();
        $user_type = $put->user_type;

        unset($put->_token);
        unset($put->user_type);

        $access = [];
        foreach($put as $key=>$val)
            $access[] = $key;

        $access = implode(",",$access);

        $result = DB::select("CALL sp_users_type_access_edit(?,?)",[$user_type,$access]);
        foreach($result as $result);
        return (array) $result;

    }



    //-----------------------------------------------------------------------------------USERS

    public function users_list_data(Request $request)
    {
        $post = (object) $request->all();
        $user_type = $post->user_type;
        return DB::select("CALL sp_users_list_data(?,?)",[$user_type,session()->get('user_data')->user_id]);
    }

    public function users_list_add(Request $request)
    {
        $post = (object) $request->all();

        $passwordc = strlen($post->user_password);

        $new_password = Hash::make($post->user_password);

        if (!filter_var($post->user_email, FILTER_VALIDATE_EMAIL))
            return [
                'h'=>"Add User Failed",
                'm'=>"Please enter valid email",
                's'=>"error"
            ];

        if($post->user_password != $post->user_cpassword)
            return [
                'h'=>"Add User Failed",
                'm'=>"Password doesn't match!",
                's'=>"error"
            ];

        $result = DB::select("CALL sp_users_list_add(?,?,?,?)",[
            $post->user_email,
            $passwordc,
            $new_password,
            $post->user_type,]);
        foreach($result as $result);
        return (array) $result;

    }

    public function users_list_lock(Request $request)
    {
        $put = (object) $request->all();
        $result = DB::select("CALL sp_users_list_lock(?)",[$put->user_id]);
        foreach($result as $result);
        return (array) $result;
    }

    public function users_list_unlock(Request $request)
    {
        $put = (object) $request->all();
        $result = DB::select("CALL sp_users_list_unlock(?)",[$put->user_id]);
        foreach($result as $result);
        return (array) $result;
    }

    public function users_list_reset(Request $request)
    {
        $put = (object) $request->all();
        $new_password = Hash::make(env('SETUP_DEFAULT_PASSWORD'));
        $result = DB::select("CALL sp_users_list_reset(?,?)",[$put->user_id,$new_password]);
        foreach($result as $result);
        return (array) $result;
    }

    public function users_list_delete(Request $request)
    {
        $delete = (object) $request;
        $result = DB::select("CALL sp_users_list_delete(?)",[$delete->user_id]);
        foreach($result as $result);
        return (array) $result;
    }

    public function users_list_edit(Request $request)
    {
        $put = (object) $request;
        $result = DB::select("CALL sp_users_list_edit(?,?)",[$put->user_id,$put->user_type]);
        foreach($result as $result);
        return (array) $result;
    }
}
