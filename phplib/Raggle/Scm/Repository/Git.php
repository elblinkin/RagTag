<?php

namespace Raggle\Scm\Repository;

use Raggle\Scm\Git as Scm;

class Git implements \Raggle\Scm\Repository {

    private $name;
    private $scm;
    private $url;
    private $branches;
    
    function __construct(
        $name,
        Scm $scm,
        $url,
        $branches
    ) {
        $this->name = $name;
        $this->scm = $scm;
        $this->url = $url;
        $this->branches = $branches;
    }
    
    function getName() {
        return $this->name;
    }
    
    function getUrl() {
        return $this->url;
    }
    
    function getBranches() {
        return $this->branches;
    }
    
    function checkout($job_id) {
        $last_revision = $this->scm->getRevision($this);
        $this->scm->checkout($this);
        $head_revision = $this->scm->getRevision($this);
        $change_log = $this->scm->getChangeLog($last_revision, $head_revision);
        $this->scm->getChangeLogProcessor()->process($change_log, $job_id);
    }
}