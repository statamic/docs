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

        if ($type === 'watch') {
            return $this->renderWatch($node, $childRenderer, $attrs);
        }

        if ($type === 'callout') {
            return $this->renderCallout($node, $childRenderer, $attrs);
        }

        $title = $node->getTitle();
        $title = $title
            ? new HtmlElement(
                'span',
                ['class' => 'hint-title'],
                $title,
            )
            : '';

        $content = new HtmlElement(
            'div',
            ['class' => 'hint-content'],
            $childRenderer->renderBlocks($node->children())
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

    private function renderCallout(Hint $node, ElementRendererInterface $childRenderer, array $attrs)
    {
        $content = new HtmlElement(
            'div',
            ['class' => 'hint-content'],
            $childRenderer->renderBlocks($node->children())
        );

        return new HtmlElement(
            'div',
            $attrs,
            '<a href="'.$node->getTitle().'">' .
            $childRenderer->renderBlocks($node->children()).
            '</a>'
        );
    }

    private function renderWatch(Hint $node, ElementRendererInterface $childRenderer, array $attrs)
    {
        // Grab the first paragraph. There should only be one anyway.
        $content = $node->children()[0];

        $caption = new HtmlElement(
            'p',
            ['class' => 'caption'],
            $childRenderer->renderInlines($content->children())
        );

        return new HtmlElement(
            'div',
            $attrs,
            '<div class="embed">'.
                '<iframe src="'.$node->getTitle().'"></iframe>'.
            '</div>'.
            $caption
        );
    }
}
