<?php

class Raggle_Scm_Git implements Raggle_Scm {

    private $git_checkout;
    private $git_clean;
    private $git_clone;
    private $git_exists;
    private $git_fetch;
    private $git_get_head_sha;
    private $git_validate;
    private $logger;
    
    function __construct(
        Raggle_Scm_Git_Action_Checkout $git_checkout,
        Raggle_Scm_Git_Action_Clean $git_clean,
        Raggle_Scm_Git_Action_Clone $git_clone,
        Raggle_Scm_Git_Action_Exists $git_exists,
        Raggle_Scm_Git_Action_Fetch $git_fetch,
        Raggle_Scm_Git_Action_GetHeadSha $git_get_head_sha,
        Raggle_Scm_Git_Action_Validate $git_validate,
        Raggle_Logger $logger
    ) {
        $this->git_checkout = $git_checkout;
        $this->git_clean = $git_clean;
        $this->git_clone = $git_clone;
        $this->git_exists = $git_exists;
        $this->git_fetch = $git_fetch;
        $this->git_get_head_sha = $git_get_head_sha;
        $this->git_validate = $git_validate;
        $this->logger = $logger;
    }
    
    function getName() {
        return 'git';
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
        $this->git_checkout->execute($repo);
    }
    
    function getRevision($repo) {
        return $this->git_get_head_sha->execute($repo);
    }
    
    function getChangeLog($repo, $start_rev, $end_rev) {
    
    }
}