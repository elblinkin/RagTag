<?php

namespace Raggle\Scm;

interface Repository {

    /**
     * Returns the name of the repository.
     *
     * @return the name of the respository.
     */
    function getName();
     
    /**
     * Checks out the HEAD revision of the repository and processes the change log
     * charging the change log to the particular job _id.
     *
     * @param string $job_id the _id of the job.
     */
    function checkout($job_id);
}