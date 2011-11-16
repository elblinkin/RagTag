<?php

require_once 'Autoload.php';

class Raggle_Scm_Git_Action_Exists {

    private $root_dir;
    private $logger;
    
    function __construct(
        $root_dir,
        Raggle_Logger $logger
    ) {
        $this->root_dir = $root_dir;
        $this->logger = $logger;
    }
    
    function execute(
        Raggle_Scm_Repository_Git $git
    ) {
        $repo_dir = $this->root_dir . '/' . $git->getName();
        if (!file_exists($repo_dir)) {
            $this->logger->logInfo("Directory does not exist: $repo_dir");
            return false;
        } else if (!file_exists($repo_dir . '/.git')) {
            $this->logger->logInfo("Directory is not a git repo: $repo_dir");
            return false;
        }
        
        return true;
    }
}

$logger = new Raggle_Logger();
$git_exists = new Raggle_Scm_Git_Action_Exists(
    '/Users/laurabethlincoln',
    $logger
);
$git = new Raggle_Scm_Repository_Git('Raggle', 'git@github.etsycorp.com:llincoln/Taggle.git', 'master');
echo $git_exists->execute($git) . "\n";

$git = new Raggle_Scm_Repository_Git('Temp', 'git@github.etsycorp.com:llincoln/Taggle.git', 'master');
echo $git_exists->execute($git) . "\n";

$git = new Raggle_Scm_Repository_Git('Taggle', 'git@github.etsycorp.com:llincoln/Taggle.git', 'master');
echo $git_exists->execute($git) . "\n";