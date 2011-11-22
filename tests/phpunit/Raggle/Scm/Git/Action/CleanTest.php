<?php

require_once 'Autoload.php';

class Raggle_Scm_Git_Action_CleanTest extends PHPUnit_Framework_TestCase {
    
    function testExecute() {
        $exec = $this->getMockBuilder('Raggle_Exec')
            ->disableOriginalConstructor()
            ->getMock();
        $exec
            ->expects($this->any())
            ->method('execute')
            ->with('cd cleanTest/GitRepo; git clean -fdx');

        $git_repo = $this->getMockBuilder('Raggle_Scm_Repository_Git')
            ->disableOriginalConstructor()
            ->getMock();

        $git_repo
            ->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('GitRepo'));
            
        $git_clean = new Raggle_Scm_Git_Action_Clean(
            'cleanTest',
            $exec
        );
        $git_clean->execute($git_repo);
    }
}