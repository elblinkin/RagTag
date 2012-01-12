<?php

namespace Raggle\Scm\Repository\Git;

require_once 'Autoload.php';

class BuilderTest extends \PHPUnit_Framework_TestCase {

    private $scm_manager;
    private $scm;
    
    private $builder;
    
    function setUp() {
        parent::setUp();
        $this->scm = $this->getMockBuilder('Raggle\Scm\Git')
            ->disableOriginalConstructor()
            ->getMock();
            
        $this->scm_manager = $this->getMockBuilder('Raggle\Scm\Manager')
            ->disableOriginalConstructor()
            ->getMock();
            
        $this->builder = new Builder($this->scm_manager);
    }
    
    /**
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage $name must not be null
     */
    function testBuild_nothingSet() {
        $this->builder->build();
    }
    
    /**
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage $scm must not be null
     */
    function testBuild_scmNotSet() {
        $this->builder
            ->setName('GitRepo')
            ->build();
    }
    
    /**
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Must specify repository url
     */
    function testBuild_urlNotSet() {
        $this->scm_manager
            ->expects($this->any())
            ->method('getScm')
            ->with('git')
            ->will($this->returnValue($this->scm));
            
        $this->builder
            ->setName('GitRepo')
            ->setScm('git')
            ->build();
    }
     
    /**
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Must specify at least one branch
     */
    function testBuild_branchesNotSet() {
        $this->scm_manager
            ->expects($this->any())
            ->method('getScm')
            ->with('git')
            ->will($this->returnValue($this->scm));
            
        $this->builder
            ->setName('GitRepo')
            ->setScm('git')
            ->setUrl('git://localhost/GitRepo')
            ->build();
    }
     
    /**
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Must specify at least one branch
     */
    function testBuild_noBranchesSpecified() {
        $this->scm_manager
            ->expects($this->any())
            ->method('getScm')
            ->with('git')
            ->will($this->returnValue($this->scm));
            
        $this->builder
            ->setName('GitRepo')
            ->setScm('git')
            ->setUrl('git://localhost/GitRepo')
            ->setBranches(array())
            ->build();
    }
    
    function testBuild() {
        $this->scm_manager
            ->expects($this->any())
            ->method('getScm')
            ->with('git')
            ->will($this->returnValue($this->scm));
            
        $expected = new \Raggle\Scm\Repository\Git(
            'GitRepo',
            $this->scm,
            'git://localhost/GitRepo',
            array('master')
        );
        $actual = $this->builder
            ->setName('GitRepo')
            ->setScm('git')
            ->setUrl('git://localhost/GitRepo')
            ->setBranches(array('master'))
            ->build();
            
        $this->assertEquals($expected, $actual);
    }
}