<?php

require_once 'Autoload.php';

class Raggle_Scm_Repository_GitTest extends PHPUnit_Framework_TestCase {

    private $git_repo;
    
    protected function setUp() {
        parent::setUp();
        $this->git_repo = new Raggle_Scm_Repository_Git(
            'GitRepo',
            'git://localhost:GitRepo',
            array('master', 'branch')
        );
    }
    
    function testGetName() {
        $this->assertEquals('GitRepo', $this->git_repo->getName());
    }
    
    function testGetUrl() {
        $this->assertEquals('git://localhost:GitRepo', $this->git_repo->getUrl());
    }
    
    function testGetBranches() {
        $this->assertEquals(array('master', 'branch'), $this->get_repo->getBranches());
    }
}