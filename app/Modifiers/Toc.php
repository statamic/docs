<?php

namespace App\Modifiers;

use Illuminate\Support\Arr;
use Statamic\Modifiers\Modifier;
use Statamic\Statamic;

class Toc extends Modifier
{
    private $context;

    /**
     * Modify a value
     *
     * @param  mixed  $value  The value to be modified
     * @param  array  $params  Any parameters used in the modifier
     * @param  array  $context  Contextual values
     * @return mixed
     */
    public function index($value, $params, $context)
    {
        $this->context = $context;

        $creatingIds = Arr::get($params, 0) == 'ids';

        // Here maxHeadingLevels is set to either 5 (when creating IDs) or 3 (for TOC)
        [$toc, $content] = $this->create($value, $creatingIds ? 5 : 3);

        return $creatingIds ? $content : $toc;
    }

    // Good golly this thing is ugly.
    private function create($content, $maxHeadingLevels)
    {
        // First try with h2-hN headings
        preg_match_all('/<h([2-'.$maxHeadingLevels.'])([^>]*)>(.*)<\/h[2-'.$maxHeadingLevels.']>/i', $content, $matches, PREG_SET_ORDER);

        // If we don't have enough entries, include h1 headings as well
        if (count($matches) < 3) {
            preg_match_all('/<h([1-'.$maxHeadingLevels.'])([^>]*)>(.*)<\/h[1-'.$maxHeadingLevels.']>/i', $content, $matches, PREG_SET_ORDER);
        }

        if (! $matches) {
            return [null, $content];
        }

        // Track unique anchor IDs across the document
        global $anchors;
        $anchors = [];

        // Initialize TOC with an unordered list
        $toc = '<ul class="o-scroll-spy-timeline__toc js__scroll-spy-toc">'."\n";
        $i = 0;
        $tiCounter = 1; // Add counter for --ti values

        foreach ($matches as $heading) {
            // Track the starting heading level for proper list nesting
            if ($i == 0) {
                $startlvl = ($heading[1] == '1') ? '2' : $heading[1];
            }

            // Normalize h1 to same level as h2
            $lvl = ($heading[1] == '1') ? '2' : $heading[1];

            // Check if heading already has an ID attribute
            $ret = preg_match('/id=[\'|"](.*)?[\'|"]/i', stripslashes($heading[2]), $anchor);

            if ($ret && $anchor[1] != '') {
                $anchor = $this->slugify($heading[1]);
                $add_id = false;
            } else {
                // Generate an ID from the heading text
                $anchor = $this->slugify($heading[3]);
                $add_id = true;
            }
            // Ensure anchor ID is unique by adding numeric suffixes if needed
            if (! in_array($anchor, $anchors)) {
                $anchors[] = $anchor;
            } else {
                $orig_anchor = $anchor;
                $i = 2;
                while (in_array($anchor, $anchors)) {
                    $anchor = $orig_anchor.'-'.$i;
                    $i++;
                }
                $anchors[] = $anchor;
            }

            // Add ID to the heading in content if it didn't have one
            if ($add_id) {
                $content = substr_replace($content, '<h'.$lvl.' id="'.$anchor.'"'.$heading[2].'>'.$heading[3].'</h'.$lvl.'>', strpos($content, $heading[0]), strlen($heading[0]));
            }

            // Extract title from title attribute or use heading text
            $ret = preg_match('/title=[\'|"](.*)?[\'|"]/i', stripslashes($heading[2]), $title);

            if ($ret && $title[1] != '') {
                $title = stripslashes($title[1]);
            } else {
                $title = $heading[3];
            }

            $title = trim(strip_tags($title));

            // Handle nested list structure based on heading levels
            if ($i > 0) {
                if ($prevlvl < $lvl) {
                    // Start a new nested list wrapped in li, don't increment counter for parent li
                    $toc .= "\n".'<li><ul>'."\n";
                } elseif ($prevlvl > $lvl) {
                    // Close current item and any nested lists
                    $toc .= '</li>'."\n";
                    while ($prevlvl > $lvl) {
                        $toc .= '</ul></li>'."\n".'</li>'."\n";
                        $prevlvl--;
                    }
                } else {
                    // Close current item at same level
                    $toc .= '</li>'."\n";
                }
            }

            // Add TOC entry with --ti style (only for leaf nodes)
            $toc .= '<li style="--ti: --'.$tiCounter.'"><a href="#'.$anchor.'" class="u-line-clamp" style="--clamp: 1;">'.$title.'</a>';
            $tiCounter++;

            $prevlvl = $lvl;

            $i++;
        }

        unset($anchors);

        while ($lvl > $startlvl) {
            $toc .= "\n</ul>";
            $lvl--;
        }

        $toc .= '</li>'."\n";
        $toc .= '</ul>'."\n";

        return [$toc, $content];
    }

    /**
     * Safely extracts value from Statamic Value objects
     */
    private function valueGet($value)
    {
        if ($value instanceof \Statamic\Fields\Value) {
            return $value->value();
        }

        return $value;
    }

    private function slugify($text)
    {
        return Statamic::modify($text)->replace('&amp;', '')->slugify()->stripTags();
    }
}
