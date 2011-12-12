<?php

require_once 'Autoload.php';

class Raggle_Scm_Repository_Git_BuilderTest extends PHPUnit_Framework_TestCase {

    private $builder;
    
    function setUp() {
        parent::setUp();
        $this->builder = new Raggle_Scm_Repository_Git_Builder();
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
     * @expectedExceptionMessage Must specify repository url
     */
    function testBuild_urlNotSet() {
        $this->builder
            ->setName('GitRepo')
            ->build();
    }
     
    /**
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Must specify at least one branch
     */
    function testBuild_branchesNotSet() {
        $this->builder
            ->setName('GitRepo')
            ->setUrl('git://localhost/GitRepo')
            ->build();
    }
     
    /**
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Must specify at least one branch
     */
    function testBuild_noBranchesSpecified() {
        $this->builder
            ->setName('GitRepo')
            ->setUrl('git://localhost/GitRepo')
            ->setBranches(array())
            ->build();
    }
    
    function testBuild() {
        $expected = new Raggle_Scm_Repository_Git(
            'GitRepo',
            'git://localhost/GitRepo',
            array('master')
        );
        $actual = $this->builder
            ->setName('GitRepo')
            ->setUrl('git://localhost/GitRepo')
            ->setBranches(array('master'))
            ->build();
    }
}