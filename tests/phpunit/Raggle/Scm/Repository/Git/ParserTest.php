<?php

namespace Raggle\Scm\Repository\Git;

require_once 'Autoload.php';

use StdClass;

class ParserTest extends \PHPUnit_Framework_TestCase {

    function testParse() {
        $scm_config = new StdClass;
        $scm_config->name = 'GitRepo';
        $scm_config->scm = 'git';
        $scm_config->url = 'git://github.com/Engineering/Web.git';
        $scm_config->branches = array('master');
        
        $repo = $this->getMockBuilder('Raggle\Scm\Repository\Git')
            ->disableOriginalConstructor()
            ->getMock();
            
        $builder = $this->getMockBuilder('Raggle\Scm\Repository\Git\Builder')
            ->disableOriginalConstructor()
            ->getMock();
        $builder
            ->expects($this->atLeastOnce())
            ->method('setName')
            ->with('GitRepo')
            ->will($this->returnSelf());
        $builder
            ->expects($this->atLeastOnce())
            ->method('setScm')
            ->with('git')
            ->will($this->returnSelf());
        $builder
            ->expects($this->atLeastOnce())
            ->method('setUrl')
            ->with('git://github.com/Engineering/Web.git')
            ->will($this->returnSelf());
        $builder
            ->expects($this->atLeastOnce())
            ->method('setBranches')
            ->with($this->equalTo(array('master')))
            ->will($this->returnSelf());
        $builder
            ->expects($this->atLeastOnce())
            ->method('build')
            ->will($this->ReturnValue($repo));
        
        $parser = new Parser($builder);
        
        $this->assertEquals($repo, $parser->parse($scm_config));
    }
}
