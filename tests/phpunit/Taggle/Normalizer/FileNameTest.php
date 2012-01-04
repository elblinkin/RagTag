<?php

namespace Taggle\Normalizer;

require_once 'Autoload.php';

class FileNameTest extends \PHPUnit_Framework_TestCase {

    function testNormalize_noTopLevel() {
        $normailzer = new FileName();
        $this->assertEquals(
            'my/file/lives/here/file.php',
            $normailzer->normalize('my/file/lives/here/file.php')
        );
    }
    
    function testNormalize_oneTopLevelMatches() {
        $normalizer = new FileName(array('lives/here'));
        $this->assertEquals(
            'lives/here/file.php',
            $normalizer->normalize('my/file/lives/here/file.php')
        );
    }
    
    function testNormalize_oneTopLevelNoMatch() {
        $normalizer = new FileName(array('does/not/live/here'));
        $this->assertEquals(
            'my/file/lives/here/file.php',
            $normalizer->normalize('my/file/lives/here/file.php')
        );
    }
    
    function testNormalize_secondTopLevelMatches() {
        $normalizer = new FileName(
            array(
                'does/not/live/here',
                'lives/here',
            )
        );
        $this->assertEquals(
            'lives/here/file.php',
            $normalizer->normalize('my/file/lives/here/file.php')
        );
    }
}