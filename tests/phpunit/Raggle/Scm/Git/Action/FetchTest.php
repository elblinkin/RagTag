<?php

require_once 'Autoload.php';

class Raggle_Scm_Git_Action_FetchTest extends PHPUnit_Framework_TestCase {
    
    function testExecute() {
        $exec = $this->getMockBuilder('Raggle_Exec')
            ->disableOriginalConstructor()
            ->getMock();
        $exec
            ->expects($this->any())
            ->method('execute')
            ->with('git fetch -t fetchTest/GitRepo');

        $git_repo = $this->getMockBuilder('Raggle_Scm_Repository_Git')
            ->disableOriginalConstructor()
            ->getMock();

        $git_repo
            ->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('GitRepo'));
            
        $git_fetch = new Raggle_Scm_Git_Action_Fetch(
            'fetchTest',
            $exec
        );
        $git_fetch->execute($git_repo);
    }
}