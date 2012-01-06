<?php

namespace Taggle\Blamer;

require_once 'Autoload.php';

class GitTest extends \PHPUnit_Framework_TestCase {

    private $sha;
    private $source_root;
    private $normalizer;
    private $executor;
    
    private $blamer;
    
    function setUp() {
        parent::setUp();
        $this->sha = "myfakesha";
        $this->source_root = "/home/auto";
        $this->normalizer = $this->getMockBuilder('Taggle\Normalizer\FileName')
            ->disableOriginalConstructor()
            ->getMock();
        $this->executor = $this->getMockBuilder('RagTag\Executor')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->blamer = new Git(
            $this->sha,
            $this->source_root,
            $this->normalizer,
            $this->executor
        );
    }
    
    function testGetBlame_noEndLine() {
        $filename = 'this.php';
        $start_line = 12;
        
        $this->normalizer
            ->expects($this->once())
            ->method('normalize')
            ->with($filename)
            ->will($this->returnValue($filename));
        
        $this->executor
            ->expects($this->once())
            ->method('execute')
            ->with("cd $this->source_root; wc -l $filename", null);
            
        $this->assertEmpty(
            $this->blamer->getBlame($filename, $start_line)
        );       
    }
}