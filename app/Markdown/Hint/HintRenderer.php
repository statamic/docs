<?php

namespace App\Markdown\Hint;

use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;

final class HintRenderer implements NodeRendererInterface
{
    /**
     * @param  Hint  $node
     *
     * {@inheritDoc}
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): \Stringable
    {
        Hint::assertInstanceOf($node);

        $attrs = $node->data->get('attributes');
        isset($attrs['class']) ? $attrs['class'] .= ' hint' : $attrs['class'] = 'hint';

        if ($type = $node->getType()) {
            $attrs['class'] = isset($attrs['class']) ? $attrs['class'].' ' : '';
            $attrs['class'] .= $type;
        }

        if ($type === 'watch') {
            return $this->renderWatch($node, $childRenderer, $attrs);
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
            'p',
            ['class' => 'hint-content'],
            $childRenderer->renderNodes($node->children())
        );

        return new HtmlElement(
            'div',
            $attrs,
            "\n".
            $title."\n".
            $content.
            "\n"
        );
    }

    private function renderWatch(Hint $node, ChildNodeRendererInterface $childRenderer, array $attrs)
    {
        $caption = new HtmlElement(
            'p',
            ['class' => 'caption'],
            $childRenderer->renderNodes($node->children())
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
