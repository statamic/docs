<?php

namespace App\ViewModels;

use Statamic\View\ViewModel;

class Tags extends ViewModel
{
    public function data(): array
    {
        return ['title' => ucwords($this->cascade->get('slug')).' Tag'];
    }
}
