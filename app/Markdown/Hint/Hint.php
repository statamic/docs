<?php

namespace App\Markdown\Hint;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Cursor;

class Hint extends AbstractBlock
{
    protected $type;
    protected $title;

    public function __construct($type, $title)
    {
        $this->type = $type;
        $this->title = $title;
    }

    public function canContain(AbstractBlock $block): bool
    {
        return true;
    }

    public function isCode(): bool
    {
        return false;
    }

    public function matchesNextLine(Cursor $cursor): bool
    {
        if ($cursor->match('/^:::$/')) {
            return false;
        }

        return true;
    }

    public function getTitle(): ?string
    {
        if ($this->title) {
            return $this->title;
        }

        if ($this->type === 'warning') {
            return 'Warning!';
        }

        if ($this->type === 'best-practice') {
            return 'Best Practice';
        }

        return 'Hot Tip!';
    }

    public function getType(): ?string
    {
        return $this->type;
    }
}
