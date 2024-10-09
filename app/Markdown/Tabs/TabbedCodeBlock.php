<?php

namespace App\Markdown\Tabs;

use League\CommonMark\Node\Block\AbstractBlock;

class TabbedCodeBlock extends AbstractBlock
{
    // You can store code snippets for each tab here
    protected $codeSamples = [];

    public function addCodeSample($language, $code)
    {
        $this->codeSamples[$language] = $code;
    }

    public function getCodeSamples()
    {
        return $this->codeSamples;
    }
}
