<?php

class Taggle_Normalizer_File implements Taggle_Normalizer {

    private $top_level;
    
    function __construct(array $top_level) {
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