<?php

namespace App\ViewModels;

use Statamic\View\ViewModel;

class Modifiers extends ViewModel
{
    public function data(): array
    {
        return ['title' =>  ucwords($this->cascade->get('slug')) . ' Modifier'];
    }
}
