<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterListController extends Controller
{
    public function index()
    {
        return view("master.index");
    }

    // ----------------------------------------------------------------------------------MASTER TYPE

    public function master_type_data()
    {
        /** get data from database  */
        return DB::select("CALL sp_master_type_data()");
    }

    public function master_type_add(Request $request)
    {
        /** convert array to object */
        $post =  (object) $request->all();

        /** check master type name as input */
        if($post->master_type_name == '') return [
                "h"=>"Add Master Type Failed",
                "m"=>"Please enter master type name",
                "s"=>"fail",
            ];

        /** execute database sp to validate and insert new master type */
        $result = DB::select("CALL sp_master_type_add(?)",[$post->master_type_name]);
        foreach($result as $result)
        return (array) $result;
    }


    // ----------------------------------------------------------------------------------MASTER

    public function master_list_data(Request $request)
    {
        /** convert array request to object */
        $get = (object) $request->all();

        /** execute database sp to get master list
         * @param in_master_type INT
         */
        return DB::select("CALL sp_master_list_data(?)",[$get->master_type]);
    }


    public function master_list_add(Request $request)
    {
        /** convert data from array to object */
        $post = (object) $request->all();


        /** check if master type is selected */
        if(in_array($post->master_type,[0,'',null])) return [
                "h"=>"Add Master Failed",
                "m"=>"Please select Master type",
                "s"=>"fail",
            ];

        /** check if master name has input */
        if(in_array($post->master_name,['',null])) return [
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

    public function master_list_delete(Request $request)
    {
        $delete = (Object) $request;

        $result = DB::select("CALL sp_master_list_delete(?)",[$delete->master_id]);
        foreach($result as $result);
        return (array) $result;
    }

}
