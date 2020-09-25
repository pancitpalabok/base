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

        $access = [
            [
                "access"=>"main_dashboard",
                "title"=>"Dashboard",
                "view"=>1,
                "sub_access"=>[]
            ],
            [
                "access"=>"main_masterlist",
                "title"=>"Master List",
                "view"=>1,
                "sub_access"=>[

                    [
                        "access"=>"masterlist_add",
                        "title"=>"Master List Add",
                        "view"=>1
                    ],
                    [
                        "access"=>"mastertype_add",
                        "title"=>"Master Type Add",
                        "view"=>1
                    ],

                    [
                        "access"=>"masterlist_edit",
                        "title"=>"Master List Edit",
                        "view"=>1
                    ],
                    [
                        "access"=>"mastertype_edit",
                        "title"=>"Master Type Edit",
                        "view"=>1
                    ],

                    [
                        "access"=>"masterlist_delete",
                        "title"=>"Master List Delete",
                        "view"=>1
                    ],
                    [
                        "access"=>"mastertype_delete",
                        "title"=>"Master Type Delete",
                        "view"=>1
                    ],

                ]
            ],
            [
                "access"=>"main_users",
                "title"=>"Users",
                "view"=>1,
                "sub_access"=>[

                    [
                        "access"=>"userlist_add",
                        "title"=>"User List Add",
                        "view"=>1
                    ],
                    [
                        "access"=>"usertype_add",
                        "title"=>"User Type Add",
                        "view"=>1
                    ],

                    [
                        "access"=>"userlist_edit",
                        "title"=>"User List Edit",
                        "view"=>1
                    ],
                    [
                        "access"=>"usertype_edit",
                        "title"=>"User Type Edit",
                        "view"=>1
                    ],

                    [
                        "access"=>"userlist_delete",
                        "title"=>"User List Delete",
                        "view"=>1
                    ],
                    [
                        "access"=>"usertype_delete",
                        "title"=>"User Type Delete",
                        "view"=>1
                    ],

                    [
                        "access"=>"userlist_access",
                        "title"=>"User List Access",
                        "view"=>1
                    ],
                    [
                        "access"=>"usertype_access",
                        "title"=>"User Type Access",
                        "view"=>1
                    ],

                    [
                        "access"=>"userlist_lock",
                        "title"=>"User List Lock/Unlock",
                        "view"=>1
                    ],

                ]
            ],
            [
                "access"=>"main_setup",
                "title"=>"Setup",
                "view"=>1,
                "sub_access"=>[]
            ],
        ];
        $user_access = [];
        foreach($access as $a)
        {
            foreach($a as $b=>$c) {
                if($b == 'access')
                    $user_access[] = $c;

                if($b == 'sub_access')
                    foreach($c as $d) {
                        foreach($d as $e=>$f){
                            if($e == 'access')
                                $user_access[] = $f;
                        }
                    }

            }

        }
        $user_access = implode(',',$user_access);


        DB::table('atb_user_type')
            ->where('user_type','=',"1")
            ->update(['user_access'=>$user_access]);

        // echo json_encode($access,JSON_PRETTY_PRINT);
        DB::table('atb_setup')->update(['setup_access_data'=>json_encode($access)]);

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
