<?php

namespace Raggle\Scm\Git\Action;

require_once 'Autoload.php';
require_once 'vfsStream/vfsStream.php';

class ExistsTest extends \PHPUnit_Framework_TestCase {

    private $git_exists;
    private $logger;
    private $git_repo;
    
    protected function setUp() {
        parent::setUp();
        \vfsStream::setup('existsTest');
        
        $this->logger = $this->getMockBuilder('Raggle\Logger')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->git_exists = new Exists(
            \vfsStream::url('existsTest'),
            $this->logger
        );
        
        $this->git_repo = $this->getMockBuilder('Raggle\Scm\Repository\Git')
            ->disableOriginalConstructor()
            ->getMock();
            
        $this->git_repo
            ->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('GitRepo'));
    }
    
    function testExecute_doesNotExist() {
        $this->assertFalse($this->git_exists->execute($this->git_repo));
    }
    
    function testExecute_notDirectory() {
        \vfsStream::newFile('GitRepo')->at(\vfsStreamWrapper::getRoot());
        
        $this->assertFalse($this->git_exists->execute($this->git_repo));
    }
    
    function testExecute_notGitDirectory() {
        \vfsStream::newDirectory('GitRepo')->at(\vfsStreamWrapper::getRoot());
        
        $this->assertFalse($this->git_exists->execute($this->git_repo));
    }
    
    function testExecute_exists() {
        $repo = \vfsStream::newDirectory('GitRepo')->at(\vfsStreamWrapper::getRoot());
        \vfsStream::newDirectory('.git')->at($repo);
        
        $this->assertTrue($this->git_exists->execute($this->git_repo));
    }
}