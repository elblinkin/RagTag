<?php

require_once 'Autoload.php';
require_once 'vfsStream/vfsStream.php';

class Raggle_Scm_Git_Action_ExistsTest extends PHPUnit_Framework_TestCase {

    private $git_exists;
    private $logger;
    private $git_repo;
    
    protected function setUp() {
        parent::setUp();
        vfsStream::setup('existsTest');
        
        $this->logger = $this->getMock('Raggle_Logger');
        
        $this->git_exists = new Raggle_Scm_Git_Action_Exists(
            vfsStream::url('existsTest'),
            $this->logger
        );
        
        $this->git_repo = $this->getMockBuilder('Raggle_Scm_Repository_Git')
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
        vfsStream::newFile('GitRepo')->at(vfsStreamWrapper::getRoot());
        
        $this->assertFalse($this->git_exists->execute($this->git_repo));
    }
    
    function testExecute_notGitDirectory() {
        vfsStream::newDirectory('GitRepo')->at(vfsStreamWrapper::getRoot());
        
        $this->assertFalse($this->git_exists->execute($this->git_repo));
    }
    
    function testExecute_exists() {
        $repo = vfsStream::newDirectory('GitRepo')->at(vfsStreamWrapper::getRoot());
        vfsStream::newDirectory('.git')->at($repo);
        
        $this->assertTrue($this->git_exists->execute($this->git_repo));
    }
}