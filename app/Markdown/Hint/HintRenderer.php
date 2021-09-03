<?php

namespace App\Markdown\Hint;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;

final class HintRenderer implements BlockRendererInterface
{
    public function render(AbstractBlock $node, ElementRendererInterface $childRenderer, bool $inTightList = false)
    {
        if (!($node instanceof Hint)) {
            throw new \InvalidArgumentException('Incompatible block type: ' . \get_class($node));
        }

        $attrs = $node->getData('attributes');
        isset($attrs['class']) ? $attrs['class'] .= ' hint' : $attrs['class'] = 'hint';

        if ($type = $node->getType()) {
            $attrs['class'] = isset($attrs['class']) ? $attrs['class'] . ' ' : '';
            $attrs['class'] .= $type;
        }

        $title = $node->getTitle();
        $title = $title
            ? new HtmlElement(
                'h2',
                ['class' => 'hint-title'],
                $title,
            )
            : '';

        $content = new HtmlElement(
            'p',
            ['class' => 'hint-content'],
            $childRenderer->renderInlines($node->children())
        );

        return new HtmlElement(
            'div',
            $attrs,
            "\n" .
            $title . "\n" .
            $content .
            "\n"
        );
    }
}
