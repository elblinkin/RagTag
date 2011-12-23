<?php

namespace Raggle\Scm\Git\Action;

require_once 'Autoload.php';

class GetHeadShaTest extends \PHPUnit_Framework_TestCase {

    function testExecute() {
        $expected_sha = '3ee75a23bc81b5340ce1b3627e5a3516a471c796';
        $exec = $this->getMockBuilder('Raggle\Executor')
            ->disableOriginalConstructor()
            ->getMock();
        $exec
            ->expects($this->atLeastOnce())
            ->method('execute')
            ->with(
                'cd getHeadShaTest/GitRepo; git rev-parse --verify HEAD',
                array($expected_sha)
            );
            
        $repo = $this->getMockBuilder('Raggle\Scm\Repository\Git')
            ->disableOriginalConstructor()
            ->getMock();
        $repo
            ->expects($this->atLeastOnce())
            ->method('getName')
            ->will($this->returnValue('GitRepo'));
            
        $git_get_head_sha = new GetHeadSha(
            'getHeadShaTest',
            $exec
        );
        
        $git_get_head_sha->execute($repo, array($expected_sha));
        
    }
}