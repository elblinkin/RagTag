<?php

namespace Raggle\Scm\Git\Action;

require_once 'Autoload.php';

class CleanTest extends \PHPUnit_Framework_TestCase {
    
    function testExecute() {
        $exec = $this->getMockBuilder('RagTag\Executor')
            ->disableOriginalConstructor()
            ->getMock();
        $exec
            ->expects($this->any())
            ->method('execute')
            ->with('cd cleanTest/GitRepo; git clean -fdx');

        $git_repo = $this->getMockBuilder('Raggle\Scm\Repository\Git')
            ->disableOriginalConstructor()
            ->getMock();

        $git_repo
            ->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('GitRepo'));
            
        $git_clean = new Clean(
            'cleanTest',
            $exec
        );
        $git_clean->execute($git_repo);
    }
}
