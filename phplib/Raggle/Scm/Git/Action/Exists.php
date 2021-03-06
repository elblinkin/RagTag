<?php

namespace Raggle\Scm\Git\Action;
use Raggle\Scm\Repository;
use RagTag\Logger;

class Exists {

    private $root_dir;
    private $logger;
    
    function __construct(
        $root_dir,
        Logger $logger
    ) {
        $this->root_dir = $root_dir;
        $this->logger = $logger;
    }
    
    function execute(
        Repository\Git $git
    ) {
        $repo_dir = $this->root_dir . '/' . $git->getName();
        if (!file_exists($repo_dir)) {
            $this->logger->logInfo("Directory does not exist: $repo_dir");
            return false;
        } else if (!is_dir($repo_dir)) {
            $this->logger->logInfo("Not a directory: $repo_dir");
            return false;
        } else if (!file_exists($repo_dir . '/.git')) {
            $this->logger->logInfo("Directory is not a git repo: $repo_dir");
            return false;
        }
        
        return true;
    }
}
