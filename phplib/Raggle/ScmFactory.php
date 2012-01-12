<?php

namespace Raggle;

use RagTag\Executor;
use RagTag\Logger;
use Taggle\Store;

interface ScmFactory {

    /**
     * Creates the SCM API.
     *
     * @param string $root_dir the root directory to check source out into.
     * @param Executor $exec the raggle executor to use.
     * @param Logger $logger the raggle logger to use.
     * @param Store $store the taggle store.
     * @return Scm
     */
    function create(
        $root_dir,
        Executor $exec,
        Logger $logger,
        Store $store
    );
}
