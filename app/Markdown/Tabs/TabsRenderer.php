<?php

namespace App\Markdown\Tabs;

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

        $attrs['class'] = 'doc-tabs';

        $codeSamples = [];

        $currentTab = [];
        $lastCodeSampleLanguage = '';
        foreach ($node->children() as $child) {

            if ($child instanceof FencedCode) {
                $lastCodeSampleLanguage = mb_strtoupper($child->getInfo());
            }

            if ($child instanceof Paragraph && $child->firstChild() instanceof Text) {
                /** @var Text $text */
                $text = $child->firstChild();

                if ($text->getLiteral() === '::sep') {
                    $codeSamples[$lastCodeSampleLanguage] = $childRenderer->renderNodes($currentTab);
                    $currentTab = [];

                    continue;
                }
            }

            $currentTab[] = $child;
        }

        if (count($currentTab)) {
            $codeSamples[$lastCodeSampleLanguage] = $childRenderer->renderNodes($currentTab);
            $currentTab = [];
        }

        $sampleNames = [];

        foreach ($codeSamples as $language => $sample) {
            if (array_key_exists($language, $this->languageNames)) {
                $sampleNames[$language] = $this->languageNames[$language];

                continue;
            }

            $sampleNames[$language] = mb_strtoupper($language);
        }

        return new HtmlElement(
            'div',
            $attrs,
            view('tabs', ['tabs' => $sampleNames, 'samples' => $codeSamples, 'active' => array_keys($codeSamples)[0]])->render()
        );
    }
}
