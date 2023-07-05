<?php

namespace App\Markdown\Hint;

use League\CommonMark\Parser\Block\BlockStart;
use League\CommonMark\Parser\Block\BlockStartParserInterface;
use League\CommonMark\Parser\Cursor;
use League\CommonMark\Parser\MarkdownParserStateInterface;

class HintStartParser implements BlockStartParserInterface
{
    public function tryStart(Cursor $cursor, MarkdownParserStateInterface $parserState): ?BlockStart
    {
        if ($cursor->isIndented()) {
            return BlockStart::none();
        }

        $fence = $cursor->match('/^(?:\:{3,}(?!.*`))/');
        if ($fence === null) {
            return BlockStart::none();
        }

        return BlockStart::of(new HintParser())->at($cursor);
    }
}
