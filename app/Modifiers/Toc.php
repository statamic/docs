<?php

namespace App\Modifiers;

use Statamic\Modifiers\Modifier;

class Toc extends Modifier
{
    private $context;

    /**
     * Modify a value
     *
     * @param mixed  $value    The value to be modified
     * @param array  $params   Any parameters used in the modifier
     * @param array  $context  Contextual values
     * @return mixed
     */
    public function index($value, $params, $context)
    {
        $this->context = $context;

        $creatingIds = array_get($params, 0) == 'ids';

        list($toc, $content) = $this->create($value, $creatingIds ? 5 : 3);

        return $creatingIds ? $content : $toc;
    }

    // Good golly this thing is ugly.
    private function create($content, $maxHeadingLevels)
    {
        preg_match_all('/<h([1-'.$maxHeadingLevels.'])([^>]*)>(.*)<\/h[1-'.$maxHeadingLevels.']>/i', $content, $matches, PREG_SET_ORDER);

        if (! $matches) {
            return [null, $content];
        }

        global $anchors;

        $anchors = array();
        $toc = '<ol class="toc">'."\n";
        $i = 0;

        // Wangjangle params, vars, and options in there.
        $matches = $this->appendDetails($matches);

        foreach ($matches as $heading) {
            if ($i == 0) {
                $startlvl = $heading[1];
            }

            $lvl = $heading[1];

            $ret = preg_match('/id=[\'|"](.*)?[\'|"]/i', stripslashes($heading[2]), $anchor);

            if ($ret && $anchor[1] != '') {
                $anchor = trim(stripslashes($anchor[1]));
                $add_id = false;
            } else {
                $anchor = preg_replace('/\s+/', '-', trim(preg_replace('/[^a-z\s]/', '', strtolower(strip_tags($heading[3])))));
                $add_id = true;
            }

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

            if ($add_id) {
                $content = substr_replace($content, '<h'.$lvl.' id="'.$anchor.'"'.$heading[2].'>'.$heading[3].'</h'.$lvl.'>', strpos($content, $heading[0]), strlen($heading[0]));
            }

            $ret = preg_match('/title=[\'|"](.*)?[\'|"]/i', stripslashes($heading[2]), $title);

            if ($ret && $title[1] != '') {
                $title = stripslashes($title[1]);
            } else {
                $title = $heading[3];
            }

            $title = trim(strip_tags($title));

            if ($i > 0) {
                if ($prevlvl < $lvl) {
                    $toc .= "\n"."<ol>"."\n";
                } elseif ($prevlvl > $lvl) {
                    $toc .= '</li>'."\n";
                    while ($prevlvl > $lvl) {
                        $toc .= "</ol>"."\n".'</li>'."\n";
                        $prevlvl--;
                    }
                } else {
                    $toc .= '</li>'."\n";
                }
            }

            $j = 0;
            $toc .= '<li><a href="#'.$anchor.'">'.$title.'</a>';
            $prevlvl = $lvl;

            $i++;
        }

        unset($anchors);

        while ($lvl > $startlvl) {
            $toc .= "\n</ol>";
            $lvl--;
        }

        $toc .= '</li>'."\n";
        $toc .= '</ol>'."\n";

        // A tiny TOC is a lame TOC
        $toc = (count($matches) < 3) ? null : $toc;

        return [$toc, $content];
    }

    private function valueGet($value)
    {
        if ($value instanceof \Statamic\Fields\Value) {
            return $value->value();
        }

        return $value;
    }

    private function appendDetails($matches)
    {
        $parameters = $this->valueGet($this->context['parameters'] ?? null);

        if ($parameters && count($parameters) > 0) {
            $matches[] = [
                '<h2 id="parameters">Parameters</h2>',
                '2',
                ' id="parameters"',
                'Parameters'
            ];
        }

        $variables = $this->valueGet($this->context['variables'] ?? null);

        if ($variables && count($variables) > 0) {
            $matches[] = [
                '<h2 id="variables">Variables</h2>',
                '2',
                ' id="variables"',
                'Variables'
            ];
        }

        $options = $this->valueGet($this->context['options'] ?? null);

        if ($options && count($options) > 0) {
            $matches[] = [
                '<h2 id="options">Options</h2>',
                '2',
                ' id="options"',
                'Options'
            ];
        }

        return $matches;
    }
}
