<?php

namespace Raggle\Scm\Repository;

require_once 'Autoload.php';
require_once 'vfsStream/vfsStream.php';

class ParserTest extends \PHPUnit_Framework_TestCase {

    function testParse() {
        $json = '{'
            . '"name": "web",'
            . '"type": "git",'
            . '"url": "git://github.com/Engineering/Web.git",'
            . '"branches": [ "master" ]'
            . '}';
            
        \vfsStream::setup('parserTest');
        \vfsStream::newFile('gitRepo.json')
            ->withContent($json)
            ->at(\vfsStreamWrapper::getRoot());
        
        $filename = \vfsStream::url('parserTest/gitRepo.json');
            
        $repo = $this->getMockBuilder('Raggle\Scm\Repository\Git')
            ->disableOriginalConstructor()
            ->getMock();
        
        $sub_parser = $this->getMockBuilder('Raggle\Scm\Repository\Git\Parser')
            ->disableOriginalConstructor()
            ->getMock();
        $sub_parser
            ->expects($this->atLeastOnce())
            ->method('parse')
            ->with(json_decode($json))
            ->will($this->returnValue($repo));
            
        $parser = new Parser(array('git' => $sub_parser));
        
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
            . '"url": "svn://github.com/Engineering/Web",'
            . '"branches": [ "master" ]'
            . '}';
            
        \vfsStream::setup('parserTest');
        \vfsStream::newFile('gitRepo.json')
            ->withContent($json)
            ->at(\vfsStreamWrapper::getRoot());
        
        $filename = \vfsStream::url('parserTest/gitRepo.json');
        
        $sub_parser = $this->getMockBuilder('Raggle\Scm\Repository\Git\Parser')
            ->disableOriginalConstructor()
            ->getMock();
            
        $parser = new Parser(array('git' => $sub_parser));
        
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
            . '"url": "git://github.com/Engineering/Web.git",'
            . '"branches": [ "master" ]'
            . '}';
            
        \vfsStream::setup('parserTest');
        \vfsStream::newFile('gitRepo.json')
            ->withContent($json)
            ->at(\vfsStreamWrapper::getRoot());
        
        $filename = \vfsStream::url('parserTest/gitRepo.json');
            
        $parser = new Parser(array());
        
        $parser->parse($filename);
    }
}
