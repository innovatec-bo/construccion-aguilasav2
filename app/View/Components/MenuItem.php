<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class MenuItem extends Component
{
    public $item;
    public $isActive;
    public $isOpen;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($item)
    {
        $this->item = $item;
        $this->isActive = FALSE;
        $this->isOpen = FALSE;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $this->setActive();
        return view('components.menu-item');
    }

    public function setActive()
    {
        if (!isset($this->item['header']))
        {
            if(isset($this->item['url']))
            {

            }
            else
            {
                if(isset($this->item['submenu']))
                {
                    foreach ($this->item['submenu'] as $subItem) 
                    {   
                        if(strpos(Route::currentRouteName(), $subItem['route']) !== FALSE)
                        {
                            $this->isActive = TRUE;
                            $this->isOpen = TRUE;
                            break;
                        }    
                        else
                        {
                            $this->isActive = FALSE;
                            $this->isOpen = FALSE;
                        }
                    }
                }
                else
                {
                    if(strpos(Route::currentRouteName(), $this->item['route']) !== FALSE)
                    {
                        $this->isActive = TRUE;
                    }
                }
            }
        } 
    }
}
