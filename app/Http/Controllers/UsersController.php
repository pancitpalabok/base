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
        /** convert array to object */
        $post = (object) $request->all();

        /** validate user type name has input */
        if(in_array($post->user_type_name,[null,'']))
            return [
                'h'=>"Add User Type Failed",
                'm'=>"Please enter user type name",
                's'=>"error"
            ];

        /** execute database sp to validate and insert new user type */
        $result = DB::select("CALL sp_users_type_add(?)",[$post->user_type_name]);
        foreach($result as $result);
        return (array) $result;
    }

    public function users_type_delete(Request $request)
    {
        /** convert array to object */
        $delete = (object) $request->all();

        /** execute database sp to delete user type
         * @param user_type from ajax request
        */
        $result = DB::select("CALL sp_users_type_delete(?)",[$delete->user_type]);
        foreach($result as $result);
        return (array) $result;
    }

    public function users_type_edit(Request $request)
    {
        /** convert array to object */
        $put = (object) $request;

        /** validate user type name as input */
        if(in_array($put->user_type_name,[null,'']))
            return [
                'h'=>"Add User Type Failed",
                'm'=>"Please enter user type name",
                's'=>"error"
            ];

        /** execute database sp to validate and update to user type to table
         * @param user_type from ajax request
         * @param user_type_name from ajax request
        */
        $result = DB::select("CALL sp_users_type_edit(?,?)",[$put->user_type,$put->user_type_name]);
        foreach($result as $result);
        return (array) $result;

    }

    public function users_type_data()
    {
        /** get data from database sp for user type data */
        return DB::select("CALL sp_users_type_data()");
    }


    public function users_type_access_edit(Request $request)
    {
        /** convert array request to object */
        $put = (object) $request->all();

        /** set new user_type variable
         * @param user_type from ajax request
         */
        $user_type = $put->user_type;

        /** unset data to prevent sending data to database
         * @param _token unset token from request
         * @param user_type unset user_type to prevent updating the column
         */
        unset($put->_token);
        unset($put->user_type);

        /** get user permision data and assign to permisions */
        $permisions = DB::table('atb_user_access')->get();


        /** get access name from that is set to html object class and convert it to array */
        $access = [];
        foreach($put as $key=>$val) {

            /** remove type- to tally from database variables */
            $name =  str_replace('type-','',$key);
            foreach($permisions as $a) {
                if($a->access_name == $name)
                    $access[] = $a->access_id;

            }


        }

        /** convert array to comma separated string for data column */
        $access = implode(",",$access);

        /** execute database sp to update user access
         * @param user_type used as WHERE in database to get the user access
         * @param access the comma separated data to update to user access column
         */
        $result = DB::select("CALL sp_users_type_access_edit(?,?)",[$user_type,$access]);
        foreach($result as $result);
        return (array) $result;

    }



    //-----------------------------------------------------------------------------------USERS

    public function users_list_data(Request $request)
    {
        /** convert array request to object */
        $post = (object) $request->all();

        /** assigned user_type to filter what user type to view */
        $user_type = $post->user_type;

        /** get data from database sp
         * @param user_type assigned at the top and can be '' or null to view all data
         * @param user_id check user logged in to prevent editing it's own access, data and delete
         */
        return DB::select("CALL sp_users_list_data(?,?)",[$user_type,session()->get('user_data')->user_id]);
    }

    public function users_list_access_edit(Request $request)
    {
        /** convert array request to object */
        $put = (object) $request->all();

        /** assign user id from request data */
        $user_id = $put->user_id;

        /** unset data to prevent affecting the database table */
        unset($put->_token);
        unset($put->user_id);

        /** get user access data list for reference */
        $permisions = DB::table('atb_user_access')->get();

        /** get access name from that is set to html object class and convert it to array */
        $access = [];
        foreach($put as $key=>$val) {

            /** remove list- to tally from database variables */
            $name =  str_replace('list-','',$key);

            foreach($permisions as $a) {
                if($a->access_name == $name)
                    $access[] = $a->access_id;

            }


        }

        /** convert array to comma separated string for data column */
        $access = implode(",",$access);

        /**  execute database sp to update user access
         * @param user_id WHERE clause to update specific user
         * @param access comma separated data to change user access
         */
        $result = DB::select("CALL sp_users_list_access_edit(?,?)",[$user_id,$access]);
        foreach($result as $result);
        return (array) $result;

    }

    public function users_list_add(Request $request)
    {
        /** convert array request to object */
        $post = (object) $request->all();

        /** get password count */
        $passwordc = strlen($post->user_password);

        /** encrypt password using laravel hash */
        $new_password = Hash::make($post->user_password);

        /** validate user email as validated email */
        if (!filter_var($post->user_email, FILTER_VALIDATE_EMAIL))
            return [
                'h'=>"Add User Failed",
                'm'=>"Please enter valid email",
                's'=>"error"
            ];

        /** if user access ip has input data, validate if it's IP format */
        if($post->user_access_ip != '') {
            if (!filter_var($post->user_access_ip, FILTER_VALIDATE_IP))
                return [
                    'h'=>"Add User Failed",
                    'm'=>"Please enter valid IP Address",
                    's'=>"error"
                ];
        }

        /** validate password and confirm password is equal */
        if($post->user_password != $post->user_cpassword)
            return [
                'h'=>"Add User Failed",
                'm'=>"Password doesn't match!",
                's'=>"error"
            ];

        /** execute database sp to validate and register new user */
        $result = DB::select("CALL sp_users_list_add(?,?,?,?,?)",[
            $post->user_email,
            $passwordc,
            $new_password,
            $post->user_type,
            $post->user_access_ip,]);
        foreach($result as $result);
        return (array) $result;

    }

    public function users_list_lock(Request $request)
    {
        /* convert array request to object */
        $put = (object) $request->all();

        /** execute database sp to lock user
         * @param user_id selected user to lock
         */
        $result = DB::select("CALL sp_users_list_lock(?)",[$put->user_id]);
        foreach($result as $result);
        return (array) $result;
    }

    public function users_list_unlock(Request $request)
    {
        /** convert array request to object */
        $put = (object) $request->all();

        /** execute database sp to unlock user
         * @param user_id selected user to unlock
         */
        $result = DB::select("CALL sp_users_list_unlock(?)",[$put->user_id]);
        foreach($result as $result);
        return (array) $result;
    }

    public function users_list_reset(Request $request)
    {
        /** convert array request to object */
        $put = (object) $request->all();

        /** convert password from .env file to root directory */
        $new_password = Hash::make(env('SETUP_DEFAULT_PASSWORD'));

        /** execute datatabase sp to reset user with new password
         * @param user_id selected user to reset
         * @param new_passsword update password to database with hashed password from laravel
         */
        $result = DB::select("CALL sp_users_list_reset(?,?)",[$put->user_id,$new_password]);
        foreach($result as $result);
        return (array) $result;
    }

    public function users_list_delete(Request $request)
    {
        /** convert array request to object */
        $delete = (object) $request;

        /** execute database sp to update user to deleted and prevent it to display in data list
         * @param user_id update this user tagged as deleted
         */
        $result = DB::select("CALL sp_users_list_delete(?)",[$delete->user_id]);
        foreach($result as $result);
        return (array) $result;
    }

    public function users_list_edit(Request $request)
    {
        /** convert array request to object */
        $put = (object) $request;

        /** validate user access ip has input data */
        if($put->user_access_ip != '') {

            /** check access ip is a valid ip */
            if (!filter_var($put->user_access_ip, FILTER_VALIDATE_IP))
                return [
                    'h'=>"Add User Failed",
                    'm'=>"Please enter valid IP Address",
                    's'=>"error"
                ];
        }

        /** execute database sp to update user data
         * @param user_id WHERE clause to update specific user
         * @param user_type update user type if changed
         * @param user_access_ip update access ip
         */
        $result = DB::select("CALL sp_users_list_edit(?,?,?)",[$put->user_id,$put->user_type,$put->user_access_ip]);
        foreach($result as $result);
        return (array) $result;
    }
}
