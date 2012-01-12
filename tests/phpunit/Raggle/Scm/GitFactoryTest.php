<?php

namespace Raggle\Scm;

require_once 'Autoload.php';

class GitFactoryTest extends \PHPUnit_Framework_TestCase {

    public function testCreate() {
        $exec = $this->getMockBuilder('RagTag\Executor')
            ->disableOriginalConstructor()
            ->getMock();
        $logger = $this->getMockBuilder('RagTag\Logger')
            ->disableOriginalConstructor()
            ->getMock();
        $store = $this->getMock('Taggle\Store');
            
        $factory = new GitFactory();
        
        $git = $factory->create('/root', $exec, $logger, $store);
        
        $this->assertInstanceOf('Raggle\Scm\Git', $git);
    }
}
