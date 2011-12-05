<?php

interface Raggle_Scm {

    /**
     * @return the name for this SCM
     */
    function getName();
    
    /**
     * @param Raggle_Scm_Repository $repo the repository to checkout
     */
    function checkout($repo);
    
    /**
     * @param Raggle_Scm_Repository $repo the repository to get the HEAD revision for
     * @return string the HEAD revision string
     */
    function getRevision($repo);
    
    /**
     * @param Raggle_Scm_Repository $repo the repository to get the changelog for
     * @param string|null [$start_revision] the optional start revision
     * @param string|null [$end_revision] the option end revision
     * @return string|array either the file name for the log or the log as an array
     */
    function getChangeLog($repo, $start_revision = null, $end_revision = null);
}