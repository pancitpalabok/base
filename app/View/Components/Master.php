<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Master extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $method = "";
    public $data = [];
    public function __construct($method,$data = [])
    {
        $this->method = $method;
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
        return view("master.master-$this->method",compact('data'));
    }
}
