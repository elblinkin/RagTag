<?php

namespace RagTag\Printer;

require_once 'Autoload.php';
require_once 'vfsStream/vfsStream.php';

class FileTest extends \PHPUnit_Framework_TestCase {

    function testWrite() {
        \vfsStream::setup('fileTest');
        \vfsStream::newFile('console.log')->at(\vfsStreamWrapper::getRoot());
        
        $filename = \vfsStream::url('fileTest/console.log');
        $fp = fopen($filename, 'a');
        $printer = new File($fp);
        $printer->write('Hello World');
        
        $this->assertEquals('Hello World', file_get_contents($filename));
    }
}
