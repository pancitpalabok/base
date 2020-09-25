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
    public $access_setup;
    public function __construct($method,$data = [],$validator=0)
    {
        $this->method = $method;
        $this->validator = $validator;
        $this->data = $data;    

        $this->access_setup = json_decode(DB::table('atb_setup')->select('setup_access_data')->first()->setup_access_data,true);
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
