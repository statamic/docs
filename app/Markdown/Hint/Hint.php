<?php

namespace App\Markdown\Hint;

use League\CommonMark\Node\Block\AbstractBlock;
use League\CommonMark\Node\StringContainerInterface;

class Hint extends AbstractBlock implements StringContainerInterface
{
    private ?string $header = 'Hot Tip!';

    protected string $literal;

    public function getTitle(): ?string
    {
        $words = $this->getHeaderWords();

        if (count($words) > 1) {

            array_shift($words);
            return join(' ', $words);
        }

        if ($words[0] === 'tip') {
            return 'Hot Tip!';
        }

        if ($words[0] === 'warning') {
            return 'Warning!';
        }

        if ($words[0] === 'best-practice') {
            return 'Best Practice';
        }

        return null;
    }

    public function getType(): ?string
    {
        $words = $this->getHeaderWords();

        if (count($words) > 0) {
            return $words[0];
        }

        return null;
    }

    public function getHeaderWords(): array
    {
        // dd($this->header);
        return \preg_split('/\s+/', $this->header ?? '') ?: [];
    }

    public function setHeader($header)
    {
        $this->header = $header;
    }

    public function setLiteral(string $literal): void
    {
        $this->literal = $literal;
    }

    public function getLiteral(): string
    {
        return $this->literal;
    }
}
