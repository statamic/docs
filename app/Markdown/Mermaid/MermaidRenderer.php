<?php

namespace App\Markdown\Mermaid;

use InvalidArgumentException;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;
use Stringable;

class MermaidRenderer implements NodeRendererInterface
{
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): string|Stringable|null
    {
        if (! $node instanceof FencedCode) {
            throw new InvalidArgumentException('Block must be instance of '.FencedCode::class);
        }

        $language = $node->getInfoWords()[0] ?? null;

        if ($language !== 'mermaid') {
            return null;
        }

        $code = htmlspecialchars(rtrim($node->getLiteral(), "\n"));

        return new HtmlElement('pre', ['class' => 'mermaid'], $code);
    }
}
