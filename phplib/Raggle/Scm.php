<?php

namespace Raggle;

interface Scm {

    /**
     * @return the name for this SCM
     */
    function getName();
    
    /**
     * @param Scm\Repository $repo the repository to checkout
     */
    function checkout($repo);
    
    /**
     * @param Scm\Repository $repo the repository to get the HEAD revision for
     * @return string the HEAD revision string
     */
    function getRevision($repo);
    
    /**
     * @param Scm\Repository $repo the repository to get the changelog for
     * @param string|null [$start_revision] the optional start revision
     * @param string|null [$end_revision] the option end revision
     * @return string|array either the file name for the log or the log as an array
     */
    function getChangeLog($repo, $start_revision = null, $end_revision = null);
    
    /**
     * @return Taggle\Document\Processor return the processor for the changelog
     */
    function getChangeLogProcessor();
}