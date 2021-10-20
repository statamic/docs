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

        $fence = $cursor->match('/^(:::)(?:.+)$/');

        if ($fence === null) {
            return false;
        }

        [$type, $heading] = array_pad(explode(' ', substr($fence, 3), 2), 2, '');

        $context->addBlock(new Hint($type, $heading));

        return true;
    }
}
