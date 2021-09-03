<?php

namespace App\Markdown\Hint;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Element\AbstractStringContainerBlock;
use League\CommonMark\ContextInterface;
use League\CommonMark\Cursor;
use League\CommonMark\Util\RegexHelper;

class Hint extends AbstractStringContainerBlock
{
    private ?string $header = '';

    public function canContain(AbstractBlock $block): bool
    {
        return false;
    }

    public function isCode(): bool
    {
        return false;
    }

    public function matchesNextLine(Cursor $cursor): bool
    {
        return true;
    }

    public function handleRemainingContents(ContextInterface $context, Cursor $cursor)
    {
        $cursor->advanceToNextNonSpaceOrTab();
        $cursor->advanceBySpaceOrTab();

        if ($cursor->getLine() === ':::') {
            return $this->finalize($context, $context->getLineNumber());
        }

        $tip = $context->getTip();
        $tip->addLine($cursor->getRemainder());
    }

    public function getTitle(): ?string
    {
        $words = $this->getHeaderWords();

        if (count($words) > 1) {
            array_shift($words);

            return join(' ', $words);
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
        return \preg_split('/\s+/', $this->header ?? '') ?: [];
    }

    public function setHeader($header)
    {
        $this->header = $header;
    }

    public function finalize(ContextInterface $context, int $lineNumber)
    {
        parent::finalize($context, $lineNumber);

        // first line becomes info string
        $firstLine = $this->strings->first();
        if ($firstLine === false) {
            $firstLine = '';
        }

        $this->setHeader(RegexHelper::unescape(\trim($firstLine)));

        if ($this->strings->count() === 1) {
            $this->finalStringContents = '';
        } else {
            $this->finalStringContents = \implode("\n", $this->strings->slice(1)) . "\n";
        }
    }
}
