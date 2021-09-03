<?php

namespace App\Markdown\Hint;

use League\CommonMark\Block\Parser\BlockParserInterface;
use League\CommonMark\ContextInterface;
use League\CommonMark\Cursor;

class HintParser implements BlockParserInterface
{
    public function parse(ContextInterface $context, Cursor $cursor): bool
    {
        if ($cursor->isIndented()) {
            return false;
        }

        if ($cursor->getLine() === ':::') {
            return false;
        }

        $fence = $cursor->match('/^(?:\:{3,}(?!.*`))/');
        if ($fence === null) {
            return false;
        }

        $context->addBlock(new Hint);

        return true;
    }
}
