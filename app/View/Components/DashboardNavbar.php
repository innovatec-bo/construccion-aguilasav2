<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class DashboardNavbar extends Component
{
    public $user;
    public $abbreviature;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->user = Auth::user();
        $this->abbreviature = strtoupper(substr($this->user->firstname_usr, 0, 1).substr($this->user->lastname_usr, 0, 1));
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard-navbar');
    }
}