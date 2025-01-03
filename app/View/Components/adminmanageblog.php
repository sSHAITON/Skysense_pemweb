<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Collection;

class Adminmanageblog extends Component
{
    public $posts;

    public function __construct($posts = null)
    {
        $this->posts = $posts ?? collect();
    }

    public function render()
    {
        return view('components.adminmanageblog');
    }
}
