<?php

class Raggle_Scm_Manager_FactoryTest extends PHPUnit_Framework_TestCase {

    private $root_dir;
    private $exec;
    private $logger;
    
    function setUp() {
        parent::setUp();
        $this->root_dir = 'factoryTest';
        $this->exec = $this->getMockBuilder('Raggle_Exec')
            ->disableOriginalConstructor()
            ->getMock();
        $this->logger = $this->getMockBuilder('Raggle_Logger')
            ->disableOriginalConstructor()
            ->getMock();
    }
    
    function testCreate_nothing() {
        $factory = new Raggle_Scm_Manager_Factory(
            $this->root_dir,
            $this->exec,
            $this->logger,
            array()
        );
        $this->assertInstanceof('Raggle_Scm_Manager', $factory->create());
    }
    
    function testCreate_oneSubFactory() {
        $scm = $this->getMock('Raggle_Scm');
        $scm
            ->expects($this->atLeastOnce())
            ->method('getName')
            ->will($this->returnValue('git'));
            
        $sub_factory = $this->getMockBuilder('Raggle_Scm_Factory')
            ->disableOriginalConstructor()
            ->getMock();
        $sub_factory
            ->expects($this->atLeastonce())
            ->method('create')
            ->with($this->root_dir, $this->exec, $this->logger)
            ->will($this->returnValue($scm));
        
        $factory = new Raggle_Scm_Manager_Factory(
            $this->root_dir,
            $this->exec,
            $this->logger,
            array($sub_factory)
        );
        
        $this->assertEquals($scm, $factory->create()->getScm('git'));
    }
    
    function testCreate_moreThanOneSubFactory() {
        $scm_a = $this->getMock('Raggle_Scm');
        $scm_a
            ->expects($this->atLeastOnce())
            ->method('getName')
            ->will($this->returnValue('git'));
            
        $sub_factory_a = $this->getMockBuilder('Raggle_Scm_Factory')
            ->disableOriginalConstructor()
            ->getMock();
        $sub_factory_a
            ->expects($this->atLeastonce())
            ->method('create')
            ->with($this->root_dir, $this->exec, $this->logger)
            ->will($this->returnValue($scm_a));
            
        $scm_b = $this->getMock('Raggle_Scm');
        $scm_b
            ->expects($this->atLeastOnce())
            ->method('getName')
            ->will($this->returnValue('svn'));
            
        $sub_factory_b = $this->getMockBuilder('Raggle_Scm_Factory')
            ->disableOriginalConstructor()
            ->getMock();
        $sub_factory_b
            ->expects($this->atLeastonce())
            ->method('create')
            ->with($this->root_dir, $this->exec, $this->logger)
            ->will($this->returnValue($scm_b));
        
        $factory = new Raggle_Scm_Manager_Factory(
            $this->root_dir,
            $this->exec,
            $this->logger,
            array($sub_factory_a, $sub_factory_b)
        );
        
        $this->assertEquals($scm_a, $factory->create()->getScm('git'));
        $this->assertEquals($scm_b, $factory->create()->getScm('svn'));
    }
}
