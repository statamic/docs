<?php

namespace App\ViewModels;

use Statamic\View\ViewModel;

class Fieldtypes extends ViewModel
{
    public function data(): array
    {
        return ['title' => ucwords($this->cascade->get('title')) . ' Fieldtype'];
    }
}
