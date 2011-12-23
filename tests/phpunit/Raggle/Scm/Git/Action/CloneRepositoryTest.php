<?php

namespace Raggle\Scm\Git\Action;

require_once 'Autoload.php';
require_once 'vfsStream/vfsStream.php';

class CloneRepositoryTest extends \PHPUnit_Framework_TestCase {

    private $git_clone;
    private $exec;
    private $git_repo;
    
    protected function setUp() {
        parent::setUp();
        \vfsStream::setup('cloneTest');
        
        $this->exec = $this->getMockBuilder('Raggle\Executor')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->git_clone = new CloneRepository(
            \vfsStream::url('cloneTest'),
            $this->exec
        );
        
        $this->git_repo = $this->getMockBuilder('Raggle\Scm\Repository\Git')
            ->disableOriginalConstructor()
            ->getMock();
            
        $this->git_repo
            ->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('GitRepo'));
            
        $this->git_repo
            ->expects($this->any())
            ->method('getBranches')
            ->will($this->returnValue(array('master', 'branch')));
            
        $this->git_repo
            ->expects($this->any())
            ->method('getUrl')
            ->will($this->returnValue('git://localhost:GitRepo'));
    }
    
    function testExecute_dirExists() {
        \vfsStream::setup('cloneTest');
        \vfsStream::newDirectory('GitRepo')->at(\vfsStreamWrapper::getRoot());
        $url = \vfsStream::url('cloneTest/GitRepo');
        
        $this->exec
            ->expects($this->at(0))
            ->method('execute')
            ->with("rm -rf $url");
            
        $this->exec
            ->expects($this->at(1))
            ->method('execute')
            ->with(
                'git clone -o origin -b master'
                . " git://localhost:GitRepo $url"
            );
            
        $this->exec
            ->expects($this->at(2))
            ->method('execute')
            ->with(
                'git clone -o origin -b branch'
                . " git://localhost:GitRepo $url"
            );
            
        $this->git_clone->execute($this->git_repo);
    }
    
    function testExecute_cleanSlate() {
        \vfsStream::setup('cloneTest');
        $url = \vfsStream::url('cloneTest/GitRepo');
            
        $this->exec
            ->expects($this->at(0))
            ->method('execute')
            ->with(
                'git clone -o origin -b master'
                . " git://localhost:GitRepo $url"
            );
            
        $this->exec
            ->expects($this->at(1))
            ->method('execute')
            ->with(
                'git clone -o origin -b branch'
                . " git://localhost:GitRepo $url"
            );
            
        $this->git_clone->execute($this->git_repo);
    
    }
}