<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterListController extends Controller
{
    public function index()
    {

        /** validate if user has access to this function */
        if(!in_array(2,session()->get('user_access')))
            return abort(403);





        return view("master.index");
    }


    /**
     * |--------------------------------------------------
     * |    MASTER TYPE
     * |--------------------------------------------------
     * |
     * |    master type list controller functions contains
     * |    Data    - read / select
     * |    Add     - create / insert
     * |    Edit    - modify / update
     * |    Delete  - remove
     */

    public function master_type_data()
    {

        /** validate if user has access to this function */
        if(!in_array(2,session()->get('user_access')))
            return abort(403);

        /** get data from database  */
        return DB::select("CALL sp_master_type_data()");
    }

    public function master_type_add(Request $request)
    {
        /** convert array to object */
        $post =  (object) $request->all();
        $post = (object) decryptRequest($post);


        /** validate if user has access to this function */
        if(!in_array(6,session()->get('user_access')))
            return abort(403);


        /** check master type name as input */
        if(in_array($post->master_type_name,['',null]))
            return [
                "h"=>"Add Master Type Failed",
                "m"=>"Please enter master type name",
                "s"=>"error",
            ];

        /** execute database sp to validate and insert new master type */
        $result = DB::select("CALL sp_master_type_add(?)",[$post->master_type_name]);
        foreach($result as $result)
        return (array) $result;
    }

    public function master_type_edit(Request $request)
    {
        $put = (object) $request->all();
        $put = (object) decryptRequest($put);


        /** validate if user has access to this function */
        if(!in_array(8,session()->get('user_access')))
            return abort(403);

        if(in_array($put->master_type_name,['',null]))
            return [
                "h"=>"Edit Master Type Failed",
                "m"=>"Please enter master type name",
                "s"=>"error",
            ];
        if($put->master_type == 0)
            return [
                "h"=>"Edit Master Type Failed",
                "m"=>"Master type does not exist",
                "s"=>"error",
            ];

        /** execute database sp to validate and insert new master type
         * @param in_master_type INT
         * @param in_master_type_name VARCHAR(120)
        */
        $result = DB::select("CALL sp_master_type_edit(?,?)",[$put->master_type,$put->master_type_name]);
        foreach($result as $result)
        return (array) $result;

    }

    public function master_type_delete(Request $request)
    {
        /** convert array to object */
        $delete = (Object) $request->all();
        $delete = (object) decryptRequest($delete);


        /** validate if user has access to this function */
        if(!in_array(10,session()->get('user_access')))
            return abort(403);


        if($delete->master_type == 0)
            return [
                "h"=>"Delete Master Type Failed",
                "m"=>"Please select master type",
                "s"=>"error",
            ];

        /** execute database sp to delete master type
         * @param in_master_type INT
         */
        $result = DB::select("CALL sp_master_type_delete(?)",[$delete->master_type]);
        foreach($result as $result);
        return (array) $result;
    }


    /**
     * |--------------------------------------------------
     * |    MASTER
     * |--------------------------------------------------
     * |
     * |    master list controller functions contains
     * |    Data    - read / select
     * |    Add     - create / insert
     * |    Edit    - modify / update
     * |    Delete  - remove
     */

    public function master_list_data(Request $request)
    {
        /** convert array request to object */
        $get = (object) $request->all();


        /** validate if user has access to this function */
        if(!in_array(2,session()->get('user_access')))
            return abort(403);


        /** execute database sp to get master list
         * @param in_master_type INT
         */
        return DB::select("CALL sp_master_list_data(?,'$get->master_search')",[$get->master_type]);
    }

    public function master_list_deleted()
    {

        /** validate if user has access to this function */
        if(!in_array(2,session()->get('user_access')))
            return abort(403);

        return DB::select("CALL sp_master_list_deleted()");
    }


    public function master_list_add(Request $request)
    {
        /** convert data from array to object */
        $post = (object) $request->all();
        $post = (object) decryptRequest($post);


        /** validate if user has access to this function */
        if(!in_array(5,session()->get('user_access')))
            return abort(403);


        /** check if master type is selected */
        if(in_array($post->master_type,[0,'',null]))
            return [
                "h"=>"Add Master Failed",
                "m"=>"Please select Master type",
                "s"=>"fail",
            ];

        /** check if master name has input */
        if(in_array($post->master_name,['',null]))
            return [
                "h"=>"Add Master Failed",
                "m"=>"Please enter master name",
                "s"=>"fail",
            ];


        /** execute database sp to validate and insert new master
         * @param in_master_type INT
         * @param in_master_name VARCHAR(120)
        */
        $result = DB::select("CALL sp_master_list_add(?,?)",[$post->master_type,$post->master_name]);
        foreach($result as $result)
        return (array) $result;

    }

    public function master_list_edit(Request $request)
    {
        /** convert array to object */
        $put = (Object) $request->all();
        $put = (object) decryptRequest($put);


        /** validate if user has access to this function */
        if(!in_array(7,session()->get('user_access')))
            return abort(403);


        /** validate master name field */
        if(in_array($put->master_name,['',null]))
            return [
                "h"=>"Edit Master Failed",
                "m"=>"Please enter master name",
                "s"=>"fail",
            ];

        /** validate master type field */
        if(in_array($put->master_type,[0,'',null]))
            return [
                "h"=>"Edit Master Failed",
                "m"=>"Please select master type",
                "s"=>"fail",
            ];

        /**
         * @param in_master_id INT
         * @param in_master_name VARCHAR(120)
         * @param in_master_type INT
         */
        $result = DB::select("Call sp_master_list_edit(?,?,?)",[
                    $put->master_id,
                    $put->master_name,
                    $put->master_type
                ]);
        foreach($result as $result);
        return (array) $result;
    }

    public function master_list_delete(Request $request)
    {
        /** convert array to object */
        $delete = (Object) $request->all();
        $delete = (object) decryptRequest($delete);


        /** validate if user has access to this function */
        if(!in_array(9,session()->get('user_access')))
            return abort(403);


        if($delete->master_id == 0)
            return [
                "h"=>"Delete Master Failed",
                "m"=>"Please select master",
                "s"=>"error",
            ];

        /** execute database sp to delete master
         * @param in_master_id INT
         */
        $result = DB::select("CALL sp_master_list_delete(?)",[$delete->master_id]);
        foreach($result as $result);
        return (array) $result;
    }

    public function master_list_recover(Request $request)
    {
        /** convert array to object */
        $put = (object) $request->all();
        $put = (object) decryptRequest($put);


        /** validate if user has access to this function */
        if(!in_array(21,session()->get('user_access')))
            return abort(403);


        /** execute database sp to recover master
         * @param in_master_id INT
         */
        $result = DB::select("CALL sp_master_list_recover(?)",[$put->master_id]);
        foreach($result as $result);
        return (array) $result;

    }

    public function master_type_dump(Request $request)
    {
        /** convert array to object */
        $delete = (Object) $request->all();
        $delete = (object) decryptRequest($delete);


        /** validate if user has access to this function */
        if(!in_array(9,session()->get('user_access')))
            return abort(403);


        if($delete->master_id == 0)
            return [
                "h"=>"Delete Master Failed",
                "m"=>"Please select master",
                "s"=>"error",
            ];

        /** execute database sp to delete master forever
         * @param in_master_id INT
         */
        $result = DB::select("CALL sp_master_type_dump(?)",[$delete->master_id]);
        foreach($result as $result);
        return (array) $result;
    }

}
