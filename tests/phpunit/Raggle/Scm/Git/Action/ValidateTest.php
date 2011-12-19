<?php

require_once 'Autoload.php';

class Raggle_Scm_Git_Action_ValidateTest extends PHPUnit_Framework_TestCase {

    private $exec;
    private $logger;
    private $git_repo;
    private $git_validate;
    
    protected function setUp() {
        parent::setUp();
        $this->exec = $this->getMockBuilder('Raggle_Exec')
            ->disableOriginalConstructor()
            ->getMock();
            
        $this->logger = $this->getMockBuilder('Raggle_Logger')
            ->disableOriginalConstructor()
            ->getMock();
            
        $this->git_repo = $this->getMockBuilder('Raggle_Scm_Repository_Git')
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
            
        $this->git_validate = new Raggle_Scm_Git_Action_Validate(
            'validateTest',
            $this->exec,
            $this->logger
        );
    }
    
    function testExecute_noDirectoryOrMatchingRemote() {
        $this->assertFalse(
            $this->git_validate->execute(
                $this->git_repo,
                array(),
                -1
            )
        );  
    }
    
    function testExecute_mismatchedRemote() {
        $this->logger
            ->expects($this->once())
            ->method('logError');
            
        $this->assertFalse(
            $this->git_validate->_execute(
                $this->git_repo,
                array(
                    '* remote origin',
                    '  Fetch URL: git@github.etsycorp.com:GitRepo.git',
                ),
                0
            )
        );
    }
    
    function testExecute_noRemoteSection() {
        $this->logger
            ->expects($this->once())
            ->method('logError');
            
        $this->assertFalse(
            $this->git_validate->_execute(
                $this->git_repo,
                array(
                    '* remote origin',
                    '  Fetch URL: git://localhost:GitRepo',
                ),
                0
            )
        );
    }
    
    function testExecute_noBranches() {
        $this->logger
            ->expects($this->once())
            ->method('logError');
            
        $this->assertFalse(
            $this->git_validate->_execute(
                $this->git_repo,
                array(
                    '* remote origin',
                    '  Fetch URL: git://localhost:GitRepo',
                    '  Push  URL: git@github.etsycorp.com:llincoln/Taggle.git',
                    '  HEAD branch: master',
                    '  Remote branch:',
                ),
                0
            )
        );
    }
    
    function testExecute_mismatchedBranches() {
        $this->logger
            ->expects($this->once())
            ->method('logError');
            
        $this->assertFalse(
            $this->git_validate->_execute(
                $this->git_repo,
                array(
                    '* remote origin',
                    '  Fetch URL: git://localhost:GitRepo',
                    '  Push  URL: git@github.etsycorp.com:llincoln/Taggle.git',
                    '  HEAD branch: master',
                    '  Remote branch:',
                    '    something tracked',
                    '    other tracked',
                ),
                0
            )
        );
    }
    
    function testExecute_missingBranch() {
        $this->logger
            ->expects($this->once())
            ->method('logError');
            
        $this->assertFalse(
            $this->git_validate->_execute(
                $this->git_repo,
                array(
                    '* remote origin',
                    '  Fetch URL: git://localhost:GitRepo',
                    '  Push  URL: git@github.etsycorp.com:llincoln/Taggle.git',
                    '  HEAD branch: master',
                    '  Remote branch:',
                    '    master tracked',
                ),
                0
            )
        );
    }
    
    function testExecute_valid() {
        $this->assertTrue(
            $this->git_validate->_execute(
                $this->git_repo,
                array(
                    '* remote origin',
                    '  Fetch URL: git://localhost:GitRepo',
                    '  Push  URL: git@github.etsycorp.com:llincoln/Taggle.git',
                    '  HEAD branch: master',
                    '  Remote branch:',
                    '    master tracked',
                    '    branch tracked',
                ),
                0
            )
        );
    }
}