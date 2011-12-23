<?php

namespace Raggle\Scm;
use Raggle\Executor;
use Raggle\Logger;
use Raggle\Scm\Git\Action;

class GitFactory implements \Raggle\ScmFactory {

    function create(
        $root_dir,
        Executor $exec,
        Logger $logger
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
            $logger
        );   
    }
}