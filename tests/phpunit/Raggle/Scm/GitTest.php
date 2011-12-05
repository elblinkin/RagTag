<?php

require_once 'Autoload.php';

class Raggle_Scm_GitTest extends PHPUnit_Framework_TestCase {

    private $git_checkout;
    private $git_clean;
    private $git_clone;
    private $git_exists;
    private $git_fetch;
    private $git_get_head_sha;
    private $git_validate;
    private $logger;
    private $repo;
    
    private $git;
    
    protected function setUp() {
        parent::setUp();
        
        $this->git_checkout = $this->getMockBuilder('Raggle_Scm_Git_Action_Checkout')
            ->disableOriginalConstructor()
            ->getMock();
            
        $this->git_clean = $this->getMockBuilder('Raggle_Scm_Git_Action_Clean')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->git_clone = $this->getMockBuilder('Raggle_Scm_Git_Action_Clone')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->git_exists = $this->getMockBuilder('Raggle_Scm_Git_Action_Exists')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->git_fetch = $this->getMockBuilder('Raggle_Scm_Git_Action_Fetch')
            ->disableOriginalConstructor()
            ->getMock();
            
        $this->git_get_head_sha = $this->getMockBuilder('Raggle_Scm_Git_Action_GetHeadSha')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->git_validate = $this->getMockBuilder('Raggle_Scm_Git_Action_Validate')
            ->disableOriginalConstructor()
            ->getMock();
            
        $this->logger = $this->getMockBuilder('Raggle_Logger')
            ->disableOriginalConstructor()
            ->getMock();
            
        $this->repo = $this->getMockBuilder('Raggle_Scm_Repository_Git')
            ->disableOriginalConstructor()
            ->getMock();
            
        $this->git = new Raggle_Scm_Git(
            $this->git_checkout,
            $this->git_clean,
            $this->git_clone,
            $this->git_exists,
            $this->git_fetch,
            $this->git_get_head_sha,
            $this->git_validate,
            $this->logger
        );
    }
    
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Expected a Raggle_Scm_Repository_Git
     */
    function testCheckout_notGitRepo() {
        $repo = $this->getMock('Raggle_Scm_Repository');
        $this->git->checkout($repo);
    }
    
    function testCheckout_repoDoesNotExist() {
        $this->git_exists
            ->expects($this->atLeastOnce())
            ->method('execute')
            ->will($this->returnValue(false));
            
        $this->git_clone
            ->expects($this->atLeastOnce())
            ->method('execute')
            ->with($this->repo);
        $this->git_checkout
            ->expects($this->atLeastOnce())
            ->method('execute')
            ->with($this->repo);
        $this->git_clean
            ->expects($this->atLeastOnce())
            ->method('execute')
            ->with($this->repo);
            
        $this->git->checkout($this->repo);
    }
    
    function testCheckout_repoIsInvalid() {
        $this->git_exists
            ->expects($this->atLeastOnce())
            ->method('execute')
            ->will($this->returnValue(true));
        $this->git_validate
            ->expects($this->atLeastOnce())
            ->method('execute')
            ->will($this->returnValue(false));
            
        $this->git_clone
            ->expects($this->atLeastOnce())
            ->method('execute')
            ->with($this->repo);
        $this->git_checkout
            ->expects($this->atLeastOnce())
            ->method('execute')
            ->with($this->repo);
        $this->git_clean
            ->expects($this->atLeastOnce())
            ->method('execute')
            ->with($this->repo);
            
        $this->git->checkout($this->repo);
    }
    
    function testCheckout_repoExistsAndIsValid() {
        $this->git_exists
            ->expects($this->atLeastOnce())
            ->method('execute')
            ->will($this->returnValue(true));
        $this->git_validate
            ->expects($this->atLeastOnce())
            ->method('execute')
            ->will($this->returnValue(true));
            
        $this->git_fetch
            ->expects($this->atLeastOnce())
            ->method('execute')
            ->with($this->repo);
        $this->git_checkout
            ->expects($this->atLeastOnce())
            ->method('execute')
            ->with($this->repo);
        $this->git_clean
            ->expects($this->atLeastOnce())
            ->method('execute')
            ->with($this->repo);
            
        $this->git->checkout($this->repo);
    }
    
    function testGetRevision() {
        $this->git_get_head_sha
            ->expects ($this->atLeastOnce())
            ->method('execute')
            ->with($this->repo);
            
        $this->git->getRevision($this->repo);
    }
}