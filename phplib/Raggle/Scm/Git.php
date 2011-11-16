<?php

class Raggle_Scm_Git {

    private $git_clone;
    private $git_validate;
    private $logger;
    
    function __construct(
        Raggle_Scm_Git_Action_Clone $git_clone,
        Raggle_Scm_Git_Action_Exists $git_exists,
        Raggle_Scm_Git_Action_Fetch $git_fetch,
        Raggle_Scm_Git_Action_Validate $git_validate,
        Raggle_Logger $logger
    ) {
        $this->git_clone = $git_clone;
        $this->git_validate = $git_validate;
        $this->logger = $logger;
    }
    
    function checkout(Raggle_Scm_Repository $repo) {
        if (!($repo instanceof Raggle_Scm_Git_Repository)) {
            throw new InvalidArgumentException(
                'Expected a Raggle_Scm_Git_Repository');
        }
        
        if (!$git_exists->execute($repo)) {
            $logger->logInfo("Repo does not exist: $repo");
            $git_clone->execute($repo);
        } else if (!$git_validate->execute($repo)) {
            $logger->logError("Invalid repo: $repo->getName()");
            $git_clone->execute($repo);
        } else {
            $git_fetch->execute($repo);
        }
    }
}