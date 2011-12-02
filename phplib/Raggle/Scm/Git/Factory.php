<?php

require_once 'Autoload.php';
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
            new Raggle_Scm_Git_Action_Validate($root_dir, $exec, $logger),
            $logger
        );   
    }
}
$logger = new Raggle_Logger();
$exec = new Raggle_Exec($logger);
$factory = new Raggle_Scm_Git_Factory();
$git = $factory->create(
    '/Users/laurabethlincoln',
    $exec,
    $logger
);
$repo = new Raggle_Scm_Repository_Git(
    'SillyBandz',
    'git://github.etsycorp.com/llincoln/DeveloperTesting101.git',
    array('master')
);
$git->checkout($repo);