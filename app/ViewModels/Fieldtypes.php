<?php

namespace App\ViewModels;

use Statamic\View\ViewModel;

class Fieldtypes extends ViewModel
{
    public function data(): array
    {
        $data = ['title' => ucwords($this->cascade->get('title')) . ' Fieldtype'];

        if ($this->cascade->get('options')) {
            $data['content'] = $this->cascade->get('content') . "\n\n <h2 id=\"options\">Options</h2>";
        }

        return $data;
    }
}
