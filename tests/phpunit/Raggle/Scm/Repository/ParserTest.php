<?php

require_once 'Autoload.php';
require_once 'vfsStream/vfsStream.php';

class Raggle_Scm_Repository_ParserTest extends PHPUnit_Framework_TestCase {

    function testParse() {
        $json = '{'
            . '"name": "web",'
            . '"type": "git",'
            . '"url": "git://github.etsycorp.com/Engineering/Web.git",'
            . '"branches": [ "master" ]'
            . '}';
            
        vfsStream::setup('parserTest');
        vfsStream::newFile('gitRepo.json')
            ->withContent($json)
            ->at(vfsStreamWrapper::getRoot());
        
        $filename = vfsStream::url('parserTest/gitRepo.json');
            
        $repo = $this->getMockBuilder('Raggle_Scm_Repository_Git')
            ->disableOriginalConstructor()
            ->getMock();
        
        $sub_parser = $this->getMockBuilder('Raggle_Scm_Repository_Git_Parser')
            ->disableOriginalConstructor()
            ->getMock();
        $sub_parser
            ->expects($this->atLeastOnce())
            ->method('parse')
            ->with(json_decode($json))
            ->will($this->returnValue($repo));
            
        $parser = new Raggle_Scm_Repository_Parser(array('git' => $sub_parser));
        
        $this->assertEquals($repo, $parser->parse($filename));
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     * @expectedExceptionMessage Undefined index: svn
     */
    function testParse_missingParserType() {
        $json = '{'
            . '"name": "web",'
            . '"type": "svn",'
            . '"url": "svn://github.etsycorp.com/Engineering/Web",'
            . '"branches": [ "master" ]'
            . '}';
            
        vfsStream::setup('parserTest');
        vfsStream::newFile('gitRepo.json')
            ->withContent($json)
            ->at(vfsStreamWrapper::getRoot());
        
        $filename = vfsStream::url('parserTest/gitRepo.json');
        
        $sub_parser = $this->getMockBuilder('Raggle_Scm_Repository_Git_Parser')
            ->disableOriginalConstructor()
            ->getMock();
            
        $parser = new Raggle_Scm_Repository_Parser(array('git' => $sub_parser));
        
        $parser->parse($filename);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     * @expectedExceptionMessage Undefined index: git
     */
    function testParse_noSubParsers() {
        $json = '{'
            . '"name": "web",'
            . '"type": "git",'
            . '"url": "git://github.etsycorp.com/Engineering/Web.git",'
            . '"branches": [ "master" ]'
            . '}';
            
        vfsStream::setup('parserTest');
        vfsStream::newFile('gitRepo.json')
            ->withContent($json)
            ->at(vfsStreamWrapper::getRoot());
        
        $filename = vfsStream::url('parserTest/gitRepo.json');
            
        $parser = new Raggle_Scm_Repository_Parser(array());
        
        $parser->parse($filename);
    }
}
