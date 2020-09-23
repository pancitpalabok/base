<?php

namespace App\View\Components;

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

    public function __construct($method,$data = [],$validator=0)
    {
        $this->method = $method;
        $this->validator = $validator;
        $this->data = $data;

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
