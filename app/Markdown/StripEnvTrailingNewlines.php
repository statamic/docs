<?php

namespace App\Markdown;

use Torchlight\Engine\Contracts\Preprocessor;
use Torchlight\Engine\Engine;
use Torchlight\Engine\Preprocessors\PreprocessorArgs;

class StripEnvTrailingNewlines implements Preprocessor
{
    /**
     * Torchlight's env grammar uses `([^#]*)` for unquoted values, which
     * swallows the newline Phiki appends to every line. That leaves
     * `value\n` + a second `\n` token — a blank line at the end of the block.
     */
    public function process(PreprocessorArgs $args, Engine $engine): array
    {
        foreach ($args->tokens as $line) {
            foreach ($line as $token) {
                if (! in_array('string.unquoted.env', $token->scopes, true)) {
                    continue;
                }

                if (str_ends_with($token->text, "\n")) {
                    $token->text = substr($token->text, 0, -1);
                }
            }
        }

        return $args->tokens;
    }
}
