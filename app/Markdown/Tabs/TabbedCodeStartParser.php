<?php

namespace App\Markdown\Tabs;

use League\CommonMark\Parser\Block\BlockStart;
use League\CommonMark\Parser\Block\BlockStartParserInterface;
use League\CommonMark\Parser\Cursor;
use League\CommonMark\Parser\MarkdownParserStateInterface;

class TabbedCodeStartParser implements BlockStartParserInterface
{
    public function tryStart(Cursor $cursor, MarkdownParserStateInterface $parserState): ?BlockStart
    {
        if ($cursor->isIndented()) {
            return BlockStart::none();
        }

        $fence = $cursor->match('/^(?:\:{2,}tabs)/');

        if ($fence === null) {
            return BlockStart::none();
        }

        $headerText = $cursor->getRemainder();

        $cursor->advanceToEnd();

        return BlockStart::of(new TabsParser())->at($cursor);
    }
}
