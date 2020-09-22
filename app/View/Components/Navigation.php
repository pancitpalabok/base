<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Navigation extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $type;
    public $navigation;

    public function __construct($type,$navigation = [])
    {
        $this->type = $type;
        $this->navigation = $navigation;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */


    public function render()
    {
        switch ($this->type)
        {
            case 'top':
                return view("blocks.".$this->type."-navigation");
                break;
            case 'side':
                $navigation = $this->navigation;
                return view("blocks.".$this->type."-navigation",compact('navigation'));
                break;
        }
    }
}
