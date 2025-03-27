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
        isset($attrs['class']) ? $attrs['class'] .= ' hint' : $attrs['class'] = 'c-tip';

        if ($type = $node->getType()) {
            $attrs['class'] = isset($attrs['class']) ? $attrs['class'].' ' : '';
            $attrs['class'] .= $type.' c-tip--'.$type;
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

        $content = $childRenderer->renderNodes($node->children());
        
        // Add mascot image for tips and best practices
        $mascot = in_array($type, ['tip', 'hint', 'best-practice', 'warning'])
            ? '<img src="/img/tip-troll.webp" class="c-tip__mascot" alt="A troll pointing a teaching stick" width="242" height="293" />' 
            : '';

        return new HtmlElement(
            'div',
            $attrs,
            "\n".
            $title."\n".
            $content.
            $mascot.
            "\n"
        );
    }

    private function renderWatch(Hint $node, ChildNodeRendererInterface $childRenderer, array $attrs)
    {
        $caption = new HtmlElement(
            'div',
            ['class' => 'caption'],
            $childRenderer->renderNodes($node->children())
        );

        return new HtmlElement(
            'div',
            $attrs,
            '<figure class="c-video">'.
                '<iframe src="'.$node->getTitle().'"></iframe>'.
                '<figcaption>'.$caption.'</figcaption>'.
            '</figure>'
        );
    }
}
