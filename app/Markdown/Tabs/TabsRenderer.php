<?php

namespace App\Markdown\Tabs;

use Illuminate\Support\Str;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Node\Block\Paragraph;
use League\CommonMark\Node\Inline\Text;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;

class TabsRenderer implements NodeRendererInterface
{
    protected array $languageNames = [
        'blade' => 'Blade',
        'antlers' => 'Antlers',
        'php' => 'PHP',
    ];

    public function render(Node $node, ChildNodeRendererInterface $childRenderer)
    {
        TabbedCodeBlock::assertInstanceOf($node);

        $attrs = $node->data->get('attributes');

        $attrs['class'] = 'c-doc-tabs';

        $tabs = [];

        $currentTab = [];
        $tabNameSetManually = false;
        $lastTabName = '';

        foreach ($node->children() as $child) {

            if ($child instanceof FencedCode && ! $tabNameSetManually) {
                $lastTabName = mb_strtoupper($child->getInfo());
            }

            if ($child instanceof Paragraph && $child->firstChild() instanceof Text) {
                /** @var Text $text */
                $text = $child->firstChild();

                if (Str::startsWith($text->getLiteral(), '::tab')) {
                    $renderedContent = $childRenderer->renderNodes($currentTab);
                    $currentTab = [];

                    $extra = trim(mb_substr($text->getLiteral(), 5));

                    $currentTabName = $lastTabName;

                    if (mb_strlen($extra) > 0) {
                        $lastTabName = $extra;
                        $tabNameSetManually = true;
                    } else {
                        $tabNameSetManually = false;
                    }

                    if (mb_strlen(strip_tags($renderedContent)) == 0) {
                        continue;
                    }

                    $tabs[$currentTabName] = $renderedContent;

                    continue;
                }
            }

            $currentTab[] = $child;
        }

        if (count($currentTab)) {
            $tabs[$lastTabName] = $childRenderer->renderNodes($currentTab);
            $currentTab = [];
        }

        $sampleNames = [];

        foreach ($tabs as $language => $sample) {
            if (array_key_exists($language, $this->languageNames)) {
                $sampleNames[$language] = $this->languageNames[$language];

                continue;
            }

            $sampleNames[$language] = mb_strtoupper($language);
        }

        return new HtmlElement(
            'div',
            $attrs,
            view('tabs', ['tabs' => $sampleNames, 'samples' => $tabs, 'active' => array_keys($tabs)[0]])->render()
        );
    }
}
