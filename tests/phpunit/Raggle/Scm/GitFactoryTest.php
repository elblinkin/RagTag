<?php

namespace Raggle\Scm;

require_once 'Autoload.php';

class GitFactoryTest extends \PHPUnit_Framework_TestCase {

    public function testCreate() {
        $exec = $this->getMockBuilder('Raggle\Executor')
            ->disableOriginalConstructor()
            ->getMock();
        $logger = $this->getMockBuilder('Raggle\Logger')
            ->disableOriginalConstructor()
            ->getMock();
            
        $factory = new GitFactory();
        
        $git = $factory->create('/root', $exec, $logger);
        
        $this->assertInstanceOf('Raggle\Scm\Git', $git);
    }
}