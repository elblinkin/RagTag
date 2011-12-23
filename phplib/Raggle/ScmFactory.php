<?php

namespace Raggle;
use Raggle\Executor;
use Raggle\Logger;

interface ScmFactory {

    /**
     * Creates the SCM API.
     *
     * @param string $root_dir the root directory to check source out into.
     * @param Executor $exec the raggle executor to use.
     * @param Logger $logger the raggle logger to use.
     * @return Scm
     */
    function create(
        $root_dir,
        Executor $exec,
        Logger $logger
    );
}