<?php

require_once 'Autoload.php';

class Raggle_Scm_Repository_Git_ParserTest extends PHPUnit_Framework_TestCase {

    function testParse() {
        $scm_config = new StdClass;
        $scm_config->name = 'GitRepo';
        $scm_config->url = 'git://github.etsycorp.com/Engineering/Web.git';
        $scm_config->branches = array('master');
        
        $repo = $this->getMockBuilder('Raggle_Scm_Repository_Git')
            ->disableOriginalConstructor()
            ->getMock();
            
        $builder = $this->getMockBuilder('Raggle_Scm_Repository_Git_Builder')
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
            ->with('git://github.etsycorp.com/Engineering/Web.git')
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
        
        $parser = new Raggle_Scm_Repository_Git_Parser($builder);
        
        $this->assertEquals($repo, $parser->parse($scm_config));
    }
}