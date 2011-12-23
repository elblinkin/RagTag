<?php

namespace Raggle\Scm\Repository;

class Parser {

    private $parser_map;
    
    function __construct(array $parser_map) {
        $this->parser_map = $parser_map;
    }
    
    function parse($scm_config) {
        $scm_string = file_get_contents($scm_config);
        $scm_json = json_decode($scm_string);
        $parser = $this->parser_map[$scm_json->type];
        return $parser->parse($scm_json);
    }
}