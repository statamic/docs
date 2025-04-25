<?php

namespace App\ViewModels;

use Statamic\View\ViewModel;

class Variables extends ViewModel
{
    public function data(): array
    {
        return ['title' => strtolower($this->cascade->get('slug'))];
    }
}
