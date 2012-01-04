<?php

namespace Raggle\Scm\Git\Action;

require_once 'Autoload.php';

class FetchTest extends \PHPUnit_Framework_TestCase {
    
    function testExecute() {
        $exec = $this->getMockBuilder('RagTag\Executor')
            ->disableOriginalConstructor()
            ->getMock();
        $exec
            ->expects($this->any())
            ->method('execute')
            ->with('git fetch -t fetchTest/GitRepo');

        $git_repo = $this->getMockBuilder('Raggle\Scm\Repository\Git')
            ->disableOriginalConstructor()
            ->getMock();

        $git_repo
            ->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('GitRepo'));
            
        $git_fetch = new Fetch(
            'fetchTest',
            $exec
        );
        $git_fetch->execute($git_repo);
    }
}
