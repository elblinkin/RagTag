<?php

class Raggle_Scm_Repository_Manager_Factory {

    private $repository_parser;
    
    function __construct(Raggle_Scm_Repository_Parser $repository_parser) {
        $this->repository_parser = $repository_parser;
    }
    
    function create($scm_config_directory) {
        $handle = opendir($scm_config_directory);
        if ($handle === false) {
            throw new Exception();
        }
        
        $repository_map = array();
        while (($entry = readdir($handle)) !== false) {
            $file = $scm_config_directory . '/' . $entry;
            if (!is_file($file)) {
                throw new Exception('Must be a file: ' . $file);
            }
            $repository = $this->repository_parser->parse($file);
            $name = $repository->getName();
            $repository_map[$name] = $repository;
        }
        
        closedir($handle);
        
        return new Raggle_Scm_Repository_Manager($repository_map);
    }
}