<?php

namespace Tests\Unit;

use Statamic\Facades\Markdown;
use Tests\TestCase;

class StripEnvTrailingNewlinesTest extends TestCase
{
    public function test_env_block_does_not_render_a_trailing_blank_line(): void
    {
        $html = (string) Markdown::parse(<<<'MD'
```env
FORMS_PRO_ADDRESS_AUTOCOMPLETE_PROVIDER=google # or: geoapify
FORMS_PRO_ADDRESS_AUTOCOMPLETE_KEY=your-key
```
MD);

        $this->assertStringContainsString('your-key</span>', $html);
        $this->assertStringNotContainsString("your-key\n</span>", $html);
    }
}
