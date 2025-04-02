<?php

namespace App\Torchlight;

use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use Torchlight\Engine\CommonMark\BlockCache;
use Torchlight\Engine\Engine;

class TorchlightCache implements BlockCache
{
    private function cache()
    {
        $store = config('torchlight.cache');

        if (! $store) {
            return cache();
        }

        return cache()->store($store);
    }

    protected function getCacheKey(FencedCode $node): string
    {
        return sha1(implode('', [
            implode('', $node->getInfoWords()),
            $node->getLiteral(),
            Engine::VERSION,
        ]));
    }

    public function has(FencedCode $node): bool
    {
        return $this->cache()->has($this->getCacheKey($node));
    }

    public function get(FencedCode $node): string
    {
        return $this->cache()->get($this->getCacheKey($node));
    }

    public function set(FencedCode $node, string $result): void
    {
        $seconds = config('torchlight.cache_seconds', 7 * 24 * 60 * 60);
        $key = $this->getCacheKey($node);

        if (is_null($seconds)) {
            $this->cache()->forever($key, $result);
        } else {
            $this->cache()->put($key, $result, (int) $seconds);
        }
    }
}
