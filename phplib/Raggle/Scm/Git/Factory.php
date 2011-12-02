<?php

class Raggle_Scm_Git_Factory {

    public function create(
        $root_dir,
        Raggle_Exec $exec,
        Raggle_Logger $logger
    ) {
        return new Raggle_Scm_Git(
            new Raggle_Scm_Git_Action_Checkout($root_dir, $exec),
            new Raggle_Scm_Git_Action_Clean($root_dir, $exec),
            new Raggle_Scm_Git_Action_Clone($root_dir, $exec),
            new Raggle_Scm_Git_Action_Exists($root_dir, $logger),
            new Raggle_Scm_Git_Action_Fetch($root_dir, $exec),
            new Raggle_Scm_Git_Action_GetHeadSha($root_dir, $exec),
            new Raggle_Scm_Git_Action_Validate($root_dir, $exec, $logger),
            $logger
        );   
    }
}