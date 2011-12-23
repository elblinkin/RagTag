<?php

namespace Raggle\Scm\Repository;

require_once 'Autoload.php';

class Git_ParserTest extends \PHPUnit_Framework_TestCase {

    function testParse() {
        $scm_config = new \StdClass;
        $scm_config->name = 'GitRepo';
        $scm_config->url = 'git://github.com/Engineering/Web.git';
        $scm_config->branches = array('master');
        
        $repo = $this->getMockBuilder('Raggle\Scm\Repository\Git')
            ->disableOriginalConstructor()
            ->getMock();
            
        $builder = $this->getMockBuilder('Raggle\Scm\Repository\Git_Builder')
            ->disableOriginalConstructor()
            ->getMock();
        $builder
            ->expects($this->atLeastOnce())
            ->method('setName')
            ->with('GitRepo')
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
        
        $parser = new Git_Parser($builder);
        
        $this->assertEquals($repo, $parser->parse($scm_config));
    }
}
