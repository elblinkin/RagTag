<?php

namespace Raggle\Scm;
use Raggle\Scm\Git\Action;
use RagTag\Executor;
use RagTag\Logger;
use Taggle\Git\Log\Processor as LogProcessor;
use Taggle\Store;

class GitFactory implements \Raggle\ScmFactory {

    function create(
        $root_dir,
        Executor $exec,
        Logger $logger,
        Store $store
    ) {
        return new Git(
            new Action\Checkout($root_dir, $exec),
            new Action\Clean($root_dir, $exec),
            new Action\CloneRepository($root_dir, $exec),
            new Action\Exists($root_dir, $logger),
            new Action\Fetch($root_dir, $exec),
            new Action\GetHeadSha($root_dir, $exec),
            new Action\Log($root_dir, $exec),
            new Action\Validate($root_dir, $exec, $logger),
            $logger,
            new LogProcessor($store)
        );   
    }
}
