<?php

class Raggle_Scm_Git_FactoryTest extends PHPUnit_Framework_TestCase {

    public function testCreate() {
        $exec = $this->getMockBuilder('Raggle_Exec')
            ->disableOriginalConstructor()
            ->getMock();
        $logger = $this->getMockBuilder('Raggle_Logger')
            ->disableOriginalConstructor()
            ->getMock();
            
        $factory = new Raggle_Scm_Git_Factory();
        
        $git = $factory->create('/root', $exec, $logger);
        
        $this->assertInstanceOf('Raggle_Scm_Git', $git);
    }
}