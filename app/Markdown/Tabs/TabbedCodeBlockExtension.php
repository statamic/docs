<?php

namespace App\Markdown\Tabs;

use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\ExtensionInterface;

class TabbedCodeBlockExtension implements ExtensionInterface
{
    public function register(EnvironmentBuilderInterface $environment): void
    {
        $environment->addBlockStartParser(new TabbedCodeStartParser());
        $environment->addRenderer(TabbedCodeBlock::class, new TabsRenderer());
    }
}
