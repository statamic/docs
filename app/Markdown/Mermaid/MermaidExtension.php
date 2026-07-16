<?php

namespace App\Markdown\Mermaid;

use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Extension\ExtensionInterface;

class MermaidExtension implements ExtensionInterface
{
    public function register(EnvironmentBuilderInterface $environment): void
    {
        // Higher priority than Torchlight's renderer, so mermaid
        // blocks are rendered as diagrams instead of highlighted code.
        $environment->addRenderer(FencedCode::class, new MermaidRenderer, 20);
    }
}
