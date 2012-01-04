<?php

namespace Taggle\Normalizer;

class FileName implements \Taggle\Normalizer {

    private $top_level;
    
    function __construct(array $top_level = array()) {
        $this->top_level = $top_level;
    }
    
    function normalize($input) {
        foreach ($this->top_level as $directory) {
            if (preg_match("@(.*/)?($directory/.*)@", $input, $matches)) {
                return $matches[2];
            }
        }
        return $input;
    }
}