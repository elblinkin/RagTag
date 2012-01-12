<?php

namespace Raggle\Scm\Repository;

require_once 'Autoload.php';

class GitTest extends \PHPUnit_Framework_TestCase {

    private $scm;
    private $git_repo;
    
    protected function setUp() {
        parent::setUp();
        $this->scm = $this->getMockBuilder('Raggle\Scm\Git')
            ->disableOriginalConstructor()
            ->getMock();
            
        $this->git_repo = new Git(
            'GitRepo',
            $this->scm,
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
        $this->assertEquals(array('master', 'branch'), $this->git_repo->getBranches());
    }
}