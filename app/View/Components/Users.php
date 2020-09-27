<?php

namespace App\View\Components;

use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class Users extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $method;
    public $validator;
    public $data = [];
    public $user_access;
    public function __construct($method,$data = [],$validator=0)
    {
        $this->method = $method;
        $this->validator = $validator;
        $this->data = $data;

        $db_access = DB::table('atb_user_access')->get();
        $user_access = [];
        foreach($db_access as $access)
        {
            if($access->access_parent == 0) {
                $user_access[$access->access_id] = $access;
                continue;
            }
            $user_access[$access->access_parent]->sub_access[] = $access;

        }

        $this->user_access = $user_access;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $data = (object) $this->data;
        return view("users.users-$this->method",compact('data'));
    }
}
