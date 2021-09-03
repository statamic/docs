<?php

namespace App\Markdown\Hint;

use League\CommonMark\ConfigurableEnvironmentInterface;
use League\CommonMark\Extension\ExtensionInterface;

class HintExtension implements ExtensionInterface
{
    public function register(ConfigurableEnvironmentInterface $environment): void
    {
        $environment->addBlockParser(new HintParser());
        $environment->addBlockRenderer(Hint::class, new HintRenderer());
    }
}
