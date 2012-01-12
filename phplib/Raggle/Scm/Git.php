<?php

namespace Raggle\Scm;

use Raggle\Scm\Git\Action;
use Raggle\Scm\Repository;
use RagTag\Logger;
use Taggle\Git\Log\Processor as ChangeLogProcessor;

class Git implements \Raggle\Scm {

    private $git_checkout;
    private $git_clean;
    private $git_clone;
    private $git_exists;
    private $git_fetch;
    private $git_get_head_sha;
    private $git_log;
    private $git_validate;
    private $logger;
    private $change_log_processor;
    
    function __construct(
        Action\Checkout $git_checkout,
        Action\Clean $git_clean,
        Action\CloneRepository $git_clone,
        Action\Exists $git_exists,
        Action\Fetch $git_fetch,
        Action\GetHeadSha $git_get_head_sha,
        Action\Log $git_log,
        Action\Validate $git_validate,
        Logger $logger,
        ChangeLogProcessor $change_log_processor
    ) {
        $this->git_checkout = $git_checkout;
        $this->git_clean = $git_clean;
        $this->git_clone = $git_clone;
        $this->git_exists = $git_exists;
        $this->git_fetch = $git_fetch;
        $this->git_get_head_sha = $git_get_head_sha;
        $this->git_log = $git_log;
        $this->git_validate = $git_validate;
        $this->logger = $logger;
        $this->change_log_processor = $change_log_processor;
    }
    
    function getName() {
        return 'git';
    }
    
    function checkout($repo) {
        if (!($repo instanceof Repository\Git)) {
            throw new \InvalidArgumentException(
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
    
    function getChangeLog($repo, $start_revision = null, $end_revision = null) {
        return $this->git_log->execute($repo, $start_revision, $end_revision);
    }
    
    function getChangeLogProcessor() {
        return $this->change_log_processor;
    }
}
