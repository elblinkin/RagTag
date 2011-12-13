<?php

interface Raggle_Scm_Factory {

    /**
     * Creates the SCM API.
     *
     * @param string $root_dir the root directory to check source out into.
     * @param Raggle_Exec $exec the raggle executor to use.
     * @param Raggle_Logger $logger the raggle logger to use.
     * @return Raggle_Scm
     */
    function create(
        $root_dir,
        Raggle_Exec $exec,
        Raggle_Logger $logger
    );
}