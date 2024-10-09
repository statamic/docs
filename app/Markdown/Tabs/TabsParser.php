<?php

namespace App\Markdown\Tabs;

use League\CommonMark\Node\Block\AbstractBlock;
use League\CommonMark\Parser\Block\AbstractBlockContinueParser;
use League\CommonMark\Parser\Block\BlockContinue;
use League\CommonMark\Parser\Block\BlockContinueParserInterface;
use League\CommonMark\Parser\Cursor;

class TabsParser extends AbstractBlockContinueParser implements BlockContinueParserInterface
{
    protected TabbedCodeBlock $tabs;

    public function __construct()
    {
        $this->tabs = new TabbedCodeBlock();
    }

    public function isContainer(): bool
    {
        return true;
    }

    public function canContain(AbstractBlock $childBlock): bool
    {
        return true;
    }

    public function getBlock(): AbstractBlock
    {
        return $this->tabs;
    }

    public function tryContinue(Cursor $cursor, BlockContinueParserInterface $activeBlockParser): ?BlockContinue
    {
        if ($cursor->getLine() === '::') {
            return BlockContinue::finished();
        }

        return BlockContinue::at($cursor);
    }
}
