<?php

require_once 'Autoload.php';
require_once 'vfsStream/vfsStream.php';

class Raggle_Scm_Git_Action_CheckoutTest extends PHPUnit_Framework_TestCase {

    private $git_checkout;
    private $exec;
    private $git_repo;
    
    protected function setUp() {
        parent::setUp();
        vfsStream::setup('checkoutTest');
        
        $this->exec = $this->getMockBuilder('Raggle_Exec')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->git_checkout = new Raggle_Scm_Git_Action_Checkout(
            vfsStream::url('checkoutTest'),
            $this->exec
        );
        
        $this->git_repo = $this->getMockBuilder('Raggle_Scm_Repository_Git')
            ->disableOriginalConstructor()
            ->getMock();
            
        $this->git_repo
            ->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('GitRepo'));
            
        $this->git_repo
            ->expects($this->any())
            ->method('getUrl')
            ->will($this->returnValue('git://localhost:GitRepo'));
    }
    
    function testExecute_nullBranches() {
        $this->git_repo
            ->expects($this->any())
            ->method('getBranches')
            ->will($this->returnValue(null));
        
        $this->exec
            ->expects($this->atLeastOnce())
            ->method('execute')
            ->with('cd vfs://checkoutTest/GitRepo; git checkout -f');
            
        $this->git_checkout->execute($this->git_repo);
    }
    
    function testExecute_noBranches() {
        $this->git_repo
            ->expects($this->any())
            ->method('getBranches')
            ->will($this->returnValue(array()));
        
        $this->exec
            ->expects($this->atLeastOnce())
            ->method('execute')
            ->with('cd vfs://checkoutTest/GitRepo; git checkout -f');
            
        $this->git_checkout->execute($this->git_repo);
    }
    
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage First should be current
     */
    function testExecute_badBranchReturn() {
        $this->git_repo
            ->expects($this->any())
            ->method('getBranches')
            ->will($this->returnValue(array('master')));
        
        $this->exec
            ->expects($this->at(0))
            ->method('execute')
            ->with('cd vfs://checkoutTest/GitRepo; git checkout -f');
        $this->exec
            ->expects($this->at(1))
            ->method('execute')
            ->with('cd vfs://checkoutTest/GitRepo; git branch');
            
        $this->git_checkout->execute($this->git_repo);
    }
    
    function testExecute_onBranch() {
        $expected_branch_ret = array('* master');
        $this->git_repo
            ->expects($this->any())
            ->method('getBranches')
            ->will($this->returnValue(array('master', 'branch')));
        
        $this->exec
            ->expects($this->at(0))
            ->method('execute')
            ->with('cd vfs://checkoutTest/GitRepo; git checkout -f');
        $this->exec
            ->expects($this->at(1))
            ->method('execute')
            ->with('cd vfs://checkoutTest/GitRepo; git branch', $expected_branch_ret);
            
        $this->git_checkout->execute($this->git_repo, $expected_branch_ret);
    }
    
    function testExecute_notOnBranch() {
        $expected_branch_ret = array('* branch');
        $this->git_repo
            ->expects($this->any())
            ->method('getBranches')
            ->will($this->returnValue(array('master', 'branch')));
        
        $this->exec
            ->expects($this->at(0))
            ->method('execute')
            ->with('cd vfs://checkoutTest/GitRepo; git checkout -f');
        $this->exec
            ->expects($this->at(1))
            ->method('execute')
            ->with('cd vfs://checkoutTest/GitRepo; git branch', $expected_branch_ret);
        $this->exec
            ->expects($this->at(2))
            ->method('execute')
            ->with('cd vfs://checkoutTest/GitRepo; git checkout -b master');
            
        $this->git_checkout->execute($this->git_repo, $expected_branch_ret);
    }
}