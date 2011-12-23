<?php

namespace Raggle\Scm\Git\Action;

require_once 'Autoload.php';

class LogTest extends \PHPUnit_Framework_TestCase {

    private $git_log;
    private $exec;
    
    private $git_repo;
    
    function setUp() {
        parent::setUp();
        
        $this->exec = $this->getMockBuilder('Raggle\Executor')
            ->disableOriginalConstructor()
            ->getMock();
            
        $this->git_log = new Log(
            'logTest',
            $this->exec
        );
        
        $this->git_repo = $this->getMockBuilder('Raggle\Scm\Repository\Git')
            ->disableOriginalConstructor()
            ->getMock();
            
        $this->git_repo
            ->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('GitRepo'));
    }
    
    function testExecute_noRevisionsSpecified() {
        $this->exec
            ->expects($this->atLeastOnce())
            ->method('execute')
            ->with('cd logTest/GitRepo;'
                . 'git log '
                . '--name-only '
                . '--pretty=format:'
                . '"{"commit": "%H", '
                . '"author": {"name": "%aN", "email": "%aE", "date": "%at"}, '
                . '"committer": {"name": "%cN", "email": "%cE", "date": "%ct"}, '
                . '"message": "%s"}" '
            );
            
        $this->git_log->execute($this->git_repo);
    }
    
    function testExecute_minRevision() {
        $this->exec
            ->expects($this->atLeastOnce())
            ->method('execute')
            ->with('cd logTest/GitRepo;'
                . 'git log '
                . '--name-only '
                . '--pretty=format:'
                . '"{"commit": "%H", '
                . '"author": {"name": "%aN", "email": "%aE", "date": "%at"}, '
                . '"committer": {"name": "%cN", "email": "%cE", "date": "%ct"}, '
                . '"message": "%s"}" '
                . 'min..'
            );
            
        $this->git_log->execute($this->git_repo, 'min');
    }
    
    function testExecute_maxRevisionOnlyIgnored() {
        $this->exec
            ->expects($this->atLeastOnce())
            ->method('execute')
            ->with('cd logTest/GitRepo;'
                . 'git log '
                . '--name-only '
                . '--pretty=format:'
                . '"{"commit": "%H", '
                . '"author": {"name": "%aN", "email": "%aE", "date": "%at"}, '
                . '"committer": {"name": "%cN", "email": "%cE", "date": "%ct"}, '
                . '"message": "%s"}" '
            );
            
        $this->git_log->execute($this->git_repo, null, 'max');
    }
    
    function testExecute_revisionRange() {
        $this->exec
            ->expects($this->atLeastOnce())
            ->method('execute')
            ->with('cd logTest/GitRepo;'
                . 'git log '
                . '--name-only '
                . '--pretty=format:'
                . '"{"commit": "%H", '
                . '"author": {"name": "%aN", "email": "%aE", "date": "%at"}, '
                . '"committer": {"name": "%cN", "email": "%cE", "date": "%ct"}, '
                . '"message": "%s"}" '
                . 'min..max'
            );
            
        $this->git_log->execute($this->git_repo, 'min', 'max');
    }
}