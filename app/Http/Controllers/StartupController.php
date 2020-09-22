<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StartupController extends Controller
{
    public function index()
    {

        /*
            Format for Navigation.php

            HEADER SIDE BAR
            --------------------------------
            (object) [
                'type'=>'header',
                'title'=>'SETTINGS',
            ],


            BASIC SIDE BAR
            --------------------------------
            (object) [
                'type'=>'link',
                'status'=>'active',
                'title'=>'Dashboard',
                'icon'=>'tachometer-alt',
                'link'=>route('dashboard.index')
            ],


            MULTI LEVEL SIDE BAR
            -------------------------------

            (object) [
                'type'=>'tree',
                'title'=>"Events",
                'icon'=>'calendar-day',
                'items'=> [
                    (object) [
                        'link'=>route('events.index','details'),
                        'icon'=>'list',
                        'title'=>'Event List',
                    ],
                ],
            ],
        */


        $side = [
            (object) [  // DEFAULT
                'type'=>'link',
                'status'=>'active',
                'title'=>'Dashboard',
                'icon'=>'tachometer-alt',
                'link'=>route('dashboard.index'),
                'access'=>'access_dashboard',
            ],


            /*   DEFAULT SETUP NAVIGATION  */

            (object) [
                'type'=>'header',
                'title'=>'SETTINGS',
                'access'=>''
            ],
            (object) [
                'type'=>'link',
                'title'=>'Master List',
                'icon'=>'th-list',
                'link'=>route('dashboard.index'),
                'access'=>'access_master_list',
            ],
            (object) [
                'type'=>'link',
                'title'=>'Users',
                'icon'=>'users',
                'link'=>route('users.index'),
                'access'=>'access_users',
            ],
            (object) [
                'type'=>'link',
                'title'=>'Setup',
                'icon'=>'cogs',
                'link'=>route('dashboard.index'),
                'access'=>'access_settings',
            ],


        ];

        return view('blocks.master',compact('side'));
    }
}
