<?php

class Raggle_Scm_Git {

    private $git_clean;
    private $git_clone;
    private $git_exists;
    private $git_fetch;
    private $git_validate;
    private $logger;
    
    function __construct(
        Raggle_Scm_Git_Action_Clean $git_clean,
        Raggle_Scm_Git_Action_Clone $git_clone,
        Raggle_Scm_Git_Action_Exists $git_exists,
        Raggle_Scm_Git_Action_Fetch $git_fetch,
        Raggle_Scm_Git_Action_Validate $git_validate,
        Raggle_Logger $logger
    ) {
        $this->git_clean = $git_clean;
        $this->git_clone = $git_clone;
        $this->git_exists = $git_exists;
        $this->git_fetch = $git_fetch;
        $this->git_validate = $git_validate;
        $this->logger = $logger;
    }
    
    function checkout($repo) {
        if (!($repo instanceof Raggle_Scm_Repository_Git)) {
            throw new InvalidArgumentException(
                'Expected a Raggle_Scm_Repository_Git');
        }
        
        if (!$this->git_exists->execute($repo)) {
            $this->logger->logInfo('Repo does not exist: ' . $repo->getName());
            $this->git_clone->execute($repo);
        } else if (!$this->git_validate->execute($repo)) {
            $this->logger->logError('Invalid repo: ' . $repo->getName());
            $this->git_clone->execute($repo);
        } else {
            $this->git_fetch->execute($repo);
        }
        
        $this->git_clean->execute($repo);
    }
}